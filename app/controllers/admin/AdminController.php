<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\models\Billings;
use app\models\Inventory;
use app\models\Orders;
use app\models\User;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with summary stats and charts.
     */
    public function dashboard()
    {
        $orders = Orders::count();
        $recentOrders = Orders::recent();

        $customers = User::countWhere(['role' => 'customer']);
        $newCustomers = User::recentWhere(['role' => 'customer']);

        $revenue = Billings::sum('amount_paid', ['payment_status' => 'paid']);

        $inventory = Inventory::count();
        $addedProducts = Inventory::recent();

        $salesData = $this->getSalesChartData();
        $stockData = $this->getStockChartData();

        $data = [
            'title' => 'Dashboard',
            'orders' => $orders,
            'recentOrders' => $recentOrders,
            'customers' => $customers,
            'newCustomers' => $newCustomers,
            'revenue' => $revenue,
            'inventory' => $inventory,
            'addedProducts' => $addedProducts,
            'salesData' => $salesData,
            'stockData' => $stockData
        ];

        return $this->view('admin/dashboard', $data);
    }

    /**
     * Show the admin settings page.
     */
    public function settings()
    {
        return $this->view('admin/settings', [
            'title' => 'Settings'
        ]);
    }

    /**
     * Log out the current admin and redirect to homepage.
     */
    public function logout()
    {
        logout();
        return redirect('/');
    }

    /**
     * Prepare sales chart data for the last 6 months 
     * (monthly revenue and order count).
     */
    private function getSalesChartData()
    {
        // Initialize arrays for revenue, orders, and labels
        $monthlyRevenue = [];
        $monthlyOrders = [];
        $labels = [];

        // Loop through the last 6 months (including current)
        for ($i = 5; $i >= 0; $i--) {
            // $month = date('Y-m', strtotime("-$i months"));
            $monthName = date('M Y', strtotime("-$i months"));

            // Get start and end dates for the month
            $startDate = date('Y-m-01', strtotime("-$i months"));
            $endDate = date('Y-m-t', strtotime("-$i months"));

            // Get all billings and filter by month in PHP
            $allBillings = Billings::whereMany(['payment_status' => 'paid']);
            $monthlyRevenueAmount = 0;

            foreach ($allBillings as $billing) {
                $billingDate = date('Y-m-d', strtotime($billing->issued_at));
                if ($billingDate >= $startDate && $billingDate <= $endDate) {
                    $monthlyRevenueAmount += (float)$billing->amount_paid;
                }
            }

            // Get all orders and filter by month in PHP
            $allOrders = Orders::all();
            $monthlyOrderCount = 0;

            foreach ($allOrders as $order) {
                $orderDate = date('Y-m-d', strtotime($order->created_at));
                if ($orderDate >= $startDate && $orderDate <= $endDate) {
                    $monthlyOrderCount++;
                }
            }

            // Store results for chart
            $labels[] = $monthName;
            $monthlyRevenue[] = $monthlyRevenueAmount;
            $monthlyOrders[] = $monthlyOrderCount;
        }

        return [
            'labels' => $labels,
            'revenue' => $monthlyRevenue,
            'orders' => $monthlyOrders
        ];
    }

    /**
     * Prepare stock chart data by grouping inventory items by category.
     */
    private function getStockChartData()
    {
        // Get inventory data grouped by category using Model method
        $results = Inventory::groupBySum('category', 'quantity');

        // Arrays to store categories (labels) and their total quantities (data)
        $categories = [];
        $quantities = [];

        // Loop through each grouped row from the query result
        foreach ($results as $row) {
            // Only include categories with quantity > 0
            if ($row->total > 0) {
                $categories[] = ucfirst($row->group);
                $quantities[] = (int)$row->total;
            }
        }

        return [
            'labels' => $categories,
            'data' => $quantities,
        ];
    }
}