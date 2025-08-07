<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Delivery;
use app\models\Orders;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with(['order.user', 'order.orderItems.items']);


        $data = [
            'title' => 'Delivery',
            'deliveries' => $deliveries
        ];

        return $this->view('admin/delivery/index', $data);
    }

    public function create()
    {
        $orders = Orders::whereMany(['status' => 'assembled']);
        $orders = Orders::with(['user']);

        $data = [
            'title' => 'Add delivery',
            'orders' => $orders
        ];

        return $this->view('admin/delivery/create', $data);
    }

    public function store(Request $request)
    {
        $delivery = $request->validate([
            'order_id' => 'required',
            'delivery_method' => 'required',
            'status' => 'required',
            'scheduled_date' => 'required',
            'remarks' => 'required',
            'driver_name' => 'required_name'
        ]);

        if (Delivery::insert($delivery)) {
            setSweetAlert('success', 'Success!', 'Added to delivery.');
        } else {
            setSweetAlert('error', 'Oops!', 'Something went wrong. Please try again.');
        }

        redirect('/admin/delivery');
    }
}
