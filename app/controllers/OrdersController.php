<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Inventory;
use app\models\Orders;
use app\services\MailService;

class OrdersController extends Controller
{
    /**
     * Display a list of all customer orders with their user and item data.
     */
    public function index()
    {
        $data = [
            'title' => 'Customer Orders',
            'orders' => Orders::with(['user', 'orderItems.items']) // Eager-load user and nested item info
        ];

        return $this->view('admin/orders/index', $data);
    }

    /**
     * Show a single order's details.
     */
    public function show($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            setSweetAlert('error', 'Oops!', 'Order not found.');
            redirect('/admin/orders/');
            return;
        }

        $data = [
            'title' => 'Order Details',
            'order' => $order
        ];

        return $this->view('admin/orders/show', $data);
    }

    /**
     * Update the status of an order, and adjust inventory if status changes to confirmed.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate incoming status field
        $status = $request->validate([
            'status' => 'required'
        ]);

        // Fetch order
        $order = Orders::find($id);

        if (!$order) {
            setSweetAlert('error', 'Oops!', 'Order not found.');
            redirect('/admin/orders/');
            return;
        }

        // Check if this is a new order confirmation
        $isConfirmingOrder = ($status['status'] === 'confirmed' && $order->status !== 'confirmed');

        // Simple inventory check for each order item
        if ($isConfirmingOrder) {
            foreach ($order->orderItems() as $orderItem) {
                $inventory = Inventory::find($orderItem->item_id);
                
                if (!$inventory || $inventory->quantity < $orderItem->quantity) {
                    setSweetAlert('error', 'Insufficient Stock!', "Only " . ($inventory ? $inventory->quantity : 0) . " items available, but customer ordered {$orderItem->quantity}.");
                    redirect('/admin/orders');
                    return;
                }
            }
        }

        // Update order status
        if (Orders::update($id, $status)) {
            // If confirming the order for the first time, deduct inventory and send email
            if ($isConfirmingOrder) {
                $this->updateInventoryQuantities($order);
                $this->sendOrderConfirmationEmail($order);
            }
            setSweetAlert('success', 'Updated!', 'Order status updated successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to update the order status.');
        }

        redirect('/admin/orders');
    }

    /**
     * Cancel the given order.
     */
    public function cancel($id)
    {
        $status = [
            'status' => 'cancelled'
        ];

        if (Orders::update($id, $status)) {
            setSweetAlert('success', 'Cancelled!', 'Order cancelled successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to cancel order.');
        }

        redirect('/admin/orders');
    }

    /**
     * Decrease inventory quantities based on the items in the order.
     */
    private function updateInventoryQuantities($order)
    {
        // Fetch all items associated with the given order
        $orderItems = $order->orderItems();

        foreach ($orderItems as $orderItem) {
            $inventoryItem = Inventory::find($orderItem->item_id);

            if ($inventoryItem) {
                // Deduct ordered quantity from inventory
                $newQuantity = $inventoryItem->quantity - $orderItem->quantity;

                // Prevent negative inventory
                $newQuantity = max(0, $newQuantity);

                Inventory::update($inventoryItem->id, [
                    'quantity' => $newQuantity
                ]);
            }
        }
    }

    /**
     * Send order confirmation email to customer
     */
    private function sendOrderConfirmationEmail($order)
    {
        // Fetch the customer who placed the order
        $user = $order->user();

        // Load the order items along with their related item details
        $order->loadItems();

        // Access the loaded order items
        $items = $order->orderItems;

        $subject = 'Order Confirmed - Your purchase details';

        $body = $this->mailView('order-confirmed', [
            'user' => $user,
            'items' => $items,
            'order' => $order
        ]);

        MailService::send($user->email, $subject, $body);
    }
}
