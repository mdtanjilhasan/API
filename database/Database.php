<?php

abstract class Database
{
    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASSWORD = '';
    private const DBNAME = 'rest_api';

    private $db = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME . ';charset=utf8mb4';

    private $connection = null;

    protected function getConnection()
    {
        if (empty($this->connection)) {
            try {
                $this->connection = new PDO($this->db, self::DBUSER, self::DBPASSWORD);
                $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                die(json_encode(['success' => false, 'message' => 'Connection Failed']));
            }
        }
        return $this->connection;
    }
}