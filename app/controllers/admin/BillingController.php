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

    public function show($id)
    {
        $data = [
            'title' => 'Billing Details'
        ];

        return $this->view('admin/billings/show', $data);
    }
}
