<?php

namespace App\Controllers;

use App\Models\Restaurant;

class RestaurantController {
    public function index() {
        $restaurants = Restaurant::getAllRestaurants();
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }
}
