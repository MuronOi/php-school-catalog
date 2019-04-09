<?php

namespace App\logger;

interface LoggerInterface
{
    public function log($message, $logLevel);
}