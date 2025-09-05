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
            $this->notifyDeliveryDay(
                $deliveries['order_id'],
                $deliveries['scheduled_date'],
                $deliveries['delivery_method'],
                $deliveries['driver_name']
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
            $this->notifyDeliveryDay(
                $deliveries['order_id'],
                $deliveries['scheduled_date'],
                $deliveries['delivery_method'],
                $deliveries['driver_name']
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
     *  Sends scheduled delivery/pickup SMS on the morning of the set date.
     */
    private function notifyDeliveryDay($orderId, $scheduledDate, $deliveryMethod, $driverName)
    {
        $today = date('Y-m-d');
        $currentHour = (int) date('H'); // 24-hour format

        // Only run if today is the scheduled day and it's between 7AM–8AM
        if ($today === $scheduledDate && $currentHour >= 7 && $currentHour < 9) {
            $order = Orders::find($orderId);
            if (!$order) return;

            $user = $order->user();
            if (!$user || empty($user->contact_number)) return;

            $phone = $user->contact_number;

            if ($deliveryMethod === 'delivery') {
                $msg = "Hi {$user->name}, your order #{$order->id} is scheduled for delivery today. Driver: {$driverName}. Thank you for building with us!\n\n🚚 [ABG Prime Builders Supplies Inc.]";
            } elseif ($deliveryMethod === 'pickup') {
                $msg = "Hi {$user->name}, your order #{$order->id} is ready for pickup today. We look forward to seeing you!\n\n📦 [ABG Prime Builders Supplies Inc.]";
            } else {
                return;
            }

            SmsService::sendSms($phone, $msg);
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
                'id' => $delivery->id,
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
