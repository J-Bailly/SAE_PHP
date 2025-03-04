<?php

class RestaurantCuisine {
    public $restaurant_id;
    public $cuisine_id;

    public function __construct($restaurant_id, $cuisine_id) {
        $this->restaurant_id = $restaurant_id;
        $this->cuisine_id = $cuisine_id;
    }

    // Méthode pour associer une cuisine à un restaurant
    public static function associate($restaurant_id, $cuisine_id, $pdo) {
        $sql = "INSERT INTO public.\"Restaurants_Cuisines\" (restaurant_id, cuisine_id) VALUES (:restaurant_id, :cuisine_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['restaurant_id' => $restaurant_id, 'cuisine_id' => $cuisine_id]);
    }
}