<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Billings;
use app\models\Inventory;
use app\models\Orders;
use app\models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $orders = Orders::count();
        $recentOrders = Orders::recent();

        $customers = User::countWhere(['role' => 'customer']);
        $newCustomers = User::recentWhere(['role' => 'customer']);

        $revenue = Billings::sum('amount_paid', ['payment_status' => 'paid']);

        $inventory = Inventory::count();
        $addedProducts = Inventory::recent();

        $data = [
            'title' => 'Dashboard',
            'orders' => $orders,
            'recentOrders' => $recentOrders,
            'customers' => $customers,
            'newCustomers' => $newCustomers,
            'revenue' => $revenue,
            'inventory' => $inventory,
            'addedProducts' => $addedProducts
        ];

        return $this->view('admin/dashboard', $data);
    }

    public function logout() 
    {
        logout();
        return redirect('/');
    }
}
