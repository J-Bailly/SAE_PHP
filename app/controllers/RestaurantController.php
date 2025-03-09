<?php

namespace app\controllers;

use app\services\jsonloader;
use app\models\Restaurant;
use app\config\requete;

class RestaurantController {
    
    public function index() {
        $jsonImage = __DIR__ . '/../../app/data/restaurant_images.json';
        $images = jsonloader::load($jsonImage);
    
        $input = isset($_GET['search']) ? trim($_GET['search']) : '';
    
        if ($input !== '') {
            $restaurants = Requete::search_restaurant_unified($input);
        } else {
            $restaurants = Requete::get_restaurants();
        }
    
        foreach ($restaurants as $restaurant) {
            $restaurantName = method_exists($restaurant, 'getName')
                ? $restaurant->getName()
                : $restaurant->name;
    
            foreach ($images as $image) {
                if ($image['name'] === $restaurantName) {
                    if (method_exists($restaurant, 'setImageUrl')) {
                        $restaurant->setImageUrl($image['image_url']);
                    } else {
                        $restaurant->image_url = $image['image_url'];
                    }
                    break;
                }
            }
        }
    
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }    
    
    

    public function show($id) {
        $jsonImage = __DIR__ . '/../../app/data/restaurant_images.json';
        $images = jsonloader::load($jsonImage);

        $restaurant = Requete::get_restaurant($id);

        if (!$restaurant) {
            die("Restaurant non trouvé");
        }

        $restaurantName = method_exists($restaurant, 'getName') ? $restaurant->getName() : $restaurant->name;
        foreach ($images as $image) {
            if ($image['name'] === $restaurantName) {
                if (method_exists($restaurant, 'setImageUrl')) {
                    $restaurant->setImageUrl($image['image_url']);
                } else {
                    $restaurant->image_url = $image['image_url'];
                }
                break;
            }
        }

        require_once __DIR__ . '/../views/restaurants/restaurant_details.php';
    }
}
