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
        $this->routes[$method][$path] = new Route($controller, $action);

        $this->logger->log('Route add - ' . $this->routes[$method][$path]->getClass() .
            ' at path: ' . $path . ' and with method: ' . $method);
    }

    public function resolve(RequestInterface $request) : RouteInterface
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        $this->logger->log('Requested route: ' . $path . ' Requested path: ' . $path);

        try {
            if (!isset($this->routes[$method][$path])) {
                 throw new \Exception('Route not found');
            }
        } catch (\Exception $e) {
            $this->logger->log('Route not found: ' . $path, 'alert');
            throw new RouteNotFoundException();
        } catch (\Error $e) {
            $this->logger->log('Route not found: ' . $path, 'emergency');
            throw new RouteNotFoundException();
        }

        return $this->routes[$method][$path];
    }
}
