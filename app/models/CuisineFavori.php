<?php

class CuisineFavori {
    public $user_id;
    public $cuisine_id;

    public function __construct($user_id, $cuisine_id) {
        $this->user_id = $user_id;
        $this->cuisine_id = $cuisine_id;
    }

    // Méthode pour ajouter une cuisine aux favoris
    public static function addFavorite($user_id, $cuisine_id, $pdo) {
        $sql = "INSERT INTO public.\"Cuisines_Favoris\" (user_id, cuisine_id) VALUES (:user_id, :cuisine_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'cuisine_id' => $cuisine_id]);
    }
}