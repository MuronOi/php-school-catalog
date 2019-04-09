<?php

namespace App\logger;

class Logger implements LoggerInterface
{
    private static $logPath = __DIR__ . '/../../logs/';

    public function log($message, $logLevel = 'info')
    {
        $file = Logger::$logPath . date('Y_m_d_H' ). '.log' ;
        $prepMessage = sprintf( "[%s] Level: '%s'. Message: '%s'" . PHP_EOL,
            date('Y-m-d H:s:i'), $logLevel, $message);
        file_put_contents($file, $prepMessage, FILE_APPEND);
     }
}
