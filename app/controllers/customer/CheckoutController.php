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
     * Display checkout page with items from the cart
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
     * Process placing an order with selected cart items
     */
    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'cart_ids' => 'required',
            'delivery_address' => 'required',
            'delivery_method' => 'required',
            'payment_method' => 'required'
        ]);

        // Extract cart IDs, and store valid items
        $cartIds = explode(',', $data['cart_ids']);
        $cartItems = [];

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

            // Add the cart item to the checkout list
            $cartItems[] = $cart;
        }

        $orderId = $this->storeOrderWithItems($data, $cartItems, true);

        setSweetAlert('success', 'Order Placed!', 'Your order has been placed successfully. Order ID: ' . $orderId);
        redirect('/customer/my-orders');
    }

    /**
     * Display checkout page for a single buy now item
     */
    public function buyNow(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        // Get the item
        $item = Inventory::find($data['item_id']);
        if (!$item) {
            setSweetAlert('error', 'Item Not Found!', 'The selected item is no longer available.');
            redirect('/customer/home');
        }

        // Check stock availability
        if ($data['quantity'] > $item->quantity) {
            setSweetAlert('error', 'Insufficient Stock!', "Sorry, only {$item->quantity} units available.");
            redirect("/customer/item/{$item->id}");
        }

        // Create temporary order item data for checkout
        $orderItem = (object)[
            'item_id' => $item->id,
            'quantity' => $data['quantity'],
            'item' => $item,
            'total' => $data['quantity'] * $item->unit_price
        ];

        $subtotal = $orderItem->total;

        $checkoutData = [
            'title' => 'ABG Prime Builders Supplies Inc. | Buy Now',
            'orderItems' => [$orderItem],
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'user' => auth(),
            'buyNow' => true // Flag to indicate this is buy now flow
        ];

        return $this->view('customer/checkout', $checkoutData);
    }

    /**
     * Process placing an order directly from buy now
     */
    public function processBuyNow(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required',
            'delivery_method' => 'required',
            'payment_method' => 'required'
        ]);

        // Get and validate item
        $item = Inventory::find($data['item_id']);
        if (!$item) {
            setSweetAlert('error', 'Item Not Found!', 'The selected item is no longer available.');
            redirect('/customer/home');
        }

        // Check stock availability
        if ($data['quantity'] > $item->quantity) {
            setSweetAlert('error', 'Insufficient Stock!', "Sorry, only {$item->quantity} units available.");
            redirect("/customer/item/{$item->id}");
        }

        // Create temporary order item object for processing
        $orderItem = (object)[
            'id' => null,
            'item_id' => $item->id,
            'quantity' => $data['quantity'],
            'item' => $item
        ];

        $orderId = $this->storeOrderWithItems($data, [$orderItem], false);

        setSweetAlert('success', 'Order Placed!', 'Your order has been placed successfully. Order ID: ' . $orderId);
        redirect('/customer/my-orders');
    }

    /**
     * Create order record with its items
     */
    private function storeOrderWithItems(array $data, array $items, bool $fromCart): int
    {
        // Calculate total order amount
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item->quantity * $item->item->unit_price;
        }

        // Insert new order and get its ID
        $orderId = Orders::insert([
            'user_id' => $this->userId,
            'total_amount' => $totalAmount,
            'payment_method' => $data['payment_method'],
            'delivery_method' => $data['delivery_method'],
            'delivery_address' => $data['delivery_address'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ], true);

        // Insert each item into order_items and update stock
        foreach ($items as $item) {
            OrderItems::insert([
                'order_id' => $orderId,
                'item_id' => $item->item_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->item->unit_price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Update item quantity in inventory
            $newQuantity = $item->item->quantity - $item->quantity;
            Inventory::update($item->item_id, ['quantity' => $newQuantity]);

            // Remove item from cart if order came from cart
            if ($fromCart && isset($item->id)) {
                Cart::delete($item->id);
            }
        }

        // Return the newly created order ID
        return $orderId;
    }
}