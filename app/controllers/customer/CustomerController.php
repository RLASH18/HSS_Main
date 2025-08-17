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
}