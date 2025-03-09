<?php
// Inclure le template de base
require_once __DIR__ . '/../template/template.php';

use app\services\jsonloader;

// Récupérer les données du restaurant (simulé ici)
$restaurant = [
    'name' => 'Nom du Restaurant',
    'latitude' => 47.902964, // Latitude du restaurant
    'longitude' => 1.909251, // Longitude du restaurant
    'address' => jsonloader::getAddressFromCoordinates(47.902964, 909251),
    'image_url' => 'https://example.com/image.jpg', // Remplace par une vraie URL d'image
    'description' => 'Bienvenue dans notre restaurant où nous servons des plats délicieux avec des ingrédients frais et de saison. Profitez d’une ambiance chaleureuse et conviviale.'
];


#$lat = $restaurant['geo_point_2d']['lat'];
#$lon = $restaurant['geo_point_2d']['lon'];
#$restaurant['address'] = jsonloader::getAddressFromCoordinates($lat, $lon);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($restaurant['name']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link rel="stylesheet" href="../../assets/css/details.css" />
</head>
<body>

    <div class="container">
        <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
        <img src="<?php echo htmlspecialchars($restaurant['image_url']); ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
        <p><?php echo htmlspecialchars($restaurant['description']); ?></p>
        <p class="address">📍 Adresse : <?php echo htmlspecialchars($restaurant['address']); ?></p>

        <!-- Intégration de la carte OpenStreetMap -->
        <div id="map"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([<?php echo $restaurant['latitude']; ?>, <?php echo $restaurant['longitude']; ?>], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([<?php echo $restaurant['latitude']; ?>, <?php echo $restaurant['longitude']; ?>]).addTo(map)
                .bindPopup('<b><?php echo htmlspecialchars($restaurant['name']); ?></b><br><?php echo htmlspecialchars($restaurant['address']); ?>')
                .openPopup();
        });
    </script>

</body>
</html>
