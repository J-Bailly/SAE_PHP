<?php

namespace app\config;

use PDO;
use PDOException;

class Database {
    static $pdo;
    private $user = "postgres.dhhugougxeqqjglegovv";
    private $password = "root";
    private $host = "aws-0-eu-west-3.pooler.supabase.com";
    private $port = "6543";
    private $dbname = "postgres";

    private function __construct() {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            self::$pdo = new PDO($dsn, $this->user, $this->password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ ERREUR : Connexion à la base de données échouée - " . $e->getMessage());
        }
    }

    static public function getConnection() {
        if (self::$pdo === null) {
            new Database();
        }
        return self::$pdo;
    }


}