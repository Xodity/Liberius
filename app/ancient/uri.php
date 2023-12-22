<?php

namespace Laramus\Liberius\Ancient;

class Uri
{
    public static function dispatchRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        self::dispatch($method);
    }

    protected static $routes = [
        "GET" => [],
        "POST" => [],
    ];

    public static function get($route, $handler)
    {
        self::$routes['GET'][$route] = $handler;
    }

    public static function post($route, $handler)
    {
        self::$routes['POST'][$route] = $handler;
    }

    public static function dispatch($method)
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = strtoupper($method);

        if (isset(self::$routes[$method][$uri])) {
            $handler = self::$routes[$method][$uri];

            if (is_callable($handler)) {
                $handler();
            } elseif (is_array($handler) && count($handler) == 2) {
                $requestData = [];

                if ($method === 'POST') {
                    $requestData = $_POST;
                    call_user_func_array([new $handler[0], $handler[1]], ["request" => (object) $requestData]);
                    exit;
                } elseif ($method === "GET") {
                    if ($_GET) {
                        $requestData = $_GET;
                        call_user_func_array([new $handler[0], $handler[1]], ["request" => (object) $requestData]);
                        exit;
                    }
                }

                $controller = new $handler[0];
                $action = $handler[1];
                $controller->$action();
                exit;
            }
        } else {
            $params = [];
            foreach (self::$routes[$method] as $route => $handler) {
                $routePattern = preg_replace('/\/\{([A-Za-z0-9_]+)\}/', '/([^/]+)', $route);
                $routePattern = str_replace('/', DIRECTORY_SEPARATOR, $routePattern);

                preg_match_all('/\{([^}]+)\}/', $route, $keyparams);

                $matches = [];
                if (preg_match('/^' . $routePattern . '$/', $uri, $matches)) {
                    $handlerParams = $handler;
                    foreach ($matches as $key => $match) {
                        if ($key !== 0) {
                            $handlerParams[] = $match;
                        }
                    }
                    $controller = new $handlerParams[0];
                    $action = $handlerParams[1];
                    $params = array_slice($handlerParams, 2);

                    $requestData = [];

                    if ($method === 'POST') {
                        $requestData = $_POST;
                    } elseif ($method === 'GET') {
                        if ($_GET) {
                            $requestData = $_GET;
                        }
                    }

                    $realparams = [];
                    foreach ($keyparams[1] as $i => $keyparam) {
                        $realparams[$keyparam] = $params[$i] ?? null;
                    }

                    $request = ["request" => (object) $requestData];
                    $combinedata = array_merge($requestData ? $request : [], $realparams);

                    call_user_func_array([$controller, $action], $combinedata);
                    return;
                }
            }

            self::handleNotFound();
        }
    }

    protected static function handleNotFound()
    {
        header('HTTP/1.0 404 Not Found');
        echo '404 Not Found';
    }
}