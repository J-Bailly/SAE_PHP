<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../template/connexion.php"); // Redirige vers la page de connexion
    exit;
}

require_once("../template/template.php");
require_once '../../config/requete.php';

use app\config\Requete;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Avis</title>
    <link rel="stylesheet" href="/app/assets/css/avis.css">
</head>
<body>
    <div class="form-container">
        <h1>Mes Avis</h1>

        <?php
        $user_id = $_SESSION['user_id'];
        $reviews = Requete::get_reviews_user($user_id);

        if (empty($reviews)) {
            echo "<p>Aucun avis trouvé.</p>";
        } else {
            echo '<ul>';
            foreach ($reviews as $review) {
                $restaurant = $review->getRestaurant();
                echo '<li>';
                echo '<strong>' . htmlspecialchars($restaurant->getName()) . '</strong><br>';
                echo 'Note : ' . str_repeat('⭐', $review->getRating()) . '<br>';
                echo 'Commentaire : ' . htmlspecialchars($review->getComment()) . '<br>';
                echo '<em>Posté le ' . date('d/m/Y', strtotime($review->getDate())) . '</em><br>';

                // Ajouter un bouton de modification et de suppression
                echo '<a href="modifier_avis.php?review_id=' . $review->getId() . '">Modifier</a> | ';
                echo '<a href="supprimer_avis.php?review_id=' . $review->getId() . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet avis ?\');">Supprimer</a>';
                
                echo '</li><hr>';
            }
            echo '</ul>';
        }
        ?>
    </div>
</body>
</html>
