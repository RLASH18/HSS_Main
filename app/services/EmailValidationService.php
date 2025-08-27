<?php

namespace app\services;

class EmailValidationService
{
    private static $apiKey;
    private static $baseUrl;

    /**
     * Initialize API key and base URL from environment variables
     */
    private static function init()
    {
        if (!self::$apiKey) {
            self::$apiKey = env('ABSTRACT_EMAIL_API_KEY');
        }

        if (!self::$baseUrl) {
            self::$apiKey = env('ABSTRACT_EMAIL_URL', 'https://emailvalidation.abstractapi.com/v1/');
        }
    }

    /**
     * Verify if an email address is valid and deliverable
     * 
     * @param string $email The email address to verify
     * @return array Result with validation status and details
     */
    public static function verifyEmail($email)
    {
        self::init();

        if (!self::$apiKey) {
            return [
                'valid' => true,
                'error' => 'AbstractAPI key not configured'
            ];
        }

        $url = self::$baseUrl . '?' . http_build_query([
            'api_key' => self::$apiKey,
            'email'   => $email
        ]);

        try {
            // Initialized cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'HSS-Main/1.0');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                return [
                    'valid' => true, // Fail-safe
                    'error' => 'Network error: ' . $error
                ];
            }

            if ($httpCode !== 200) {
                return [
                    'valid' => true, // Fail-safe
                    'error' => 'API error: HTTP ' . $httpCode
                ];
            }

            $data = json_decode($response, true);

            if (!$data) {
                return [
                    'valid' => true, // Fail-safe
                    'error' => 'Invalid API response'
                ];
            }

            return self::parseApiResponse($data, $email);

        } catch (\Exception $e) {
            return [
                'valid' => true, // Fail-safe
                'error' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Parse AbstractAPI response and determine email validity
     * 
     * @param array $data API response data
     * @param string $email Original email address
     * @return array Parsed validation result
     */
    private static function parseApiResponse($data, $email)
    {
        // Determine if email is valid
        $isValidFormat = $data['is_valid_format']['value'] ?? false;
        $isDisposable = $data['is_disposable_email']['value'] ?? false;
        $deliverability = $data['deliverability'] ?? 'UNKNOWN';
        $hasMx = $data['is_mx_found']['value'] ?? false;

        // Email is valid if it has proper format, isn't disposable, is deliverable/risky, and has MX records
        $isValid = $isValidFormat && !$isDisposable && in_array($deliverability, ['DELIVERABLE', 'RISKY']) && $hasMx;

        return [
            'valid'                 => $isValid,
            'email'                 => $data['email'] ?? $email,
            'autocorrect'           => $data['autocorrect'] ?? '',
            'deliverability'        => $deliverability,
            'quality_score'         => $data['quality_score'] ?? null,
            'is_valid_format'       => $isValidFormat,
            'is_free_email'         => $data['is_free_email']['value'] ?? null,
            'is_disposable_email'   => $isDisposable,
            'is_role_email'         => $data['is_role_email']['value'] ?? null,
            'is_catchall_email'     => $data['is_catchall_email']['value'] ?? null,
            'is_mx_found'           => $hasMx,
            'is_smtp_valid'         => $data['is_smtp_valid']['value'] ?? null
        ];
    }
}
