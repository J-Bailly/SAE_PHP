<?php

namespace App\Controllers;

use App\Models\Restaurant;
use App\Config\Database;

class RestaurantController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        // Logique pour afficher la liste des restaurants
    }

    public function show($id) {
        // Logique pour afficher un restaurant spécifique
    }
}