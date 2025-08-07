<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Delivery;
use app\models\Orders;

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
        $orders = Orders::with(['user']);

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

        return $this->view('admin/delivery/update', [
            'title' => 'Edit Delivery Info',
            'deliveries' => $deliveries
        ]);
    }

    /**
     * Update existing delivery
     */
    public function update(Request $request, $id)
    {
        $deliveries = $request->validate([
            'order_id' => 'required',
            'delivery_method' => 'required',
            'status' => 'required',
            'scheduled_date' => 'required',
            'remarks' => 'required',
            'driver_name' => 'required'
        ]);

        if (Delivery::update($id, $deliveries)) {
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
