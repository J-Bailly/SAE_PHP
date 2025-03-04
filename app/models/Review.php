<?php

class Review {
    public $reviews_id;
    public $user_id;
    public $restaurant_id;
    public $rating;
    public $comment;
    public $created_at;

    public function __construct($reviews_id, $user_id, $restaurant_id, $rating, $comment, $created_at) {
        $this->reviews_id = $reviews_id;
        $this->user_id = $user_id;
        $this->restaurant_id = $restaurant_id;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->created_at = $created_at;
    }

    // Méthode pour créer une nouvelle critique
    public static function create($user_id, $restaurant_id, $rating, $comment, $pdo) {
        $sql = "INSERT INTO public.\"Reviews\" (user_id, restaurant_id, rating, comment) VALUES (:user_id, :restaurant_id, :rating, :comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'restaurant_id' => $restaurant_id, 'rating' => $rating, 'comment' => $comment]);
        return new Review($pdo->lastInsertId(), $user_id, $restaurant_id, $rating, $comment, date('Y-m-d H:i:s'));
    }
}