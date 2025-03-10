<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../template/template.php');
require_once("../../config/requete.php");
use app\config\Requete;

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../template/connexion.php");
    exit;
}

// Vérification de l'avis à modifier
if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];
    $review = Requete::get_review_by_id($review_id);

    // Vérifier que l'avis existe et appartient à l'utilisateur connecté
    if (!$review || $review->getUser() != $_SESSION['user_id']) {
        echo "Vous ne pouvez pas modifier cet avis.";
        exit;
    }

    // Si le formulaire est soumis pour modifier l'avis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_rating = $_POST['rating'];
        $new_comment = $_POST['comment'];

        // Mettre à jour l'avis dans la base de données
        $update_success = Requete::update_review($review_id, $new_rating, $new_comment);

        if ($update_success) {
            // Redirection après la modification
            header("Location: ../avis/avis_utilisateur.php");
            exit;
        } else {
            echo "Erreur lors de la mise à jour de l'avis.";
        }
    }

    // Si l'avis existe, afficher le formulaire de modification
    $current_rating = $review->getRating();
    $current_comment = $review->getComment();
} else {
    echo "Avis introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'avis</title>
    <link rel="stylesheet" href="/app/assets/css/inscription_style.css">
</head>
<body>
    <div class="form-container">
        <h1>Modifier l'avis</h1>

        <form action="modifier_avis.php?review_id=<?= htmlspecialchars($review_id) ?>" method="POST">
            
            <!-- Note -->
            <div class="form-group">
                <label for="rating">Note :</label>
                <select name="rating" id="rating" required>
                    <option value="5" <?= $current_rating == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                    <option value="4" <?= $current_rating == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                    <option value="3" <?= $current_rating == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                    <option value="2" <?= $current_rating == 2 ? 'selected' : '' ?>>⭐⭐</option>
                    <option value="1" <?= $current_rating == 1 ? 'selected' : '' ?>>⭐</option>
                </select>
            </div>

            <!-- Commentaire -->
            <div class="form-group">
                <label for="comment">Votre avis :</label>
                <textarea name="comment" id="comment" required><?= htmlspecialchars($current_comment) ?></textarea>
            </div>

            <!-- Bouton de soumission -->
            <div class="form-group">
                <button type="submit" class="submit-btn">Modifier l'avis</button>
            </div>
        </form>

        <p><a class="form-group" href="../avis/avis_utilisateur.php">Retour à mes avis</a></p>
    </div>
</body>
</html>
