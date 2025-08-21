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

        return $this->view('admin/delivery/index', [
            'title' => 'Delivery',
            'deliveries' => $deliveries
        ]);
    }

    /**
     * Show form for adding new delivery
     */
    public function create()
    {
        // Get all orders with status 'assembled'
        $orders = Orders::whereMany(['status' => 'assembled']);

        // Load user data for each order
        foreach ($orders as $o) {
            $o->user = $o->user();
        }

        return $this->view('admin/delivery/create', [
            'title' => 'Add Delivery',
            'orders' => $orders
        ]);
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

        return $this->view('admin/delivery/show', [
            'title' => 'Delivery Info',
            'deliveries' => $deliveries
        ]);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $deliveries = $this->findDeliveryOrFail($id);

        // Get all orders with status 'assembled' for the dropdown
        $orders = Orders::whereMany(['status' => 'assembled']);

        // Also include the current delivery's order if it's not already in the list
        $currentOrder = Orders::find($deliveries->order_id);
        if ($currentOrder && !in_array($currentOrder->id, array_column($orders, 'id'))) {
            $orders[] = $currentOrder;
        }

        return $this->view('admin/delivery/update', [
            'title' => 'Edit Delivery Info',
            'deliveries' => $deliveries,
            'orders' => $orders
        ]);
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

        return $this->view('admin/delivery/delete', [
            'title' => 'Delete Delivery Info',
            'deliveries' => $deliveries
        ]);
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
