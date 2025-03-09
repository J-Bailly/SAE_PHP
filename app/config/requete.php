<?php
namespace app\config;

use app\config\Database;
use app\models\Restaurant;
use app\models\User;
use PDO;
use PDOException;

require_once __DIR__ . '/../models/Restaurant.php';

class Requete {

    static public function get_restaurants($limit = 30) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $sql = "SELECT * FROM public.".'"Restaurants"'." LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }

        return $liste_restaurants;
    }

    
    static public function get_restaurant($restaurant_id) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM public.".'"Restaurants"'." WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->execute();
        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
        $stmtCuisine->execute();
        $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
        $new_restaurant = new Restaurant($restaurant, $cuisines);

        return $new_restaurant;
    }


    static public function get_restaurants_by_cuisine($cuisine) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $sql = "SELECT * FROM public.".'"Restaurants"'." WHERE restaurant_id IN (SELECT restaurant_id FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE name = :cuisine)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cuisine', $cuisine, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }

        return $liste_restaurants;
        
    }

    static public function get_cuisines() {
        $pdo = Database::getConnection();
        $sql = "SELECT name FROM public.".'"Cuisines"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        
        return $result;
    }

    static public function get_user($email, $password) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM public.".'"Utilisateur"'." WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $cuisines_favorite = Requete::get_cuisines_favorite($user['id']);
        $restaurants_favoris = Requete::get_restaurants_favorite($user['id']);

        $user = new User($user['id'], $user['prenom'], $user['email'], $user['password_hash'], $user['nom'], $cuisines_favorite, $restaurants_favoris);

        return $user;
    }

    static public function verify_password($email, $password) {
        $pdo = Database::getConnection();
        $sql = "SELECT password_hash FROM public.".'"Utilisateur"'." WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return password_verify($password, $result['password_hash']);
    }

    static public function seacrh_restaurant($search) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $sql = "SELECT * FROM public.".'"Restaurants"'." WHERE name ILIKE :search";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }

        return $liste_restaurants;
    }
 
    static public function search_restaurant_unified($input) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
    
        $tokens = explode(' ', $input);
    
        $sql = 'SELECT * FROM public."Restaurants"';
        $groups = []; 
    
        foreach ($tokens as $index => $token) {
            $groups[] = '(name ILIKE :token'.$index.' OR type ILIKE :token'.$index.')';
        }
    
        if (!empty($groups)) {
            $sql .= ' WHERE ' . implode(' OR ', $groups);
        }
    
        $stmt = $pdo->prepare($sql);
    
        foreach ($tokens as $index => $token) {
            $stmt->bindValue(':token'.$index, '%'.$token.'%', PDO::PARAM_STR);
        }
    
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmtCuisine = $pdo->prepare("
            SELECT name 
            FROM public.\"Restaurants_Cuisines\"
            NATURAL JOIN public.\"Cuisines\"
            WHERE restaurant_id = :restaurant_id
        ");
    
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
    
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }
    
        return $liste_restaurants;
    }

    static public function register_user($prenom, $nom, $email, $password) {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO public.".'"Utilisateur"'." (prenom, nom, email, password_hash) VALUES (:prenom, :nom, :email, :password_hash)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->execute();

        return Requete::get_user($email, $password);
    }

    static public function get_note_restaurant($restaurant_id) {
        $pdo = Database::getConnection();
        $sql = "SELECT AVG(rating) FROM public.".'"Reviews"'." WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_COLUMN, 0);

        return $result;
    }

    static public function get_reviews_restaurants($restaurant_id) {
        $pdo = Database::getConnection();
        $liste_reviews = [];
        
        $sql = "SELECT * FROM public.".'"Reviews"'." WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Utilisation de self:: pour appeler une méthode statique
        $restaurant = self::get_restaurant($restaurant_id);  // Correction ici
    
        foreach ($result as $index => $review) {
            // Utilisation de self:: pour appeler une méthode statique
            $user = self::get_user_by_id($review['user_id']);  // Correction ici
            $new_review = new Reviews($review['id'], $restaurant, $user, $review['rating'], $review['comment'], $review['created_at']);
            $liste_reviews[$index] = $new_review;
        }
    
        return $liste_reviews;
    }
    

    static public function get_user_by_id($user_id) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM public.".'"Utilisateur"'." WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $cuisines_favorite = Requete::get_cuisines_favorite($user_id);
        $restaurants_favoris = Requete::get_restaurants_favorite($user_id);

        $user = new User($user['id'], $user['prenom'], $user['email'], $user['password_hash'], $user['nom'], $cuisines_favorite, $restaurants_favoris);

        return $user;
    }
    
    static public function add_review($restaurant_id, $user_id, $rating, $comment) {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO public.".'"Reviews"'." (restaurant_id, user_id, rating, comment) VALUES (:restaurant_id, :user_id, :rating, :comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
    }

    static public function get_cuisines_favorite($user_id) {
        $pdo = Database::getConnection();
        $sql = "SELECT name FROM public.".'"Cuisines_Favoris"'." natural join public.".'"Cuisines"'." WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        
        return $result;
    }

    static public function add_cuisine_favorite($user_id, $cuisine) {
        $pdo = Database::getConnection();
        $cuisine_id = Requete::get_id_cuisine($cuisine);
        $sql = "INSERT INTO public.".'"Cuisines_Favoris"'." (user_id, cuisine_id) VALUES (:user_id, :cuisine_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':cuisine_id', $cuisine_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    static public function delete_cuisine_favorite($user_id, $cuisine) {
        $pdo = Database::getConnection();
        $cuisine_id = Requete::get_id_cuisine($cuisine);
        $sql = "DELETE FROM public.".'"Cuisines_Favoris"'." WHERE user_id = :user_id AND cuisine_id = :cuisine_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':cuisine_id', $cuisine_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    static public function get_id_cuisine($cuisine) {
        $pdo = Database::getConnection();
        $sql = "SELECT cuisine_id FROM public.".'"Cuisines"'." WHERE name = :cuisine";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cuisine', $cuisine, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_COLUMN, 0);

        return $result;
    }

    static public function get_restaurants_favorite($user_id) {
        $pdo = Database::getConnection();
        $liste_restaurants = [];
        
        $sql = "SELECT * FROM public.".'"Restaurants"'." WHERE restaurant_id IN (SELECT restaurant_id FROM public.".'"Restaurant_Favoris"'." WHERE user_id = :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCuisine = $pdo->prepare("SELECT name FROM public.".'"Restaurants_Cuisines"'." natural join public.".'"Cuisines"'." WHERE restaurant_id = :restaurant_id");
        foreach ($result as $index => $restaurant) {
            $stmtCuisine->bindValue(':restaurant_id', $restaurant['restaurant_id'], PDO::PARAM_INT);
            $stmtCuisine->execute();
            $cuisines = $stmtCuisine->fetchAll(PDO::FETCH_ASSOC);
            $new_restaurant = new Restaurant($restaurant, $cuisines);
            $liste_restaurants[$index] = $new_restaurant;
        }

        return $liste_restaurants;
    }

    static public function get_adresse($restaurant_id) {
        $pdo = Database::getConnection();
        $sql = "SELECT latitude, longitude FROM public.".'"Restaurants"'." WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->execute();
        $coords = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$coords) {
            return null; // Retourne null si aucune donnée trouvée
        }
    
        $latitude = $coords['latitude'];
        $longitude = $coords['longitude'];
    
        // Utilisation d'un service externe pour convertir lat/lon en adresse
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Certains services exigent un User-Agent
        $response = curl_exec($ch);
        
        // Vérifier les erreurs de cURL
        if(curl_errno($ch)) {
            echo 'Erreur cURL: ' . curl_error($ch);
        }
        
        curl_close($ch);
    
        // Vérifier si la réponse est valide
        if (empty($response)) {
            return "Erreur lors de la récupération de l'adresse.";
        }
    
        $data = json_decode($response, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Erreur de décodage JSON: ' . json_last_error_msg();
        }
    
        // Retourner l'adresse ou un message d'erreur
        return $data['display_name'] ?? "Adresse non trouvée";
    }
    
    static public function update_review($review) {
        $pdo = Database::getConnection();
        $sql = "UPDATE public.".'"Reviews"'." SET rating = :rating, comment = :comment WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':rating', $review->getRating(), PDO::PARAM_INT);
        $stmt->bindValue(':comment', $review->getComment(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $review->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    static public function delete_review($review) {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM public.".'"Reviews"'." WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $review->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }


}


