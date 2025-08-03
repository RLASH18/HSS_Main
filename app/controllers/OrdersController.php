<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Orders;

class OrdersController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Customer Orders',
            'orders' => Orders::with(['user', 'orderItems.item'])
        ];

        return $this->view('admin/orders/index', $data);
    }

    public function show($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            setSweetAlert('error', 'Oops!', 'Order not found.');
            redirect('/admin/orders/');
            return;
        }

        $data = [
            'title' => 'Order Details',
            'order' => $order
        ];

        return $this->view('admin/orders/show', $data);
    }

    public function updateStatus(Request $request, $id)
    {
        $items = $request->validate([
            'status' => 'required'
        ]);

        if (Orders::update($id, $items)) {
            setSweetAlert('success', 'Updated!', 'Order status updated successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to update the order status.');
        }

        redirect('/admin/orders');
    }

    public function cancel($id)
    {
        if (Orders::update($id, ['status' => 'cancelled'])) {
            setSweetAlert('success', 'Cancelled!', 'Order cancelled successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to cancel order.');
        }

        redirect('/admin/orders');
    }
}
