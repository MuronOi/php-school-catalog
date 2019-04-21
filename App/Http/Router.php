<?php

namespace App\Http;

use App\Exceptions\RouteNotFoundException;
use App\logger\Logger;

class Router implements RouterInterface
{
    protected $routes = [];
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    public function add(string $method, string $path, string $controller, string $action)
    {
        $method = strtoupper($method);

        $this->routes[$method][$path] = new Route($method, $path, $controller, $action);
        $this->logger->log('Route add - ' . $this->routes[$method][$path]->getClass() .
            ' at path: ' . $path . ' and with method: ' . $method);
    }


    public function resolve(RequestInterface $request) : RouteInterface
    {
//        p($this->routes);
        $method = $request->getMethod();
        $path = $request->getPath();
//        p($path);

        /** @var RouteInterface $route */
        foreach ($this->routes[$method] as $route){
            if ($route->isOk($path)) {
                $this->logger->log('Requested route: ' . $path . ' Requested path: ' . $path);
                return $route;
            }
        }
//        $this->logger->log('Requested route: ' . $path . ' Requested path: ' . $path);
//
//        try {
//            if (!isset($this->routes[$method][$path]) ) {
//                 throw new \Exception('Route not found');
//            } elseif (!$this->isOk($path)) {
//                return $this->routes[$method][$path . 'formId'];
//                exit;
//            }
//        } catch (\Exception $e) {
            $this->logger->log('Route not found: ' . $path, 'alert');
            throw new RouteNotFoundException();
//        } catch (\Error $e) {
//            $this->logger->log('Route not found: ' . $path, 'emergency');
//            throw new RouteNotFoundException();
//        }
    }
}
