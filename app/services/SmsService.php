<?php

namespace app\services;

use app\core\Application;

class SmsService
{
    /**
     * Send SMS message to a recipient using TextBee API.
     *
     * @param string $to      Recipient phone number (in international format, e.g. +639...)
     * @param string $message The text message to send
     * @return bool           True if sent successfully, false otherwise
     */
    public static function sendSms(string $to, string $message): bool
    {
        $config = Application::$app->config['sms'];

        // Clean API base URL to avoid trailing slash issues
        $apiBase = rtrim($config['api_base'] ?? '', '/');
        $deviceId = $config['device_id'] ?? '';
        $apiKey = $config['api_key'] ?? '';

        if (!$apiBase || !$deviceId || !$apiKey) {
            error_log('SMS: Missing configuration (api_base/base, device_id or api_key).');
            return false;
        }

        // Build the full API endpoint URL to send SMS for the specified device
        $url = "{$apiBase}/{$deviceId}/send-sms";

        $postData = [
            'recipients' => [$to],
            'message' => $message,
        ];

        $ch = curl_init($url);                                              // Initialize cURL session with the target API URL

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                     // Return response as string instead of outputting directly
        curl_setopt($ch, CURLOPT_POST, true);                               // Use POST method
        curl_setopt($ch, CURLOPT_HTTPHEADER, [                              // Set required HTTP headers including API key and content type
            'x-api-key: ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));       // Attach JSON encoded POST data as the request body

        $response = curl_exec($ch);                                         // Execute the HTTP request
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);                  // Get HTTP status code of the response
        $curlErr  = curl_error($ch);                                        // Get any cURL error that occurred

        curl_close($ch);                                                    // Close the cURL session and free resources

        // If cURL encountered an error (e.g., network failure), log it and return false
        if ($curlErr) {
            error_log("SMS curl error: {$curlErr}");
            return false;
        }

        // If HTTP response status code indicates failure (non-2xx), log it and return false
        if ($httpcode < 200 || $httpcode >= 300) {
            error_log("SMS failed (HTTP {$httpcode}): {$response}");
            return false;
        }

        return true;
    }
}
