<?php

namespace App\Models;

class Restaurant {
    private $id;
    private $name;
    private $cuisineType;
    // Ajoute d'autres propriétés et méthodes nécessaires

    public function __construct($id, $name, $cuisineType) {
        $this->id = $id;
        $this->name = $name;
        $this->cuisineType = $cuisineType;
    }

    public function getName(){
        return $this->name;
    } 

    public function getCuisineType(){
        return $this->cuisineType;
    }
}