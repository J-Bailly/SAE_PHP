<?php

namespace app\controllers;

use app\services\JsonLoader; // Importer JsonLoader

class RestaurantController {
    public function index() {
        // Chemin vers le fichier JSON
        $jsonFilePath = __DIR__ . '/../../app/data/restaurants_orleans.json';

        // Charger les données JSON
        $restaurants = JsonLoader::load($jsonFilePath);

        // Passer les données à la vue
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }
}