<?php

namespace App\Http;

use App\logger\Logger;

class Route implements RouteInterface
{
    private $class;
    private $action;

    public function __construct(string $class, string $action)
    {
        $this->class = $class;
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
}
