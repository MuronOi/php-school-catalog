<?php

namespace App\Database;

use App\Config;
use App\logger\Logger;
use PDO;

/**
 * Class Query
 * @package App\Database
 */
class Query
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * Query constructor.
     * @param Connection|null $connection
     */
    public function __construct(Connection $connection = null)
    {
        // FIXME
        if (!isset($connection)) {
            $connection = new Connection(Config::get('db'));
        }

        $this->db = $connection->getConnection();
    }

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
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

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
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

    /**
     * @param string $query
     * @param array $params
     */
    public function execute(string $query, array $params = [])
    {
        $query = $this->db->prepare($query);
        $query->execute($params);
    }

    /**
     * @return string
     */
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

}
