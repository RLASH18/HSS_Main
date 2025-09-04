<?php

namespace app\services;

use GuzzleHttp\Client;

class PayMongoService
{
    protected $client;
    protected $secretKey;

    /**
     * Initialize HTTP client and set PayMongo secret key
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.paymongo.com/v1/']);
        $this->secretKey = env('PAYMONGO_SECRET_KEY');
    }

    /**
     * General request handler for PayMongo API calls
     * 
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $uri API endpoint (e.g., "sources")
     * @param array  $data Request body (if applicable)
     * 
     * @return array Decoded JSON response from PayMongo
     */
    private function request($method, $uri, $data = [])
    {
        // Send HTTP request to PayMongo with headers and data
        $response = $this->client->request($method, $uri, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->secretKey . ':'),
                'Content-Type'  => 'application/json'
            ],
            'json' => $data
        ]);

        // Return decoded response as associative array
        return json_decode($response->getBody(), true);
    }

    /**
     * Create a new PayMongo checkout session
     * 
     * @param array $lineItems Array of items with name, amount, currency, quantity
     * @param string $description Description of payment
     * @param array $paymentMethods Array of payment methods (e.g., ['gcash', 'card'])
     * @param string $successUrl URL to redirect after successful payment
     * @param string $cancelUrl URL to redirect after cancelled payment
     * @param array $metadata Optional metadata to store with the session
     * 
     * @return array API response with checkout session details
     */
    public function createCheckoutSession(array $lineItems, string $description = 'Payment', array $paymentMethods = ['gcash', 'card'], string $successUrl = null, string $cancelUrl = null, array $metadata)
    {
        // Set default URLS if not provided
        $successUrl = $successUrl ?: 'http://localhost:8000/customer/payment-success';
        $cancelUrl = $cancelUrl ?: 'http://localhost:8000/customer/payment-failed';

        return $this->request('POST', 'checkout_sessions', [
            'data' => [
                'attributes' => [
                    'send_email_receipt' => false,
                    'show_description' => true,
                    'show_line_items' => true,
                    'description' => $description,
                    'line_items' => $lineItems,
                    'payment_method_types' => $paymentMethods,
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                    'metadata' => $metadata
                ]
            ]
        ]);
    }

    /**
     * Retrieve checkout session details using its ID
     * 
     * @param string $sessionId PayMongo checkout session ID
     * @return array|null Session details or null if request fails
     */
    public function getCheckoutSession(string $sessionId)
    {
        try {
            return $this->request('GET', "checkout_sessions/{$sessionId}");
        } catch (\Exception $e) {
            return  null;
        }
    }

    /**
     * Retrieve checkout session details using its ID
     * 
     * @param string $sessionId PayMongo checkout session ID
     * @return array|null Session details or null if request fails
     */
    public function isCheckoutSessionPaid(string $sessionId): bool
    {
        // Retrieve source info
        $session = $this->getCheckoutSession($sessionId);

        // If source is invalid or status missing, return false
        if (!$session || !isset($session['data']['attributes']['payments'])) {
            return false;
        }

        $payments = $session['data']['attributes']['payments'];

        // Check if any payment has 'paid' status
        foreach ($payments as $payment) {
            if (isset($payment['attributes']['status']) && $payment['attributes']['status'] === 'paid') {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract the order ID from the session description or metadata
     * 
     * @param string $sessionId PayMongo checkout session ID
     * @return int|null Extracted Order ID or null if not found
     */
    public function extractOrderIdFromSession(string $sessionId): ?int
    {
        $session = $this->getCheckoutSession($sessionId);

        if (!$session) {
            return null;
        }

        $attributes = $session['data']['attributes'];

        // Try to get order ID from metadata first
        if (isset($attributes['metadata']['order_id'])) {
            return (int) $attributes['metadata']['order_id'];
        }

        // Fallback: try to extract from description
        $description = $attributes['description'] ?? '';
        if (preg_match('/Order #(\d+)/', $description, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    /**
     * Parse and validate PayMongo webhook payload for checkout sessions
     * 
     * @param string $payload Raw webhook JSON payload
     * @return array|null Parsed event data or null if invalid
     */
    public function parseCheckoutWebhookPayload(string $payload): ?array
    {
        // Decode JSON payload
        $data = json_decode($payload, true);

        // Validate webhook structure
        if (!isset($data['data']['type']) || $data['data']['type'] !== 'event') {
            return null;
        }

        // Extract event type (e.g., "checkout_session.payment.paid")
        $eventType = $data['data']['attributes']['type'] ?? '';
        if (!in_array($eventType, ['checkout_session.payment.paid', 'payment.paid'])) {
            return  null;
        }

        // Extract checkout session or payment information
        $eventData = $data['data']['attributes']['data'] ?? [];

        if ($eventType === 'checkout_session.payment.paid') {
            $sessionId = $eventData['id'] ?? '';
            $description = $eventData['attributes']['description'] ?? '';
            $metadata = $eventData['attributes']['metadata'] ?? [];

            return [
                'session_id' => $sessionId,
                'description' => $description,
                'metadata' => $metadata,
                'order_id' => $metadata['order_id']
            ];
        }

        return null;
    }
}
