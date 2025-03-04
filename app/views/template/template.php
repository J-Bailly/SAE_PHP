<?php
session_start(); // Assure-toi que la session est démarrée pour accéder aux informations de l'utilisateur
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorya</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <header>
        <nav class="navigation">
            <a href="../../index.php">Accueil</a>
            <a href=".php">Favoris</a>
            <?php if (isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
                <a href=".php">Mes Avis</a>
            <?php endif; ?>
            
        </nav>
        <div>
            <?php if (isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                <a href="logout.php"><button class="sign-up-button">Se déconnecter</button></a>
            <?php else: // Si l'utilisateur n'est pas connecté ?>
                <a href="Signup.php"><button class="sign-up-button">S'inscrire</button></a>
                <a href="login.php"><button class="sign-up-button">Se connecter</button></a>
            <?php endif; ?>
        </div>
    </header>
    <div class="design-entete">
        <div class="logo">
            <img src="../../flavorya.png" alt="Flavorya">
            <h1></h1>
        </div>
        <div class="inverser">
            
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025  | Tous droits réservés | Contactez-nous pour plus d'informations.</p>
    </div>
</body>

</html>