<?php
require_once("../template/template.php");
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/requete.php';
require_once __DIR__ . '/../../services/jsonloader.php';

use app\config\Database;
use app\config\Requete;
use app\services\jsonloader;

// Vérifier si un ID valide est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die("❌ ID du restaurant invalide.");
}

$restaurant_id = intval($_GET['id']);

try {
    // Récupérer les informations du restaurant depuis la base de données
    $restaurant = Requete::get_restaurant($restaurant_id);

    // Vérifier si le restaurant existe
    if (!$restaurant) {
        http_response_code(404);
        die("❌ Restaurant non trouvé.");
    }

    // Vérifier la présence des coordonnées
    $lat = $restaurant->getLatitude() ?? null;
    $lon = $restaurant->getLongitude() ?? null;

    if (!$lat || !$lon) {
        http_response_code(400);
        die("❌ Latitude ou longitude non disponibles.");
    }

    // Si l'adresse est vide, on la récupère avec jsonloader
    if (empty($restaurant->getAddress())) {
        $restaurant->setAddress(jsonloader::getAddressFromCoordinates($lat, $lon) ?? "Adresse inconnue");
    }

    // Charger les images depuis le JSON externe
    $jsonFilePath = __DIR__ . '/../../data/restaurant_images.json';
    $restaurantImages = [];

    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $restaurantImages = json_decode($jsonData, true) ?: [];
    }


    $imageUrl = null;

    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $restaurantImages = json_decode($jsonData, true) ?: [];

        foreach ($restaurantImages as $entry) {
            if ($entry['name'] === $restaurant->getName()) {
                $imageUrl = $entry['image_url'];
                break;
            }
        }
    }

    $reviews = Requete::get_reviews_restaurants($restaurant_id);  

} catch (PDOException $e) {
    http_response_code(500);
    die("❌ ERREUR : " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($restaurant->getName()); ?></title>
    <link rel="stylesheet" href="../../assets/css/details.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
</head>
<body>

    <div class="container">
        <h1><?php echo htmlspecialchars($restaurant->getName()); ?></h1>
        
        <?php if (!empty($imageUrl) && is_string($imageUrl)) : ?>
            <img class='restaurant-image' src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($restaurant->getName()); ?>">
        <?php endif; ?>

        <p class="address">📍 Adresse : <?php echo htmlspecialchars($restaurant->getAddress()); ?></p>

        <?php if (!empty($restaurant->cuisines)) : ?>
            <p class="cuisine">🍽 Type de cuisine : 
                <?php echo htmlspecialchars(implode(', ', array_column($restaurant->cuisines, 'name'))); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($restaurant->getPhone())) : ?>
            <p class="phone">📞 Téléphone : <a href="tel:<?php echo htmlspecialchars($restaurant->getPhone()); ?>">
                <?php echo htmlspecialchars($restaurant->getPhone()); ?>
            </a></p>
        <?php endif; ?>

        <p class="takeaway">🥡 À emporter : 
            <?php echo ($restaurant->hasTakeaway()) ? 'Oui' : 'Non'; ?>
        </p>


        <div id="map"></div>

        <div class="reviews">
            <h2>📝 Avis :</h2>
            <?php if (!empty($reviews)) : ?>
                <ul>
                    <?php foreach ($reviews as $review) : ?>
                        <li>
                            <strong><?php echo htmlspecialchars($review['user_name']); ?></strong> (Note: <?php echo htmlspecialchars($review['rating']); ?>/5)<br>
                            <p><?php echo htmlspecialchars($review['comment']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Aucun avis pour ce restaurant pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map', {
            zoomControl: false // Désactive le contrôle de zoom par défaut
        }).setView([<?php echo $lat; ?>, <?php echo $lon; ?>], 15); // Positionner la carte avec la latitude et longitude du restaurant
        
        // Définir les tuiles de la carte (OpenStreetMap) sans attribution
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '' // Supprimer l'attribution
        }).addTo(map);
        
        // Ajouter un marqueur avec une popup sur les coordonnées du restaurant
        L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).addTo(map)
            .bindPopup('<b><?php echo htmlspecialchars($restaurant->getName()); ?></b><br><?php echo htmlspecialchars($restaurant->getAddress()); ?>')
            .openPopup();
    });
    </script>

</body>
</html>
