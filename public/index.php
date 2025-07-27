<?php

/*-----------------------------------------------------------
 | APPLICATION ENTRY POINT
 |-----------------------------------------------------------
 | 
 | This file serves as the front controller. It bootstraps
 | the core application, loads route definitions, and 
 | starts the routing and response cycle.
 |
 */

$app = require_once __DIR__ . '/../bootstrap/app.php';

require_once __DIR__ . '/../routes/web.php';

$app->run();