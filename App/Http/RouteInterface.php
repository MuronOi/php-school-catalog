<?php

namespace App\Http;

/**
 * Interface RouteInterface
 * @package App\Http
 */
interface RouteInterface
{
    /**
     * RouteInterface constructor.
     * @param string $method
     * @param string $path
     * @param string $class
     * @param string $action
     */
    public function __construct(string $method, string $path, string $class, string $action);

    /**
     * @return string
     */
    public function getClass() : string;

    /**
     * @return string
     */
    public function getAction() : string;

    /**
     * @param string $fullPath
     * @return bool
     */
    public function checkAction(string $fullPath) : bool;

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function resolveParams(RequestInterface $request) : array;
}
