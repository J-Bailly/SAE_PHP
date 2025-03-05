<?php
session_start(); // Assure-toi que la session est démarrée pour accéder aux informations de l'utilisateur
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorya</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="icon" type="image/png" href="../../assets/images/flavorya.png">
</head>

<body>
<header>
        <nav>
            <div class="nav-left">
                <a href="#" class="boutonNav">Accueil</a>
                <a href="#" class="boutonNav">Favoris</a>
                <?php if (isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
                    <a href=".php" class="boutonNav">Mes Avis</a>
                <?php endif; ?>
            </div>
            <img src="../../assets/images/flavorya.png" alt="Flavorya Logo" class="logo">
            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
                    <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                    <a href="logout.php" class="boutonNav">Déconnexion</a>
                <?php else: // Si l'utilisateur n'est pas connecté ?>
                    <a href="Signup.php" class="boutonNav">Inscription</a>
                    <a href="login.php" class="boutonNav">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <div class="footer">
        <p>&copy; 2025 Flavorya est un site web fictif | Tous droits réservés | Contactez-nous pour plus d'informations.</p>
    </div>
</body>

</html>