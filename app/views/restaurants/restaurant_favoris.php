<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../template/template.php'); // Inclusion du template

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?controller=connexion&action=login");
    exit;
}
?>

<main>
    <h1>Vos Restaurants Favoris</h1>

    <?php if (empty($favoris)) : ?>
        <p>Aucun restaurant en favori pour le moment.</p>
    <?php else : ?>
        <ul class="restaurant-list">
            <?php foreach ($favoris as $restaurant) : ?>
                <li class="restaurant-item">
                    <a href="index.php?controller=restaurant&action=show&id=<?= $restaurant->getRestaurantId() ?>">
                        <img src="<?= htmlspecialchars($restaurant->getImageUrl()) ?>" alt="<?= htmlspecialchars($restaurant->getName()) ?>">
                        <h2><?= htmlspecialchars($restaurant->getName()) ?></h2>
                    </a>
                    <!-- Formulaire pour ajouter/retirer du favori -->
                    <form method="post" action="index.php?controller=restaurant&action=toggleFavori">
                        <input type="hidden" name="restaurant_id" value="<?= $restaurant->getId() ?>">
                        <button type="submit">
                            <!-- Affichage du cœur -->
                            <span class="heart <?= $restaurant->isFavorite() ? 'filled' : 'empty' ?>"></span>
                            <?= $restaurant->isFavorite() ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>
