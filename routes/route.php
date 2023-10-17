<?php
use Laramus\Liberius\Ancient\Uri;
use Laramus\Liberius\Controllers\HomeController;
// ----------------------------------------------------------------
/**
 * this is index specific for public instances of this Framework
 * Handle the request using the routes defined in routes.php
 * Copyright (MIT) 2023 - 2024, Laramus Organization and contributors
 */
// ----------------------------------------------------------------

# Directory Separator
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'ancient' . DIRECTORY_SEPARATOR . 'uri.php';

Uri::get("/", [HomeController::class, "index"]);
Uri::post("/", [HomeController::class, "store"]);
Uri::get("/show/{id}", [HomeController::class, "about"]);
Uri::post("/show/{id}", [HomeController::class, "update"]);
