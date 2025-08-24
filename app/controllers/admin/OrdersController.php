<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Request;
use app\models\Billings;
use app\models\Inventory;
use app\models\Orders;
use app\services\MailService;

class OrdersController extends Controller
{
    /**
     * Display a list of all customer orders with their user and item data.
     */
    public function index()
    {
        // Eager-load user and nested item info
        $order = Orders::with(['user', 'orderItems.items']);

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

        // Check if this is a new order confirmation
        $isConfirmingOrder = ($status['status'] === 'confirmed' && $order->status !== 'confirmed');

        // Simple inventory check for each order item
        if ($isConfirmingOrder) {
            foreach ($order->orderItems() as $orderItem) {
                $inventory = Inventory::find($orderItem->item_id);

                if (!$inventory || $inventory->quantity < $orderItem->quantity) {
                    setSweetAlert(
                        'error',
                        'Insufficient Stock!',
                        "Only " . ($inventory ? $inventory->quantity : 0) . " items available, but customer ordered {$orderItem->quantity}."
                    );
                    redirect('/admin/orders');
                    return;
                }
            }
        }

        // Update order status
        if (Orders::update($id, $status)) {
            // On first confirmation: calculate total, notify customer, and generate billing
            if ($isConfirmingOrder) {
                $total = $order->calculateTotal();
                Orders::update($order->id, ['total_amount' => $total]);

                $this->sendOrderConfirmationEmail($order);
                $this->generateBilling($order);
            }
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
            $billings = [
                'order_id'       => $order->id,
                'payment_method' => $order->payment_method ?? 'cash',
                'payment_status' => 'unpaid',
                'amount_paid'    => $order->total_amount,
                'issued_at'      => date('Y-m-d H:i:s')
            ];

            Billings::insert($billings);
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
