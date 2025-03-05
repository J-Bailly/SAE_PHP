<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class Restaurant {
    private $id;
    private $name;
    private $cuisineType;

    public function __construct($id, $name, $cuisineType) {
        $this->id = $id;
        $this->name = $name;
        $this->cuisineType = $cuisineType;
    }

    public static function getAllRestaurants() {
        $database = new Database();
        $pdo = $database->getConnection();

        $stmt = $pdo->query("SELECT id, name, cuisine_type FROM restaurants");
        $restaurants = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $restaurants[] = new Restaurant($row['id'], $row['name'], $row['cuisine_type']);
        }

        return $restaurants;
    }

    public function getName() {
        return $this->name;
    }

    public function getCuisineType() {
        return $this->cuisineType;
    }
}
