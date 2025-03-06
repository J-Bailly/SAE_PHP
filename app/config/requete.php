<?php

namespace app\config;

use app\config\Database;
use app\models\Restaurant;
use PDO;
use PDOException;

class Requete {

    static public function get_restaurants($limit = 10) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $time = microtime(true);
        $sql = "SELECT * FROM public.".'"Restaurants"'." LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $time = microtime(true) - $time;
        echo "Temps d'exécution : $time secondes";
        $time = microtime(true);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $index => $restaurant) {
            $new_restaurant = new Restaurant($restaurant           
            );
            $liste_restaurants[$index] = $new_restaurant;
        }
        $time = microtime(true) - $time;
        echo "Temps de création des objets : $time secondes";
        return $liste_restaurants;
    }
    

}


