<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use app\config\Requete;
require_once __DIR__ . '/../../config/requete.php';
require_once __DIR__ . '/../template/template.php'; // Inclusion du template

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<p>Veuillez vous connecter pour voir vos restaurants favoris.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];
$restaurants_favoris = Requete::get_restaurants_favorite($user_id);
?>

<div class="form-container">
    <h1>Mes Restaurants Favoris</h1>

    <?php if (empty($restaurants_favoris)): ?>
        <p>Aucun restaurant favori pour le moment.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($restaurants_favoris as $restaurant): ?>
                <li>
                    <strong><?= htmlspecialchars($restaurant->getName()) ?></strong><br>
                    <p><?= htmlspecialchars($restaurant->getType() ?? 'Type inconnu') ?></p>
                    <a href="index.php?controller=restaurant&action=show&id=<?= $restaurant->getRestaurantId() ?>">Voir le restaurant</a>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
