<?php

namespace App\Config;

class Database {
    private $pdo;
    private $user="postgres.dhhugougxeqqjglegovv";
    private $password="root";
    private $host="aws-0-eu-west-3.pooler.supabase.com";
    private $port="6543";
    private $dbname="postgres";

    public function __construct() {
        
        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }$this->pdo = new PDO('DATABASE_URL=postgresql://postgres:root@db.dhhugougxeqqjglegovv.supabase.co:5432/postgres');
    }

    public function getConnection() {
        return $this->pdo;
    }
}