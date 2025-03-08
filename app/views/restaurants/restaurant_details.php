<?php
// Inclure le template de base
require_once __DIR__ . '/../template/template.php';

// Récupérer les données du restaurant (simulé ici)
$restaurant = [
    'name' => 'Nom du Restaurant',
    'address' => 'Adresse du Restaurant',
    'latitude' => 47.902964, // Latitude du restaurant
    'longitude' => 1.909251, // Longitude du restaurant
    'image_url' => 'https://example.com/image.jpg',
    'description' => 'Description du restaurant...'
];
?>

<div class="restaurant-details">
    <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
    <img src="<?php echo htmlspecialchars($restaurant['image_url']); ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
    <p><?php echo htmlspecialchars($restaurant['description']); ?></p>
    <p><strong>Adresse :</strong> <?php echo htmlspecialchars($restaurant['address']); ?></p>

    <!-- Intégration de la carte OpenStreetMap -->
    <div id="map" style="height: 400px; width: 100%;"></div>
</div>

<script>
    // Initialisation de la carte
    var map = L.map('map').setView([<?php echo $restaurant['latitude']; ?>, <?php echo $restaurant['longitude']; ?>], 15);

    // Ajout des tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Ajout d'un marqueur pour le restaurant
    L.marker([<?php echo $restaurant['latitude']; ?>, <?php echo $restaurant['longitude']; ?>]).addTo(map)
        .bindPopup('<?php echo htmlspecialchars($restaurant['name']); ?>')
        .openPopup();
</script>
