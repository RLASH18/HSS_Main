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

        // Save order and send payment to PayMongo
        $orderId = $this->storeOrderWithItems($data, $cartItems, true);
        $this->handlePayMongoPayment($orderId, $data['payment_method']);

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

        // Save order and send payment to PayMongo
        $orderId = $this->storeOrderWithItems($data, [$orderItem], false);
        $this->handlePayMongoPayment($orderId, $data['payment_method']);

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

    /**
     * Redirects customer to PayMongo checkout if online payment
     */
    private function handlePayMongoPayment(int $orderId, string $paymentMethod)
    {
        // Skip if payment method not supported
        if (!in_array($paymentMethod, ['gcash', 'bank_transfer'])) {
            return;
        }

        // Store order ID in session for test mode fallback
        $_SESSION['pending_order_id'] = $orderId;

        $paymongo = new PayMongoService();
        $order = Orders::find($orderId);
        $totalAmount = $order->total_amount * 100; // PayMongo expects cents

        $typeMapping = [
            'gcash' => 'gcash',
            'bank_transfer' => 'online_banking'
        ];

        $type = $typeMapping[$paymentMethod];

        $source = $paymongo->createSource($type, $totalAmount, "Order #{$orderId}");

        if (!empty($source['data']['attributes']['redirect']['checkout_url'])) {
            header('Location: ' . $source['data']['attributes']['redirect']['checkout_url']);
            exit;
        }

        setSweetAlert('error', 'Payment Failed', 'Unable to initiate payment.');
        redirect('/customer/my-orders');
    }

    /**
     * Callback for successful PayMongo payment redirect
     */
    public function paymentSuccess()
    {
        $sourceId = $this->extractSourceIdFromRequest();

        if ($sourceId) {
            // Handle production PayMongo payment verification
            $this->handleProductionPaymentVerification($sourceId);
        } else {
            $this->handleTestModePaymentConfirmation();
        }
    }

    /**
     * Callback for failed PayMongo payment redirect
     */
    public function paymentFailed()
    {
        setSweetAlert('error', 'Payment Failed', 'Your payment could not be completed.');
        redirect('/customer/my-orders');
    }

    /**
     * Extract source ID from PayMongo redirect parameters
     */
    private function extractSourceIdFromRequest(): ?string
    {
        return $_GET['source_id'] ?? $_GET['id'] ?? $_GET['source'] ?? null;
    }

    /**
     * Confirm PayMongo payment in production mode
     */
    private function handleProductionPaymentVerification(string $sourceId): void
    {
        $paymongo = new PayMongoService();

        // Validate payment with PayMongo API
        if (!$paymongo->isPaymentSuccessful($sourceId)) {
            setSweetAlert('error', 'Payment Failed', 'Payment verification failed');
            redirect('/customer/my-orders');
        }

        // Get order ID from PayMongo source
        $orderId = $this->getOrderIdFromPayMongoSource($paymongo, $sourceId);
        if (!$orderId) {
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
        if (!isset($_SESSION['pending_order_id'])) {
            $availableParams = implode(', ', array_keys($_GET));
            setSweetAlert('error', 'Payment Error', "Invalid payment confirmation. Available params: {$availableParams}");
            redirect('/customer/my-orders');
        }

        $orderId = $_SESSION['pending_order_id'];
        unset($_SESSION['pending_order_id']);

        $this->confirmOrderPayment($orderId, true);
    }

    /**
     * Fetch order ID from PayMongo source data
     */
    private function getOrderIdFromPayMongoSource(PayMongoService $paymongo, string $sourceId): ?int
    {
        $source = $paymongo->getSource($sourceId);
        if (!$source) {
            setSweetAlert('error', 'Payment Error', 'Unable to verify payment details');
            return null;
        }

        // Order ID is embedded in source description
        $description = $source['data']['attributes']['description'] ?? '';
        $orderId = $paymongo->extractOrderIdFromDescription($description);

        if (!$orderId) {
            setSweetAlert('error', 'Payment Error', 'Unable to identify order from payment');
            return null;
        }

        return $orderId;
    }

    /**
     * Confirm order payment (both prod + test)
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
        $webhookData = $paymongo->parseWebhookPayload($payload);

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