<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\models\Billings;

class BillingController extends Controller
{
    /**
     * Display a list of all billings with their associated orders.
     */
    public function index()
    {
        // Retrieve all billings with their related order data
        $billings = Billings::with(['orders']);

        $data = [
            'title' => 'Billings',
            'billings' => $billings
        ];

        return $this->view('admin/billings/index', $data);
    }

    public function show($id)
    {
        $data = [
            'title' => 'Billing Details'
        ];

        return $this->view('admin/billings/show', $data);
    }
}
