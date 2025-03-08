<?php

namespace app\controllers; // Créer un namespace pour le fichier

use app\models\Restaurant; // Importer la classe Restaurant
use app\config\requete; // Importer la classe Requete   


class RestaurantController {
    public function index() {
        // Chemin vers le fichier JSON
        $jsonFilePath = __DIR__ . '/../../app/data/restaurants_orleans.json';

        // Charger les données JSON
        $restaurants =  Requete::get_restaurants(10);

        // Passer les données à la vue
        require_once __DIR__ . '/../views/restaurants/restaurant_list.php';
    }
}