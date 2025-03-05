<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $pdo;
    private $user = "postgres.dhhugougxeqqjglegovv";
    private $password = "root";
    private $host = "aws-0-eu-west-3.pooler.supabase.com";
    private $port = "6543";
    private $dbname = "postgres";

    public function __construct() {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ ERREUR : Connexion à la base de données échouée - " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}