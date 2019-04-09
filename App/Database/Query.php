<?php

namespace App\Database;

use App\Config;
use App\logger\Logger;
use PDO;

class Query
{
    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(Connection $connection = null)
    {
        // FIXME
        if (!isset($connection)) {
            $connection = new Connection(Config::get('db'));
        }

        $this->db = $connection->getConnection();
    }

    public function getRow(string $query, array $params = [])
    {
        try{
            $query = $this->db->prepare($query);
            $query->execute($params);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (\Error $e) {
            (new Logger)->log('Failed DB query: ' . $e->getMessage(), 'emergency');

        }

    }

    public function getList(string $query, array $params = [])
    {
        try{
            $query = $this->db->prepare($query);
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Error $e) {
            (new Logger)->log('Failed DB query: ' . $e->getMessage(), 'emergency');
        }

    }

    public function execute(string $query, array $params = [])
    {
        $query = $this->db->prepare($query);
        $query->execute($params);
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

}
