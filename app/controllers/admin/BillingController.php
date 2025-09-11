<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\models\Billings;
use app\models\Inventory;
use app\models\OrderItems;
use app\models\Orders;

class BillingController extends Controller
{
    /**
     * Display a list of all billings with their associated orders.
     */
    public function index()
    {
        // Retrieve all billings with their related order data
        $billings = Billings::with(['orders']);

        // Successful and pending amounts
        $revenue = Billings::sum('amount_paid', ['payment_status' => 'paid']);
        $pending = Billings::sum('amount_paid', ['payment_status' => 'unpaid']);

        // Counts
        $paidCount = Billings::countWhere(['payment_status' => 'paid']);
        $total = Billings::count();

        $successRate = $total > 0 ? round(($paidCount / $total) * 100, 2) : 0;

        $data = [
            'title' => 'Billings',
            'billings' => $billings,
            'revenue' => $revenue,
            'pending' => $pending,
            'total' => $paidCount,
            'rate' => $successRate
        ];

        return $this->view('admin/billings/index', $data);
    }

    /**
     * Display billing details
     */
    public function show($id)
    {
        $billings = Billings::find($id);

        // Load the associated order with user and order items
        $order = null;
        $orderItems = [];

        if ($billings && $billings->order_id) {
            $order = Orders::find($billings->order_id);
            if ($order) {
                // Load user data
                $order->user = $order->user();

                // Load order items with inventory details
                $orderItems = OrderItems::whereMany(['order_id' => $order->id]);
                foreach ($orderItems as $item) {
                    $item->inventory = Inventory::find($item->item_id);
                }
            }
        }

        $data = [
            'title' => 'Billing Details',
            'billings' => $billings,
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return $this->view('admin/billings/show', $data);
    }
}
