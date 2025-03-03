<?php

namespace App\Config;

class Database {
    private $pdo;

    public function __construct() {
        $this->pdo = new \PDO('mysql:host=your_host;dbname=your_dbname', 'username', 'password');
    }

    public function getConnection() {
        return $this->pdo;
    }
}