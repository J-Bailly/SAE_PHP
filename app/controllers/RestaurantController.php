<?php

namespace App\Controllers;

use app\services\JsonLoader;

class RestaurantController {
    public function index() {
        $jsonFilePath = __DIR__ . '/../../app/data/restaurants_orleans.json';
        $restaurants = JsonLoader::load($jsonFilePath);
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }
}