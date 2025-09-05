<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Billings;
use app\models\Cart;
use app\models\Inventory;
use app\models\OrderItems;
use app\models\Orders;
use app\services\MailService;
use app\services\PayMongoService;

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
        $invalidIds = [];

        // If specific items selected, get only those
        if (!empty($selectedCartIds)) {
            foreach ($selectedCartIds as $cartId) {
                $cart = Cart::find($cartId);
                if ($cart && $cart->user_id === $this->userId) {
                    $cartItems[] = $cart;
                } else {
                    $invalidIds[] = $cartId;
                }
            }
        } else {
            // Only load all cart items if no specific IDs were provided
            $cartItems = Cart::whereMany(['user_id' => $this->userId]);
        }

        // Warn if some items were invalid, but still proceed with valid ones
        if (!empty($invalidIds)) {
            setSweetAlert('warning', 'Some items were skipped', 'Items with IDs: ' . implode(', ', $invalidIds) . ' are not valid.');
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

        // For cash payments, create order immediately
        if ($data['payment_method'] === 'cash') {
            $orderId = $this->storeOrderWithItems($data, $cartItems, true);
            setSweetAlert('success', 'Order Placed!', 'Your order has been placed successfully. Order ID: ' . $orderId);
            redirect('/customer/my-orders');
        }

        // For online payments, store data in session and redirect to PayMongo
        $this->handlePayMongoPayment($data, $cartItems, true);
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

        // For cash payments, create order immediately
        if ($data['payment_method'] === 'cash') {
            $orderId = $this->storeOrderWithItems($data, [$orderItem], false);
            setSweetAlert('success', 'Order Placed!', 'Your order has been placed successfully. Order ID: ' . $orderId);
            redirect('/customer/my-orders');
        }

        // For online payments, store data in session and redirect to PayMongo
        $this->handlePayMongoPayment($data, [$orderItem], false);
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

    /**
     * Redirects customer to PayMongo checkout if online payment
     */
    /**
     * Redirects customer to PayMongo checkout if online payment
     */
    private function handlePayMongoPayment(array $data, array $items, bool $fromCart)
    {
        // Skip if payment method not supported
        if (!in_array($data['payment_method'], ['gcash', 'bank_transfer'])) {
            return;
        }

        // Store order data in session for later use
        $_SESSION['pending_order_data'] = [
            'data' => $data,
            'items' => $items,
            'from_cart' => $fromCart
        ];

        $paymongo = new PayMongoService();
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item->quantity * $item->item->unit_price;
        }
        $totalAmount *= 100; // PayMongo expects cents

        // get order items for line items
        $lineItems = [];

        foreach ($items as $item) {
            $inventory = Inventory::find($item->item_id);
            $lineItems[] = [
                'name' => $inventory->item_name,
                'amount' => (int) ($item->item->unit_price * 100), // Convert to cent
                'currency' => 'PHP',
                'quantity' => (int) $item->quantity,
                'description' => $inventory->description ?? 'Order item'
            ];
        }

        // Map payment methods for checkout session
        $paymentMethodMapping = [
            'gcash' => 'gcash',
            'bank_transfer' => 'card'
        ];

        $paymentType = [$paymentMethodMapping[$data['payment_method']]];

        // Create checkout session with order metadata
        $orderRef = 'ORD-' . $this->userId . '-' . date('YmdHis');
        $orderId = $this->userId . time();
        $session = $paymongo->createCheckoutSession(
            $lineItems,
            $orderRef,
            $paymentType,
            'http://localhost:8000/customer/payment-success',
            'http://localhost:8000/customer/payment-failed',
            ['order_id' => $orderId, 'user_id' => $this->userId]
        );

        if (!empty($session['data']['attributes']['checkout_url'])) {
            redirect($session['data']['attributes']['checkout_url']);
        }

        setSweetAlert('error', 'Payment Failed', 'Unable to initiate payment.');
        redirect('/customer/my-orders');
    }

    /**
     * Callback for successful PayMongo payment redirect
     */
    public function paymentSuccess()
    {
        $sessionId = $this->extractSourceIdFromRequest();

        if ($sessionId) {
            // Handle production PayMongo payment verification
            $this->handleProductionPaymentVerification($sessionId);
        } else {
            // Check if we have pending order data in session (for test mode or missing session ID)
            if (isset($_SESSION['pending_order_data'])) {
                $this->handleTestModePaymentConfirmation();
            } else {
                // No session data found - payment may have already been processed
                setSweetAlert('success', 'Payment Already Processed', 'Your payment has been successfully processed.');
                redirect('/customer/my-orders');
            }
        }
    }

    /**
     * Callback for failed PayMongo payment redirect
     */
    public function paymentFailed()
    {
        // Clean up session data for failed payment
        if (isset($_SESSION['pending_order_data'])) {
            unset($_SESSION['pending_order_data']);
        }

        setSweetAlert('error', 'Payment Failed', 'Your payment could not be completed. No order was created and no inventory was affected.');
        redirect('/customer/my-orders');
    }

    /**
     * Extract source ID from PayMongo redirect parameters
     */
    private function extractSourceIdFromRequest(): ?string
    {
        return $_GET['session_id'] ?? $_GET['checkout_session_id'] ?? $_GET['cs_id'] ?? $_GET['source_id'] ?? null;
    }

    /**
     * Confirm PayMongo payment in production mode
     */
    private function handleProductionPaymentVerification(string $sessionId): void
    {
        $paymongo = new PayMongoService();

        // Check if it's a checkout session ID or legacy source ID
        if (strpos($sessionId, 'cs_') === 0) {
            // New checkout session
            if (!$paymongo->isCheckoutSessionPaid($sessionId)) {
                setSweetAlert('error', 'Payment Failed', 'Payment verification failed');
                redirect('/customer/my-orders');
            }

            // For production mode, we need to create the order after payment verification
            if (!isset($_SESSION['pending_order_data'])) {
                setSweetAlert('error', 'Payment Error', 'Order data not found in session');
                redirect('/customer/my-orders');
            }

            $pendingOrderData = $_SESSION['pending_order_data'];
            unset($_SESSION['pending_order_data']);

            $orderId = $this->storeOrderWithItems($pendingOrderData['data'], $pendingOrderData['items'], $pendingOrderData['from_cart']);
        }

        if (!$orderId) {
            setSweetAlert('error', 'Payment Error', 'Unable to create order after payment');
            redirect('/customer/my-orders');
        }

        // Confirm order
        $this->confirmOrderPayment($orderId);
    }

    /**
     * Confirm payment in test mode (fallback using session)
     */
    private function handleTestModePaymentConfirmation(): void
    {
        if (!isset($_SESSION['pending_order_data'])) {
            $availableParams = implode(', ', array_keys($_GET));
            setSweetAlert('error', 'Payment Error', "Invalid payment confirmation. Available params: {$availableParams}");
            redirect('/customer/my-orders');
        }

        $pendingOrderData= $_SESSION['pending_order_data'];
        unset($_SESSION['pending_order_data']);

        $orderId = $this->storeOrderWithItems($pendingOrderData['data'], $pendingOrderData['items'], $pendingOrderData['from_cart']);

        $this->confirmOrderPayment($orderId, true);
    }

    /**
     * Confirm order payment
     */
    private function confirmOrderPayment(int $orderId, bool $isTestMode = false): void
    {
        $order = Orders::find($orderId);

        // Validate ownership
        if (!$order || $order->user_id !== auth()->id) {
            setSweetAlert('error', 'Payment Error', 'Order not found or access denied');
            redirect('/customer/my-orders');
        }

        // Only Process if order is still pending
        if ($order->status !== 'pending') {
            setSweetAlert('info', 'Payment Already Processed', 'This payment has already been processed');
            redirect('/customer/my-orders');
        }

        // Update order status to confirmed
        Orders::update($orderId, [
            'status' => 'confirmed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Create billing record and send email order confirmation
        $this->createBillingForOrder($order);
        $this->sendOrderConfirmationEmail($order);

        $message = $isTestMode ? 'Your test payment has been confirmed and billing has been generated.' : 'Your payment has been confirmed and billing has been generated';

        setSweetAlert('success', 'Payment Confirmed', $message);
        redirect('/customer/my-orders');
    }

    /**
     * Create billing record for confirmed order
     */
    private function createBillingForOrder($order)
    {
        // Check if billing already exists
        $existingBilling = Billings::whereMany(['order_id' => $order->id]);

        if (empty($existingBilling)) {
            Billings::insert([
                'order_id' => $order->id,
                'payment_method' => $order->payment_method,
                'payment_status' => 'paid',
                'amount_paid' => $order->total_amount,
                'issued_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Send confirmation email to customer
     */
    private function sendOrderConfirmationEmail($order)
    {
        $user = $order->user();
        $order->loadItems();
        $items = $order->orderItems;

        $subject = 'Payment Confirmed - Your order details';
        $body = $this->view('emails/order-confirmed', [
            'user' => $user,
            'items' => $items,
            'order' => $order,
        ]);

        MailService::send($user->email, $subject, $body);
    }

    /**
     * Handle PayMongo webhook events (server → server confirmation)
     */
    public function paymentWebhook(Response $response)
    {
        // Get raw POST data
        $payload = file_get_contents('php://input');

        $paymongo = new PayMongoService();

        // Parse and validate webhook payload using service
        $webhookData = $paymongo->parseCheckoutWebhookPayload($payload);

        if (!$webhookData || !$webhookData['order_id']) {
            $response->setStatusCode(200);
            exit('OK');
        }

        // Find order
        $order = Orders::find($webhookData['order_id']);
        if (!$order) {
            $response->setStatusCode(200);
            exit('OK');
        }

        // Only process if order is still pending
        if ($order->status === 'pending') {
            // Update order status to confirmed
            Orders::update($webhookData['order_id'], [
                'status' => 'confirmed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Create billing record and send order confirmation
            $this->createBillingForOrder($order);
            $this->sendOrderConfirmationEmail($order);
        }

        $response->setStatusCode(200);
        exit('OK');
    }
}