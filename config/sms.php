<?php

/*-----------------------------------------------------------
 | SMS CONFIGURATION (TextBee)
 |-----------------------------------------------------------
 |
 | Holds API connection details for the TextBee SMS service.
 | Values are pulled from environment variables for security
 | and flexibility between environments.
 |
 */

return [
    'api_base'  => env('TEXTBEE_API_BASE'),
    'device_id' => env('TEXTBEE_DEVICE_ID'),
    'api_key'   => env('TEXTBEE_API_KEY')
];