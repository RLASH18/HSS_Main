<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Request;
use app\models\Delivery;
use app\models\Orders;
use app\services\SmsService;

class DeliveryController extends Controller
{
    /**
     * Show all deliveries with related order, user, and items
     */
    public function index()
    {
        // Eager load the related order, its user, and the items in that order
        $deliveries = Delivery::with(['order.user', 'order.orderItems.items']);

        $pendingDeliveries = Delivery::countWhere(['status' => 'scheduled']);
        $deliveriesCompleted = Delivery::countWhere(['status' => 'delivered']);
        $failedDeliveries = Delivery::countWhere(['status' => 'failed']);

        $data = [
            'title' => 'Delivery',
            'deliveries' => $deliveries,
            'pendingDeliveries' => $pendingDeliveries,
            'deliveriesCompleted' => $deliveriesCompleted,
            'failedDeliveries' => $failedDeliveries
        ];

        return $this->view('admin/delivery/index', $data);
    }

    /**
     * Show form for adding new delivery
     */
    public function create()
    {
        // Get all orders with status 'assembled'
        $orders = Orders::whereMany(['status' => 'assembled']);

        // Filter out orders that already have deliveries
        $orderWithoutDeliveries = [];
        foreach ($orders as $order) {
            $existingDelivery = Delivery::where(['order_id' => $order->id]);
            if (!$existingDelivery) {
                $orderWithoutDeliveries[] = $order;
            }
        }

        $data = [
            'title' => 'Add Delivery',
            'orders' => $orderWithoutDeliveries
        ];

        return $this->view('admin/delivery/create', $data);
    }

    /**
     * Store new delivery
     */
    public function store(Request $request)
    {
        $deliveries = $request->validate([
            'order_id' => 'required',
            'delivery_method' => 'required',
            'status' => 'required',
            'scheduled_date' => 'required',
            'remarks' => 'required',
            'driver_name' => 'required'
        ]);

        if (Delivery::insert($deliveries)) {
            // Sync order status
            $this->syncOrderStatus(
                $deliveries['order_id'],
                $deliveries['status'],
                $oldDeliveryStatus ?? null
            );
            
            setSweetAlert('success', 'Success', 'Delivery added successfully.');
        } else {
            setSweetAlert('error', 'Error', 'Failed to add delivery. Please try again.');
        }

        redirect('/admin/delivery');
    }

    /**
     * Show single delivery info
     */
    public function show($id)
    {
        $deliveries = $this->findDeliveryOrFail($id);

        $data = [
            'title' => 'Delivery Info',
            'deliveries' => $deliveries
        ];

        return $this->view('admin/delivery/show', $data);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $deliveries = $this->findDeliveryOrFail($id);

        // Get all orders with status 'assembled' for the dropdown
        $orders = Orders::whereMany(['status' => 'assembled']);

        $data = [
            'title' => 'Edit Delivery Info',
            'deliveries' => $deliveries,
            'orders' => $orders
        ];

        return $this->view('admin/delivery/update', $data);
    }

    /**
     * Update existing delivery
     */
    public function update(Request $request, $id)
    {
        $deliveries = $request->validate([
            'order_id' => 'nullable',
            'delivery_method' => 'required',
            'status' => 'required',
            'scheduled_date' => 'required',
            'remarks' => 'required',
            'driver_name' => 'required'
        ]);

        if (Delivery::update($id, $deliveries)) {
            // Sync order status
            $this->syncOrderStatus(
                $deliveries['order_id'],
                $deliveries['status'],
                $oldDeliveryStatus ?? null
            );

            setSweetAlert('success', 'Updated', 'Delivery details have been updated.');
        } else {
            setSweetAlert('error', 'Error', 'Couldn’t update delivery. Try again.');
        }

        redirect('/admin/delivery');
    }

    /**
     * Show delete confirmation
     */
    public function delete($id)
    {
        $deliveries = $this->findDeliveryOrFail($id);

        $data = [
            'title' => 'Delete Delivery Info',
            'deliveries' => $deliveries
        ];

        return $this->view('admin/delivery/delete', $data);
    }

    /**
     * Delete delivery permanently
     */
    public function destroy($id)
    {
        $deliveries = $this->findDeliveryOrFail($id);

        if (Delivery::delete($id)) {
            setSweetAlert('success', 'Deleted', 'Delivery has been successfully removed.');
        } else {
            setSweetAlert('error', 'Error', 'Failed to delete delivery. Please try again.');
        }

        redirect('/admin/delivery');
    }

    /**
     * Sync order status based on delivery status changes
     */
    private function syncOrderStatus($orderId, $newDeliveryStatus, $oldDeliveryStatus = null)
    {
        if (!$orderId) return;

        $order = Orders::find($orderId);
        if (!$order) return;

        // Enhanced status mapping with business logic
        $statusMapping = [
            'scheduled' => 'assembled',
            'rescheduled' => 'assembled',
            'in_transit' => 'shipped',
            'delivered' => 'delivered',
            'failed' => 'assembled' // Reset to assembled for retry
        ];

        $newOrderStatus = $statusMapping[$newDeliveryStatus] ?? null;

        // Only update if the mapping exists and status is different
        if ($newOrderStatus && $order->status !== $newOrderStatus) {
            Orders::update($orderId, ['status' => $newOrderStatus]);

            // Send SMS notification for status change
            $this->sendDeliveryStatusNotification($order, $newDeliveryStatus, $oldDeliveryStatus);
        }

        // Set actual delivery date when delivered
        if ($newDeliveryStatus === 'delivered' && $oldDeliveryStatus !== 'delivered') {
            Delivery::update($order->id, ['actual_delivery_date' => date('Y-m-d H:i:s')]);
        }

        // Handle failed delivery retry logic
        if ($newDeliveryStatus === 'failed' && $oldDeliveryStatus !== 'failed') {
            $this->handleFailedDelivery($orderId);
        }
    }

    /**
     * Handle failed delivery - reset for retry and notify
     */
    private function handleFailedDelivery($orderId)
    {
        $order = Orders::find($orderId);
        if (!$order) return;

        // Reset order to assembled status for retry
        Orders::update($orderId, ['status' => 'assembled']);

        // Update delivery remarks to indicate retry needed
        $delivery = Delivery::where(['order_id' => $orderId]);
        if ($delivery) {
            $currentRemarks = $delivery->remarks ?? '';
            $retryRemarks = $currentRemarks . "\n[RETRY NEEDED] Delivery failed on " . date('Y-m-d H:i:s');
            Delivery::update($delivery->id, ['remarks' => $retryRemarks]);
        }
    }

    /**
     * Send SMS notifications for key status changes
     */
    private function sendDeliveryStatusNotification($order, $newStatus, $oldStatus)
    {
        $user = $order->user();
        if (!$user || empty($user->contact_number)) return;

        // Only send notifications for key status changes
        $notificationStatuses = ['scheduled', 'in_transit', 'delivered', 'failed'];
        if (!in_array($newStatus, $notificationStatuses)) return;

        $messages = [
            'scheduled' => "Hi {$user->name}, your order #{$order->id} has been scheduled for delivery within the next 3 days. We'll notify you once it's on the way.\n\n📦 [ABG Prime Builders Supplies Inc.]",
            'in_transit' => "Hi {$user->name}, your order #{$order->id} is now out for delivery! Our driver will contact you shortly.\n\n🚚 [ABG Prime Builders Supplies Inc.]",
            'delivered' => "Hi {$user->name}, your order #{$order->id} has been successfully delivered! Thank you for building with us!\n\n✅ [ABG Prime Builders Supplies Inc.]",
            'failed' => "Hi {$user->name}, we couldn't deliver your order #{$order->id} today. We'll reschedule and contact you soon.\n\n📞 [ABG Prime Builders Supplies Inc.]"
        ];

        $message = $messages[$newStatus] ?? null;
        if ($message) {
            SmsService::sendSms($user->contact_number, $message);
        }
    }

    /**
     * Get calendar data for FullCalendar
     */
    public function getCalendarData()
    {
        // Get all deliveries with related data
        $deliveries = Delivery::with(['order.user', 'order.orderItems.items']);

        $events = [];

        foreach ($deliveries as $delivery) {
            // Get the first item name (or combine multiple items)
            $itemNames = [];
            foreach ($delivery->order->orderItems as $orderItem) {
                $itemNames[] = $orderItem->items->item_name;
            }

            //Show first 2 items
            $itemsText = implode(', ', array_slice($itemNames, 0, 2));
            if (count($itemNames) > 2) {
                $itemsText .= ' +' . (count($itemNames) - 2) . ' more';
            }

            // Set color based on status
            $color = match ($delivery->status) {
                'scheduled' => '#f59e0b', // yellow
                'rescheduled' => '#f97316', // orange
                'in_transit' => '#3b82f6', // blue
                'delivered' => '#10b981', // green
                'failed' => '#ef4444', // red
                default => '#6b7280' // gray
            };

            $events[] = [
                'id' => str_pad($delivery->id, 4, '0', STR_PAD_LEFT),
                'title' => $itemsText,
                'start' => $delivery->scheduled_date,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#FFFFFF',
                'extendedProps' => [
                    'customer' => $delivery->order->user->name,
                    'driver' => $delivery->driver_name,
                    'status' => ucfirst(str_replace('_', '', $delivery->status)),
                    'method' => ucfirst($delivery->delivery_method),
                    'remarks' => $delivery->remarks,
                    'total' => number_format($delivery->order->total_amount, 2),
                    'items' => $itemNames
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
        exit;
    }

    /**
     * Find delivery or show error
     */
    private function findDeliveryOrFail($id)
    {
        $deliveries = Delivery::find($id);

        if (!$deliveries) {
            setSweetAlert('error', 'Not Found', 'That delivery doesn’t exist.');
            redirect('admin/delivery');
        }

        return $deliveries;
    }
}
