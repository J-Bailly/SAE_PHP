    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../../config/Database.php';
    require_once __DIR__ . '/../../config/requete.php';
    require_once __DIR__ . '/../../services/jsonloader.php';

    require_once(__DIR__ . '/../template/template.php');


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
        $restaurant = Requete::get_restaurant($restaurant_id);

        $isFavorite = false;
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $favorites = Requete::get_restaurants_favorite($user_id);
                
                foreach ($favorites as $fav) {
                    if ($fav->getRestaurantId() === $restaurant->getRestaurantId()) {
                        $isFavorite = true;
                        break;
                    }
                }
            }


        if (!$restaurant) {
            http_response_code(404);
            die("❌ Restaurant non trouvé.");
        }

        $lat = $restaurant->getLatitude() ?? null;
        $lon = $restaurant->getLongitude() ?? null;

        if (!$lat || !$lon) {
            http_response_code(400);
            die("❌ Latitude ou longitude non disponibles.");
        }

        if (empty($restaurant->getAddress())) {
            $restaurant->setAddress(jsonloader::getAddressFromCoordinates($lat, $lon) ?? "Adresse inconnue");
        }

        $jsonFilePath = __DIR__ . '/../../data/restaurant_images.json';
        $imageUrl = null;

        if (file_exists($jsonFilePath)) {
            $restaurantImages = json_decode(file_get_contents($jsonFilePath), true) ?: [];
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
        <title><?= htmlspecialchars($restaurant->getName()) ?></title>
        <link rel="stylesheet" href="/app/assets/css/details.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    </head>
    <body>
        <div class="container">
            <h1><?= htmlspecialchars($restaurant->getName()) ?></h1>
            
            <?php if (!empty($imageUrl)) : ?>
                <img class='restaurant-image' src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($restaurant->getName()) ?>">
            <?php endif; ?>

            


            <p class="address">📍 Adresse : <?= htmlspecialchars($restaurant->getAddress()) ?></p>

            
            <p class="cuisine">🍽 Type de cuisine : <?= htmlspecialchars($restaurant->getType()) ?></p>
            

            <?php if (!empty($restaurant->getPhone())) : ?>
                <p class="phone">📞 Téléphone : <a href="tel:<?= htmlspecialchars($restaurant->getPhone()) ?>"> <?= htmlspecialchars($restaurant->getPhone()) ?></a></p>
            <?php endif; ?>

            <p class="takeaway">🥡 À emporter : <?= $restaurant->hasTakeaway() ? 'Oui' : 'Non' ?></p>

            <div style="">
                <?php if ($isFavorite): ?>
                    <form action="/index.php?controller=restaurant&action=removeFavorite" method="POST">
                        <input type="hidden" name="restaurant_id" value="<?= htmlspecialchars($restaurant->getRestaurantId()) ?>">
                        <button type="submit" style="border: none; background: none; font-size: 24px; cursor: pointer;">
                            Ajout Favoris :  ❤️
                        </button>
                    </form>
                <?php else: ?>
                    <form action="/index.php?controller=restaurant&action=addFavorite" method="POST">
                        <input type="hidden" name="restaurant_id" value="<?= htmlspecialchars($restaurant->getRestaurantId()) ?>">
                        <button type="submit" style="border: none; background: none; font-size: 24px; cursor: pointer;">
                            Ajout Favoris : 🤍
                        </button>
                    </form>
                <?php endif; ?>
            </div>


            <?php if (isset($_SESSION['user_id'])): ?>
            <h2>Avis des clients</h2>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <strong><?= htmlspecialchars($review->getUser()->getPrenom()) ?> :</strong>
                        <span>Note : <?= $review->getRating() ?>/5</span>
                        <p><?= htmlspecialchars($review->getComment()) ?></p>
                        <small>Posté le <?= $review->getDate() ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun avis pour ce restaurant.</p>
            <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <h2>Laissez un avis</h2>
                <form action="/index.php?controller=restaurant&action=addReview" method="POST">
                    <input type="hidden" name="restaurant_id" value="<?= htmlspecialchars($restaurant->getRestaurantId()) ?>">
                    <label for="rating">Note :</label>
                    <select name="rating" id="rating" required>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                    <label for="comment">Votre avis :</label>
                    <textarea name="comment" id="comment" required></textarea>
                    <button type="submit">Envoyer</button>
                </form>
            <?php else: ?>
                <p><a href="../../../index.php?controller=connexion&action=login">Connectez-vous</a> pour laisser un avis.</p>
            <?php endif; ?>

            <div id="map"></div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var map = L.map('map').setView([<?= $lat ?>, <?= $lon ?>], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '' }).addTo(map);
                L.marker([<?= $lat ?>, <?= $lon ?>]).addTo(map)
                    .bindPopup('<b><?= htmlspecialchars($restaurant->getName()) ?></b><br><?= htmlspecialchars($restaurant->getAddress()) ?>')
                    .openPopup();
            });
        </script>
    </body>
    </html>
