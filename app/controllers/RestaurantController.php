<?php
// app/controllers/RestaurantController.php

namespace app\controllers;

use app\services\jsonloader;

class RestaurantController {
    
    public function index() {
        // Chemin vers le fichier JSON
        $jsonRestaurant = __DIR__ . '/../../app/data/restaurants_orleans.json';
        $jsonImage = __DIR__. '/../../app/data/restaurant_images.json';

        // Charger les données JSON
        $restaurants = jsonloader::load($jsonRestaurant);
        $images = jsonloader::load($jsonImage);

        // Limiter le nombre de restaurants à afficher
        $restaurants = array_slice($restaurants, 0, 10);

        // Récupérer l'adresse pour chaque restaurant
        foreach ($restaurants as &$restaurant) {
            foreach ($images as $image) {
                if ($image['name'] == $restaurant['name']) {
                    $restaurant['image_url'] = $image['image_url'];
                    break;
                }
            }
        }

        // Passer les données à la vue
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }

    public function show($id) {
        // Chemin vers le fichier JSON
        $jsonRestaurant = __DIR__ . '/../../app/data/restaurants_orleans.json';
        $jsonImage = __DIR__. '/../../app/data/restaurant_images.json';

        // Charger les données JSON
        $restaurants = jsonloader::load($jsonRestaurant);
        $images = jsonloader::load($jsonImage);

        // Trouver le restaurant par son ID
        $restaurant = null;
        foreach ($restaurants as $r) {
            if ($r['id'] == $id) {
                $restaurant = $r;
                break;
            }
        }

        if (!$restaurant) {
            die("Restaurant non trouvé");
        }

        // Récupérer l'image du restaurant
        foreach ($images as $image) {
            if ($image['name'] == $restaurant['name']) {
                $restaurant['image_url'] = $image['image_url'];
                break;
            }
        }

        // Passer les données à la vue
        require_once __DIR__ . '/../views/restaurants/restaurant_details.php';
    }
}