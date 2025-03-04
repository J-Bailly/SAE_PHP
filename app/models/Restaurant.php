<?php

class Restaurant {
    public $restaurant_id;
    public $name;
    public $type;
    // Ajoutez les autres propriétés ici

    public function __construct($restaurant_id, $name, $type /*, autres propriétés */) {
        $this->restaurant_id = $restaurant_id;
        $this->name = $name;
        $this->type = $type;
        // Initialisez les autres propriétés ici
    }

    // Méthode pour créer un nouveau restaurant
    public static function create($name, $type, $pdo /*, autres paramètres */) {
        $sql = "INSERT INTO public.\"Restaurants\" (name, type /*, autres colonnes */) VALUES (:name, :type /*, autres valeurs */)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'type' => $type /*, autres valeurs */]);
        return new Restaurant($pdo->lastInsertId(), $name, $type /*, autres propriétés */);
    }

    // Méthode pour récupérer un restaurant par son ID
    public static function findById($restaurant_id, $pdo) {
        $sql = "SELECT * FROM public.\"Restaurants\" WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['restaurant_id' => $restaurant_id]);
        $row = $stmt->fetch();
        return new Restaurant($row['restaurant_id'], $row['name'], $row['type'] /*, autres propriétés */);
    }
}