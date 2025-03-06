<?php

namespace app\config;

use app\config\Database;
use app\models\Restaurant;
use PDO;
use PDOException;

class Requete {

    static public function get_restaurants($limit = 10) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM public.".'"Restaurants"'." LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $json_data = json_encode($result);
        $liste_restaurants = [];
    
        for ($i = 0; $i < $limit; $i++) {
            $restaurant = new Restaurant(
                $result[$i]['restaurant_id'],
                $result[$i]['name'],
                $result[$i]['type'],
                $result[$i]['vegetarian'],
                $result[$i]['vegan'],
                $result[$i]['delivery'],
                $result[$i]['takeaway'],
                $result[$i]['phone'],
                $result[$i]['website'],
                $result[$i]['address'],
                $result[$i]['latitude'],
                $result[$i]['longitude'],
                $result[$i]['opening_hours'],
                $result[$i]['wheelchair_accessibility'],
                $result[$i]['internet_access'],
                $result[$i]['smoking_allowed'],
                $result[$i]['capacity'],
                $result[$i]['drive_through'],
                $result[$i]['facebook'],
                $result[$i]['siret'],
                $result[$i]['department'],
                $result[$i]['region'],
                $result[$i]['brand'],
                $result[$i]['wikidata'],
                $result[$i]['brand_wikidata'],
                $result[$i]['com_insee'],
                $result[$i]['code_region'],
                $result[$i]['code_departement'],
                $result[$i]['commune'],
                $result[$i]['com_nom'],
                $result[$i]['code_commune'],
                $result[$i]['osm_edit'],
                $result[$i]['osm_id'],
                $result[$i]['operator']
            );
            array_push($liste_restaurants, $restaurant);
        }
        return $liste_restaurants;
    }
    

}


