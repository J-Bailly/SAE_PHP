<?php

class RestaurantFavori {
    public $user_id;
    public $restaurant_id;

    public function __construct($user_id, $restaurant_id) {
        $this->user_id = $user_id;
        $this->restaurant_id = $restaurant_id;
    }

    // Méthode pour ajouter un restaurant aux favoris
    public static function addFavorite($user_id, $restaurant_id, $pdo) {
        $sql = "INSERT INTO public.\"Restaurant_Favoris\" (user_id, restaurant_id) VALUES (:user_id, :restaurant_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'restaurant_id' => $restaurant_id]);
    }
}