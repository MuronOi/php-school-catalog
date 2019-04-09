<?php

namespace App\Database;

use App\logger\Logger;
use PDO;
use PDOException;

class Connection
{
    /**
     * @var PDO
     */
    protected $db;

    public function __construct($config)
    {
        $dbName = $config['db_name'];
        $host = $config['host'];
        $port = $config['port'];
        $dsn = "mysql:dbname=$dbName;host=$host;port=$port";

        $user = $config['username'];
        $password = $config['password'];

        try {
            $this->db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            (new Logger)->log('Connect does not work: ' . $e->getMessage(), 'emergency');
        };
    }

    public function getConnection()
    {
        return $this->db;
    }
}
