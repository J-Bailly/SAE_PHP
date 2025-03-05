<?php

namespace App\Controllers;

use App\Models\Restaurant;
use App\Config\Database; // Ajout de l'importation de la classe Database

class RestaurantController {
    public function index() {
        // Création de l'instance de la classe Database pour obtenir la connexion
        $db = new Database();
        $pdo = $db->getConnection();
        
        // Récupérer tous les restaurants en utilisant la connexion PDO
        $restaurants = Restaurant::getAllRestaurants($pdo);

        // Charger la vue avec les restaurants
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }
}
