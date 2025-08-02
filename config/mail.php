<?php

/*-----------------------------------------------------------
 | MAIL CONFIGURATION FILE
 |-----------------------------------------------------------
 |
 | This file returns an array of mail settings used by
 | the application's mailer service. All values are loaded
 | from environment variables defined in the .env file.
 | This allows flexible setup for different environments.
 |
 */

return [
    'host'      => env('MAIL_HOST'),
    'port'      => env('MAIL_PORT'),
    'username'  => env('MAIL_USERNAME'),
    'password'  => env('MAIL_PASSWORD'),
    'from'      => env('MAIL_FROM'),
    'from_name' => env('MAIL_FROM_NAME')
];
