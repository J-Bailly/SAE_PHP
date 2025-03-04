<?php

namespace App\Config;

class Database {
    private $pdo;

    public function __construct() {
        $user="postgres.dhhugougxeqqjglegovv";
        $password="root";
        $host="aws-0-eu-west-3.pooler.supabase.com";
        $port="6543";
        $dbname="postgres";
        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}