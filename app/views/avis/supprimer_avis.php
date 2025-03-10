<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../../config/requete.php");
use app\config\Requete;

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../template/connexion.php");
    exit;
}

// Vérification de l'avis à supprimer
if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];
    $review = Requete::get_review_by_id($review_id);  // Cette fonction doit être implémentée pour récupérer un avis par ID

    // Vérifiez que l'avis appartient à l'utilisateur connecté
    if ($review && $review->getUser() != $_SESSION['user_id']) {  // Utilisation de getUser() pour récupérer l'ID de l'utilisateur
        echo "Vous ne pouvez pas supprimer cet avis.";
        exit;
    }

    // Supprimer l'avis
    Requete::delete_review($review);

    header("Location: ../avis/avis_utilisateur.php");
    exit;
} else {
    echo "Avis introuvable.";
}
?>