<?php

class Cuisine {
    public $cuisine_id;
    public $name;

    public function __construct($cuisine_id, $name) {
        $this->cuisine_id = $cuisine_id;
        $this->name = $name;
    }

    // Méthode pour créer une nouvelle cuisine
    public static function create($name, $pdo) {
        $sql = "INSERT INTO public.\"Cuisines\" (name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
        return new Cuisine($pdo->lastInsertId(), $name);
    }

    // Méthode pour récupérer une cuisine par son ID
    public static function findById($cuisine_id, $pdo) {
        $sql = "SELECT * FROM public.\"Cuisines\" WHERE cuisine_id = :cuisine_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cuisine_id' => $cuisine_id]);
        $row = $stmt->fetch();
        return new Cuisine($row['cuisine_id'], $row['name']);
    }
}