<?php

namespace App\Config;

class Database {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('DATABASE_URL=postgresql://postgres:root@db.dhhugougxeqqjglegovv.supabase.co:5432/postgres');
    }

    public function getConnection() {
        return $this->pdo;
    }
}