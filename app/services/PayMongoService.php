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
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/',
        ]);

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
     * Create a new PayMongo payment source (e.g., GCash, GrabPay, Bank Transfer)
     * 
     * @param string $type Payment type (gcash, grab_pay, paymaya, etc.)
     * @param int    $amount Amount in centavos (e.g., 10000 = ₱100.00)
     * @param string $description Description of payment (default: "Payment")
     * 
     * @return array API response with payment source details
     */
    public function createSource(string $type, int $amount, string $description = 'Payment')
    {
        return $this->request('POST', 'sources', [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'currency' => 'PHP',
                    'type' => $type,
                    'description' => $description,  // Reference (e.g., Order ID)
                    'redirect' => [                 // Redirect URLs after payment
                        'success' => 'http://localhost:8000/customer/payment-success',
                        'failed'  => 'http://localhost:8000/customer/payment-failed'
                    ]
                ]
            ]
        ]);
    }

    /**
     * Retrieve payment source details using its ID
     * 
     * @param string $sourceId PayMongo source ID
     * @return array|null Source details or null if request fails
     */
    public function getSource(string $sourceId)
    {
        try {
            return $this->request('GET', "sources/{$sourceId}");
        } catch (\Exception $e) {
            return  null;
        }
    }

    /**
     * Check if a payment source is ready to be charged (successful)
     * 
     * @param string $sourceId PayMongo source ID
     * @return bool True if payment is successful, false otherwise
     */
    public function isPaymentSuccessful(string $sourceId): bool
    {
        // Retrieve source info
        $source = $this->getSource($sourceId);

        // If source is invalid or status missing, return false
        if (!$source || !isset($source['data']['attributes']['status'])) {
            return false;
        }

        // Status "chargeable" means the payment is successful
        return $source['data']['attributes']['status'] === 'chargeable';
    }

    /**
     * Extract the order ID from the source description
     * (Assumes description follows format: "Order #123")
     * 
     * @param string $description Payment description text
     * @return int|null Extracted Order ID or null if not found
     */
    public function extractOrderIdFromDescription(string $description): ?int
    {
        // Use regex to find "Order #123" pattern in description
        if (preg_match('/Order #(\d+)/', $description, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    /**
     * Parse and validate PayMongo webhook payload
     * (Webhook notifies your server of payment events)
     * 
     * @param string $payload Raw webhook JSON payload
     * @return array|null Parsed event data or null if invalid
     */
    public function parseWebhookPayload(string $payload): ?array
    {
        // Decode JSON payload
        $data = json_decode($payload, true);

        // Validate webhook structure
        if (!isset($data['data']['type']) || $data['data']['type'] !== 'event') {
            return null;
        }

        // Extract event type (e.g., "source.chargeable")
        $eventType = $data['data']['attributes']['type'] ?? '';
        if ($eventType !== 'source.chargeable') {
            return  null;
        }

        // Extract source information
        $sourceData = $data['data']['attributes']['data'] ?? [];
        $sourceId = $sourceData['id'] ?? '';
        $description = $sourceData['attributes']['description'] ?? '';

        if (!$sourceId || !$description) {
            return null;
        }

        // Return structured webhook data for processing
        return [
            'source_id' => $sourceId,
            'description' => $description,
            'order_id' => $this->extractOrderIdFromDescription($description)
        ];
    }
}
