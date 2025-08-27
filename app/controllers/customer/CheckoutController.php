<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\core\Request;
use app\models\Cart;
use app\models\Inventory;
use app\models\OrderItems;
use app\models\Orders;

class CheckoutController extends Controller
{
    protected $userId;

    public function __construct()
    {
        $this->userId = auth()->id;
    }

    /**
     * Show checkout page with selected or all cart items
     */
    public function checkout($cartIds = null)
    {
        // Get selected cart items (can be comma-separated IDs)
        $selectedCartIds = $cartIds ? explode(',', $cartIds) : [];
        $cartItems = [];

        // If specific items selected, get only those
        if (!empty($selectedCartIds)) {
            foreach ($selectedCartIds as $cartId) {
                $cart = Cart::find($cartId);
                if ($cart && $cart->user_id === $this->userId) {
                    $cartItems[] = $cart;
                }
            }
        }
        
        // If no valid selected items found, get all user's cart items
        if (empty($cartItems)) {
            $cartItems = Cart::whereMany(['user_id' => $this->userId]);
        }

        // Only show error if user truly has no cart items at all
        if (empty($cartItems)) {
            setSweetAlert('error', 'Empty Cart!', 'Your cart is empty. Please add some items first.');
            redirect('/customer/home');
        }

        // Compute subtotal
        $subtotal = 0;
        foreach ($cartItems as $cart) {
            $total = $cart->quantity * $cart->item->unit_price;
            $subtotal += $total;
        }

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | Checkout',
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'user' => auth()
        ];

        return $this->view('customer/checkout', $data);
    }

    /**
     * Place order: validate, create order, order items, update inventory
     */
    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'cart_ids' => 'required',
            'delivery_address' => 'required',
            'delivery_method' => 'required',
            'payment_method' => 'required'
        ]);

        // Extract cart IDs, store valid items, and track total amount
        $cartIds = explode(',', $data['cart_ids']);
        $cartItems = [];     
        $totalAmount = 0;                               

        // Validate cart items and calculate total
        foreach ($cartIds as $cartId) {
            $cart = Cart::find($cartId);
            if (!$cart || $cart->user_id !== $this->userId) {
                setSweetAlert('error', 'Invalid Cart!', 'Some cart items are invalid.');
                redirect('/customer/my-cart');
            }

            // Check stock availability
            if ($cart->quantity > $cart->item->quantity) {
                setSweetAlert('error', 'Insufficient Stock!', "Sorry, only {$cart->item->quantity} units of {$cart->item->item_name} are available.");
                redirect('/customer/my-cart');
            }

            // Add the cart item to the checkout list and update the running total amount
            $cartItems[] = $cart;
            $totalAmount += $cart->quantity * $cart->item->unit_price;
        }

        // Create order
        $orderData = [
            'user_id' => auth()->id,
            'total_amount' => $totalAmount,
            'payment_method' => $data['payment_method'],
            'delivery_method' => $data['delivery_method'],
            'delivery_address' => $data['delivery_address'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $orderId = Orders::insert($orderData, true);

        // Create order items and update inventory
        foreach ($cartItems as $cart) {
            // Create order item
            OrderItems::insert([
                'order_id' => $orderId,
                'item_id' => $cart->item_id,
                'quantity' => $cart->quantity,
                'unit_price' => $cart->item->unit_price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Update inventory quantity
            $newQuantity = $cart->item->quantity - $cart->quantity;
            Inventory::update($cart->item_id, ['quantity' => $newQuantity]);

            // Remove from cart
            Cart::delete($cart->id);
        }
        setSweetAlert('success', 'Order Placed!', 'Your order has been placed successfully. Order ID: ' . $orderId);
        redirect('/customer/my-orders');
    }
}
