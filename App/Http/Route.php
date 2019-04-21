<?php

namespace App\Http;

use App\logger\Logger;

class Route implements RouteInterface
{
    private $class;
    private $path;
    private $method;
    private $action;

    public function __construct(string $method, string $path, string $class, string $action)
    {
        $this->class = $class;
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
        (new Logger)->log('Requested Class: ' . $class . ' and Action: ' . $action);
    }

    public function getClass() : string
    {
        return $this->class;
    }

    public function getAction() : string
    {
        return $this->action;
    }

    public function isOk(string $fullPath) : bool
    {
        $fullPathArr = explode('/', $fullPath);
        $patternPath = explode('/', $this->path);

        $j = 0;
        if (count($fullPathArr) !== count($patternPath)){
            return false;
        }
        for ($i = 0; $i < count($fullPathArr); $i++){
            if ($fullPathArr[$i] === $patternPath[$i]) {
                $j++;
            } elseif (preg_match('/^\{(.+)\}$/', $patternPath[$j]) === 1){
                $j++;
            }
        }
        return ($j === count($fullPathArr)) ? true : false;
    }

    public function resolveParams(RequestInterface $request): array
    {
        $requestArr = explode('/', $request->getPath());
        $pathArr = explode('/', $this->path);
//        p($requestArr);
//        p($pathArr);
        $result = [];
        for ($i = 0; $i < count($pathArr); $i++){
            if (preg_match('/^\{(.+)\}$/', $pathArr[$i]) === 1){
                $bindName = trim($pathArr[$i], '{}');
                $result[$bindName] = $requestArr[$i];
            }
        }
        return $result;
    }
}
