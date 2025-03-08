<?php

namespace app\config;

use app\config\Database;
use app\models\Restaurant;
use PDO;
use PDOException;

class Requete {

    static public function get_restaurants($limit = 10) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $sql = "SELECT * FROM public.".'"Restaurants"'." LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }

        return $liste_restaurants;
    }


    static public function get_restaurant($restaurant_id) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM public.".'"Restaurants"'." WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->execute();
        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
        $stmtCuisine->execute();
        $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
        $new_restaurant = new Restaurant($restaurant, $cuisines);

        return $new_restaurant;
    }


    static public function get_restaurants_by_cuisine($cuisine) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $sql = "SELECT * FROM public.".'"Restaurants"'." WHERE restaurant_id IN (SELECT restaurant_id FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE name = :cuisine)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cuisine', $cuisine, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }

        return $liste_restaurants;
        
    }

    static public function get_cuisines() {
        $pdo = Database::getConnection();
        $sql = "SELECT name FROM public.".'"Cuisines"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        
        return $result;
    }

    static public function get_user($email, $password) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM public.".'"Users"'." WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

}


