<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\models\Inventory;

class CustomerController extends Controller
{
    public function index()
    {
        $items = Inventory::all();

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | Customer Dashboard',
            'items' => $items,
        ];

        return $this->view('customer/index', $data);
    }

    public function show($id)
    {
        $items = $this->findItemOrFail($id);

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | ' . $items->item_name,
            'items' => $items,
        ];

        return $this->view('customer/show', $data);
    }

    private function findItemOrFail($id)
    {
        $items = Inventory::find($id);

        if (!$items) {
            setSweetAlert('error', 'Oops!', 'Item not found.');
            redirect('/customer/home');
        }

        return $items;
    }
}