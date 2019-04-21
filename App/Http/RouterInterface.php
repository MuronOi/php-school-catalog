<?php

namespace App\Http;

/**
 * Interface RouterInterface
 * @package App\Http
 */
interface RouterInterface
{
    /**
     * @param string $method
     * @param string $path
     * @param string $controller
     * @param string $action
     * @return mixed
     */
    public function add(string $method, string $path, string $controller, string $action);

    /**
     * @param RequestInterface $request
     * @return RouteInterface
     */
    public function resolve(RequestInterface $request) : RouteInterface;
}
