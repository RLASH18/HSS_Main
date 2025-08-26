<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\models\Inventory;
use app\models\User;

class CustomerController extends Controller
{
    /**
     * Display the customer dashboard with all available inventory items.
     */
    public function index()
    {
        $items = Inventory::all();

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | Customer Dashboard',
            'items' => $items,
        ];

        return $this->view('customer/index', $data);
    }

    /**
     * Display details of a specific inventory item by ID.
     */
    public function show($id)
    {
        $items = Inventory::find($id);

        if (!$items) {
            setSweetAlert('error', 'Oops!', 'Item not found.');
            redirect('/customer/home');
        }

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | ' . $items->item_name,
            'items' => $items,
        ];

        return $this->view('customer/show', $data);
    }

    public function profile() {
        $users = User::where(['id'=> auth()->id]);
        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | My Profile',
            'users' => $users,
        ];
        return $this->view('customer/profile', $data);
    }

    public function logout()
    {
        
    }
}