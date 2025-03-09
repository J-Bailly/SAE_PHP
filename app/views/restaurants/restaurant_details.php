<?php
require_once("../template/template.php");
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../services/jsonloader.php';

use app\config\Database;
use app\services\jsonloader;

// Vérifier si un ID valide est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die("❌ ID du restaurant invalide.");
}

$restaurant_id = intval($_GET['id']);

try {
    // Connexion à la base de données
    $pdo = Database::getConnection();


    
    // Vérifier si le restaurant existe
    if (!$restaurant) {
        http_response_code(404);
        die("❌ Restaurant non trouvé.");
    }

    // Vérifier la présence des coordonnées
    $lat = $restaurant['latitude'] ?? null;
    $lon = $restaurant['longitude'] ?? null;

    if (!$lat || !$lon) {
        http_response_code(400);
        die("❌ Latitude ou longitude non disponibles.");
    }

    // Si l'adresse est vide, on la récupère avec jsonloader
    if (empty($restaurant['address'])) {
        $restaurant['address'] = jsonloader::getAddressFromCoordinates($lat, $lon) ?? "Adresse inconnue";
    }

    // Charger les images depuis le JSON externe
    $jsonFilePath = __DIR__ . '/../../data/restaurant_images.json';
    $restaurantImages = [];

    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $restaurantImages = json_decode($jsonData, true) ?: [];
    }

    // Vérifier si une image existe pour ce restaurant
    $imageUrl = is_array($restaurantImages[$restaurant_id]) ? $restaurantImages[$restaurant_id][0] : ($restaurantImages[$restaurant_id] ?? null);
    $name = is_array($restaurant['name']) ? implode(", ", $restaurant['name']) : $restaurant['name'];

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
    <title><?php echo htmlspecialchars($restaurant['name']); ?></title>
    <link rel="stylesheet" href="../../assets/css/details.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
</head>
<body>

    <div class="container">
        <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
        
        <?php if (!empty($imageUrl) && is_string($imageUrl)) : ?>
            <img class='restaurant-image' src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
        <?php endif; ?>

        <p class="address">📍 Adresse : <?php echo htmlspecialchars($restaurant['address']); ?></p>

        <?php if (!empty($restaurant['cuisine'])) : ?>
            <p class="cuisine">🍽 Type de cuisine : <?php echo htmlspecialchars($restaurant['cuisine']); ?></p>
        <?php endif; ?>

        <?php if (!empty($restaurant['phone'])) : ?>
            <p class="phone">📞 Téléphone : <a href="tel:<?php echo htmlspecialchars($restaurant['phone']); ?>">
                <?php echo htmlspecialchars($restaurant['phone']); ?>
            </a></p>
        <?php endif; ?>

        <p class="takeaway">🥡 À emporter : 
            <?php echo ($restaurant['takeaway'] === 'yes') ? 'Oui' : 'Non'; ?>
        </p>

        <div id="map"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lon; ?>], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).addTo(map)
                .bindPopup('<b><?php echo htmlspecialchars($restaurant['name']); ?></b><br><?php echo htmlspecialchars($restaurant['address']); ?>')
                .openPopup();
        });
    </script>

</body>
</html>
