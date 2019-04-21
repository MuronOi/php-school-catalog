<?php

namespace App\Http;

use App\logger\Logger;

/**
 * Class Route
 * @package App\Http
 */
class Route implements RouteInterface
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $action;

    /**
     * Route constructor.
     * @param string $method
     * @param string $path
     * @param string $class
     * @param string $action
     */
    public function __construct(string $method, string $path, string $class, string $action)
    {
        $this->class = $class;
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
        (new Logger)->log('Requested Class: ' . $class . ' and Action: ' . $action);
    }

    /**
     * @return string
     */
    public function getClass() : string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getAction() : string
    {
        return $this->action;
    }

    /**
     * @param string $fullPath
     * @return bool
     */
    public function checkAction(string $fullPath) : bool
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

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function resolveParams(RequestInterface $request): array
    {
        $requestArr = explode('/', $request->getPath());
        $pathArr = explode('/', $this->path);
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
