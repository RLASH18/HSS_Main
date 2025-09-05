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
        $movementData = $this->getItemMovementsData();

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
            'stockData' => $stockData,
            'movementData' => $movementData
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

    /**
     * Prepare slow/fast moving items data based on sales velocity analysis.
     * Analyzes item sales over the last 30 days to categorize movement speed.
     */
    private function getItemMovementsData()
    {
        // Get all inventory items
        $allItems = Inventory::all();

        // Get date range for analysis (last 30 days)
        $startDate = date('Y-m-d', strtotime('-30 days'));
        $endDate = date('Y-m-d');

        $itemMovement = [];

        // Analyze each items sales performance
        foreach ($allItems as $item) {
            // Get all order items for this inventory item in the last 30 days
            $allOrderItems = [];
            $allOrders = Orders::all();

            foreach ($allOrders as $order) {
                $orderDate = date('Y-m-d', strtotime($order->created_at));
                if ($orderDate >= $startDate && $orderDate <= $endDate) {
                    // Get order items for this order
                    $orderItems = $order->orderItems ?? [];
                    foreach ($orderItems as $orderItem) {
                        if ($orderItem->item_id === $item->id) {
                            $allOrderItems[] = $orderItem;
                        }
                    }
                }
            }

            // Calculate total quantity sold
            $totalSold = 0;
            foreach ($allOrderItems as $orderItem) {
                $totalSold += (int)$orderItem->quantity;
            }

            // Calculate movement rate (sold quantity / current stock)
            $currentStock = (int) $item->quantity;
            $movementRate = $currentStock > 0 ? ($totalSold / $currentStock) : 0;

            // Store item movement data
            $itemMovement[] = [
                'name' => $item->item_name,
                'category' => $item->category,
                'sold' => $totalSold,
                'stock' => $currentStock,
                'rate' => $movementRate
            ];
        }

        // Sort by movement rate
        usort($itemMovement, function ($a, $b) {
            return $b['rate'] <=> $a['rate'];
        });

        // Categories items
        $fastMoving = [];
        $slowMoving = [];

        foreach ($itemMovement as $item) {
            // Fast moving: movement rate > 0.2 (sold more than 20% of stock) OR sold > 10 items
            // Slow moving: movement rate < 0.05 (sold less than 5% of stock) AND stock > 50
            if (($item['rate'] > 0.2 || $item['sold'] > 10) && $item['sold'] > 0) {
                $fastMoving[] = $item;
            } elseif ($item['rate'] < 0.05 && $item['stock'] > 50) {
                $slowMoving[] = $item;
            }
        }

        // Limit to top 10 items in each category
        $fastMoving = array_slice($fastMoving, 0, 10);
        $slowMoving = array_slice($slowMoving, 0, 10);

        // Prepare data for chart
        $fastMovingLabels = [];
        $fastMovingData = [];
        $slowMovingLabels = [];
        $slowMovingData = [];

        foreach ($fastMoving as $item) {
            $fastMovingLabels[] = substr($item['name'], 0, 15) . (strlen($item['name']) > 15 ? '...' : '');
            $fastMovingData[] = $item['sold'];
        }

        foreach ($slowMoving as $item) {
            $slowMovingLabels[] = substr($item['name'], 0, 15) . (strlen($item['name']) > 15 ? '...' : '');
            $slowMovingData[] = $item['stock'];
        }

        return [
            'fastMoving' => [
                'labels' => $fastMovingLabels,
                'data' => $fastMovingData,
                'count' => count($fastMoving),
            ],
            'slowMoving' => [
                'labels' => $slowMovingLabels,
                'data' => $slowMovingData,
                'count' => count($slowMoving)
            ]
        ];
    }
}
