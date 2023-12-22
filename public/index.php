<?php

use Laramus\Liberius\Ancient\Uri;
// ----------------------------------------------------------------
/**
 * This is index specific for public instances of this Framework
 * Handle the request using the routes defined in routes.php
 * Copyright (MIT) 2023 - 2024, Laramus Organization and contributors
 */
// ----------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'route.php';

Uri::dispatchRequest();