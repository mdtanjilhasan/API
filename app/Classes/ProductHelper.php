<?php

require_once __DIR__ . '/../../database/Database.php';
require __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;

class ProductHelper extends Database
{
    private $connection;
    private $table = 'products';

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

//    private function
}