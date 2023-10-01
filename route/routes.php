<?php

use Laramus\Liberius\Controllers\HomeController;

/**
 * @access
 */
function handleRequest()
{
    // Mendapatkan URI permintaan saat ini
    $uri = $_SERVER['REQUEST_URI'];

    // route defined in swith route
    switch ($uri) {
        case '/':
            $controller = new HomeController();
            $controller->index();
            break;
        case '/about':
            $controller = new HomeController();
            $controller->about();
            break;
        default:
            handleNotFound();
            break;
    }
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
