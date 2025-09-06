<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Request;
use app\models\Billings;
use app\models\Delivery;
use app\models\Orders;
use app\services\MailService;
use app\services\SmsService;

class OrdersController extends Controller
{
    /**
     * Display a list of all customer orders with their user and item data.
     */
    public function index()
    {
        // Get orders in descending order with eager loaded relationships
        $order = Orders::recentWith(['user', 'orderItems.items'], 'created_at', 'DESC', 1000);

        $data = [
            'title' => 'Customer Orders',
            'orders' => $order
        ];

        return $this->view('admin/orders/index', $data);
    }

    /**
     * Show a single order's details.
     */
    public function show($id)
    {
        $order = $this->findOrderOrFail($id);

        $data = [
            'title' => 'Order Details',
            'order' => $order
        ];

        return $this->view('admin/orders/show', $data);
    }

    /**
     * Update the status of an order, and adjust inventory if status changes to confirmed.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate incoming status field
        $status = $request->validate([
            'status' => 'required'
        ]);

        // Fetch order
        $order = $this->findOrderOrFail($id);
        $oldStatus = $order->status;

        // Check if this is a new order confirmation
        $isConfirmingOrder = ($status['status'] === 'confirmed' && $order->status !== 'confirmed');

        // Update order status
        if (Orders::update($id, $status)) {
            // On first confirmation: calculate total, notify customer, and generate billing
            if ($isConfirmingOrder) {
                $total = $order->calculateTotal();
                Orders::update($order->id, ['total_amount' => $total]);

                $this->sendOrderConfirmationEmail($order);
                $this->generateBilling($order);
            }

            // Handle status specific business logic
            $this->handleOrderStatusChange($id, $status['status'], $oldStatus);

            setSweetAlert('success', 'Updated!', 'Order status updated successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to update the order status.');
        }

        redirect('/admin/orders');
    }

    /**
     * Cancel the given order.
     */
    public function cancel($id)
    {
        $order = $this->findOrderOrFail($id);

        $status = [
            'status' => 'cancelled',
        ];

        if (Orders::update($order->id, $status)) {
            setSweetAlert('success', 'Cancelled!', 'Order cancelled successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to cancel order.');
        }

        redirect('/admin/orders');
    }

    /**
     * Send order confirmation email to customer
     */
    private function sendOrderConfirmationEmail($order)
    {
        // Fetch the customer who placed the order
        $user = $order->user();

        // Load the order items along with their related item details
        $order->loadItems();

        // Access the loaded order items
        $items = $order->orderItems;

        $subject = 'Order Confirmed - Your purchase details';
        $body = $this->view('emails/order-confirmed', [
            'user' => $user,
            'items' => $items,
            'order' => $order
        ]);

        MailService::send($user->email, $subject, $body);
    }

    /**
     * Creates a billing record for the given order.
     */
    private function generateBilling($order)
    {
        // Check if a billing already exists for the given order
        $existingBilling = Billings::whereMany(['order_id' => $order->id]);

        if (empty($existingBilling)) {
            // Determine payment status based on payment method and order source
            $paymentStatus = 'unpaid';

            if (in_array($order->payment_method, ['gcash', 'bank_transfer'])) {
                $paymentStatus = 'paid';
            }

            $billings = [
                'order_id'       => $order->id,
                'payment_method' => $order->payment_method ?? 'cash',
                'payment_status' => $paymentStatus,
                'amount_paid'    => $order->total_amount,
                'issued_at'      => date('Y-m-d H:i:s')
            ];

            Billings::insert($billings);
        }
    }

    /**
     * Handle business logic when order status changes
     */
    private function handleOrderStatusChange($orderId, $newStatus, $oldStatus)
    {
        // Auto-create delivery when order becomes 'assembled'
        if ($newStatus === 'assembled' && $oldStatus !== 'assembled') {
            $this->createDeliveryForOrder($orderId);
        }

        // Update existing delivery status when order status changes
        $this->syncDeliveryStatus($orderId, $newStatus, $oldStatus);
    }

    /**
     * Automatically create delivery record when order is assembled
     */
    private function createDeliveryForOrder($orderId)
    {
        // Check if deliver already exists
        $existingDelivery = Delivery::where(['order_id' => $orderId]);
        if ($existingDelivery) return;

        $order = Orders::find($orderId);
        if (!$order) return;

        // Create delivery with default scheduled status
        $deliveryData = [
            'order_id' => $orderId,
            'delivery_method' => $order->delivery_method,
            'status' => 'scheduled',
            'scheduled_date' => date('Y-m-d', strtotime('+3 days')), // Default to three days
            'remarks' => 'Auto created when order was assembled',
            'driver_name' => 'TBD' // To be determined
        ];

        if (Delivery::insert($deliveryData)) {
            // Send SMS notification to customer
            $this->sendStatusNotification($order, 'scheduled');
        }
    }

    /**
     * Sync delivery status based on order status changes with enhanced business logic
     */
    private function syncDeliveryStatus($orderId, $newOrderStatus, $oldOrderStatus)
    {
        // Find delivery record for this order
        $delivery = Delivery::where(['order_id' => $orderId]);
        if (!$delivery) return;

        // Enhanced status mapping with business login
        $statusMapping = [
            'shipped' => 'in_transit',
            'delivered' => 'delivered'
        ];

        $newDeliveryStatus = $statusMapping[$newOrderStatus] ?? null;

        // Only update if mapping exists and status is different
        if ($newDeliveryStatus && $delivery->status !== $newDeliveryStatus) {
            $updateData = ['status' => $newDeliveryStatus];

            // Set actual delivery date when delivered
            if ($newDeliveryStatus === 'delivered') {
                $updateData['actual_delivery_date'] = date('Y-m-d H:i:s');
            }

            Delivery::update($delivery->id, $updateData);

            // Send SMS notification
            $order = Orders::find($orderId);
            if ($order) {
                $this->sendStatusNotification($order, $newDeliveryStatus);
            }
        }
    }

    /**
     * Send SMS notifications for key status changes
     */
    private function sendStatusNotification($order, $deliveryStatus)
    {
        $user = $order->user();
        if (!$user || empty($user->contact_number)) return;

        $messages = [
            'scheduled' => "Hi {$user->name}, your order #{$order->id} is ready! Delivery scheduled for tomorrow. We'll notify you when it's out for delivery.\n\n📦 [ABG Prime Builders Supplies Inc.]",
            'in_transit' => "Hi {$user->name}, your order #{$order->id} is now out for delivery! Our driver will contact you shortly.\n\n🚚 [ABG Prime Builders Supplies Inc.]",
            'delivered' => "Hi {$user->name}, your order #{$order->id} has been successfully delivered! Thank you for building with us!\n\n✅ [ABG Prime Builders Supplies Inc.]",
            'failed' => "Hi {$user->name}, we couldn't deliver your order #{$order->id} today. We'll reschedule and contact you soon.\n\n📞 [ABG Prime Builders Supplies Inc.]"
        ];

        $message = $messages[$deliveryStatus] ?? null;
        if ($message) {
            SmsService::sendSms($user->contact_number, $message);
        }
    }

    /**
     * Finds an order by ID or redirects with an error if not found.
     */
    private function findOrderOrFail($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            setSweetAlert('error', 'Oops!', 'Order not found.');
            redirect('/admin/orders');
        }

        return $order;
    }
}
