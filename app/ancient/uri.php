<?php

namespace Laramus\Liberius\Ancient;
require_once __DIR__ . "/../../route/routes.php";

class Uri {
    protected $routes = [
        "GET" => [],
        "POST" => [],
    ];

    public function get($route, $handler)
    {
        // save route
        $this->routes['GET'][$route] = $handler;
    }
    public function post($route, $handler)
    {
        // save route
        $this->routes['POST'][$route] = $handler;
    }

    public function dispatch($uri, $method) 
    {
        $method = strtoupper($method);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];

            if(is_callable($handler)){
                // run clousure
                $handler();
            } elseif (is_array($handler) && count($handler) == 2) {
                $requestData = [];

                // get method and request
                if ($method === 'POST') {
                    $requestData = $_POST;
                    call_user_func_array([new $handler[0], $handler[1]],  [ "request" => (object) $requestData ]);
                    exit;
                }elseif ($method === "GET") {
                    if($_GET) {
                        $requestData = $_GET;
                        call_user_func_array([new $handler[0], $handler[1]],  [ "request" => (object) $requestData ]);
                        exit;
                    }
                }

                // exec view without params
                $controller = new $handler[0];
                $method = $handler[1];
                $controller->$method();
                exit;
            }
        } else {
            // exec view with params
            $params = [];
            foreach ($this->routes[$method] as $route => $handler) {
                $routePattern = preg_replace('/\/\{([A-Za-z0-9_]+)\}/', '/([^/]+)', $route);
                $routePattern = str_replace('/', '\/', $routePattern);

                // get key for params
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

                    // get method and request
                    if ($method === 'POST') {
                        $requestData = $_POST;
                    } elseif ($method === 'GET') {
                        if($_GET) {
                            $requestData = $_GET;
                        }
                    }

                    
                    $realparams = [];
                    foreach ($keyparams[1] as $i => $keyparam) {
                        $realparams[$keyparam] = $params[$i] ?? null;
                    }
                    
                    $request = ["request" => (object) $requestData ];

                    $combinedata = array_merge($requestData ? $request : [], $realparams);

                    call_user_func_array([$controller, $action],  $combinedata);
                    return;
                }
            }

            handleNotFound();
        } 
    }

}