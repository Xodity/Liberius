<?php

use Laramus\Liberius\Controllers\HomeController;
use Laramus\Liberius\Ancient\Uri;

/**
 * @access
 */
function handleRequest()
{
    $router = new Uri;
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $router->get("/", [HomeController::class, "index"]);
    $router->post("/", [HomeController::class, "store"]);
    $router->get("/show/{id}", [HomeController::class, "about"]);
    $router->post("/show/{id}", [HomeController::class, "update"]);

    $router->dispatch($uri, $method);
}

/**
 * @access private
 * Response 404 not found
 */
function handleNotFound()
{
    header('HTTP/1.0 404 Not Found');
    echo '404 Not Found';
}
