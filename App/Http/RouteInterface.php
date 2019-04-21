<?php

namespace App\Http;

interface RouteInterface
{
    public function __construct(string $method, string $path, string $class, string $action);

    public function getClass() : string;

    public function getAction() : string;

    public function isOk(string $fullPath) : bool;

    public function resolveParams(RequestInterface $request) : array;
}
