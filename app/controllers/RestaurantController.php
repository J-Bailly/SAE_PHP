<?php

namespace app\controllers;

use app\services\jsonloader;

class RestaurantController {
    
    public function index() {
        // Chemin vers le fichier JSON
        $jsonFilePath = __DIR__ . '/../../app/data/restaurants_orleans.json';

        // Charger les données JSON
        $restaurants = jsonloader::load($jsonFilePath);

        // Limiter le nombre de restaurants à afficher (par exemple, 10)
        $restaurants = array_slice($restaurants, 0, 10);

        // Récupérer l'adresse pour chaque restaurant
        foreach ($restaurants as &$restaurant) {
            $lat = $restaurant['geo_point_2d']['lat'];
            $lon = $restaurant['geo_point_2d']['lon'];
            $restaurant['address'] = jsonloader::getAddressFromCoordinates($lat, $lon);
        }

        // Passer les données à la vue
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }
}