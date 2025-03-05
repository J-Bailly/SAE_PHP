<?php

namespace App\Models;

use App\Config\Database;

class Restaurant {

    public static function getAllRestaurants() {
        $db = new Database();
        $conn = $db->getConnection();
    
        try {
            // Utilisez le bon nom de table (en minuscules ou avec des guillemets si nécessaire)
            $stmt = $conn->query("SELECT * FROM Restaurants");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des restaurants : " . $e->getMessage());
        }
    }
}