<?php

namespace app\controllers;

use app\services\jsonloader;
use app\models\Restaurant;
use app\models\Reviews;
use app\config\requete;
require_once __DIR__ . '/../config/requete.php';

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

    public function addReview() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=connexion&action=login");
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restaurant_id'], $_POST['rating'], $_POST['comment'])) {
            $restaurant_id = intval($_POST['restaurant_id']);
            $user_id = $_SESSION['user_id'];
            $rating = intval($_POST['rating']);
            $comment = trim($_POST['comment']);
    
            if ($rating < 1 || $rating > 5 || empty($comment)) {
                die("Données invalides.");
            }
    
            Requete::add_review($restaurant_id, $user_id, $rating, $comment);
    
            header("Location: index.php?controller=restaurant&action=show&id=" . $restaurant_id);
            exit;
        }
    }

    public function addFavorite() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=connexion&action=login");
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restaurant_id'])) {
            $restaurant_id = intval($_POST['restaurant_id']);
            $user_id = $_SESSION['user_id'];
    
            // Récupérer l'objet restaurant et utilisateur
            $user = Requete::get_user_by_id($user_id);  // Méthode pour récupérer l'utilisateur
            $restaurant = Requete::get_restaurant($restaurant_id);  // Méthode pour récupérer le restaurant
    
            if ($user && $restaurant) {
                Requete::add_restaurant_favorite($user, $restaurant);  // Passer les objets au lieu des IDs
            }
    
            header("Location: index.php?controller=restaurant&action=show&id=" . $restaurant_id);
            exit;
        }
    }
    
    public function removeFavorite() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=connexion&action=login");
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restaurant_id'])) {
            $restaurant_id = intval($_POST['restaurant_id']);
            $user_id = $_SESSION['user_id'];
    
            // Récupérer l'objet restaurant et utilisateur
            $user = Requete::get_user_by_id($user_id);  // Méthode pour récupérer l'utilisateur
            $restaurant = Requete::get_restaurant($restaurant_id);  // Méthode pour récupérer le restaurant
    
            if ($user && $restaurant) {
                Requete::remove_restaurant_favorite($user, $restaurant);  // Passer les objets au lieu des IDs
            }
    
            header("Location: index.php?controller=restaurant&action=show&id=" . $restaurant_id);
            exit;
        }
    }
    
}
