<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorya</title>
    <link rel="stylesheet" href="app/assets/css/styles.css">
    <link rel="icon" type="image/png" href="app/assets/images/flavorya.png">
</head>

<body>
    <header>
        <nav>
            <div class="nav-left">
                <img src="app/assets/images/flavorya.png" alt="Flavorya Logo" class="logo">
                <a href="#" class="boutonNavGauche">Accueil</a>
                <?php if (isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
                    <a href="#" class="boutonNavGauche">Mes Avis</a>
                    <a href="#" class="boutonNavGauche">Favoris</a>
                <?php endif; ?>
            </div>

            <div class="nav-center">
                <form method="GET" action="index.php">
                    <input type="search" name="search" placeholder="Rechercher un restaurant...">
                </form>
            </div>


            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])):?>
                    <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                    <a href="index.php?controller=connexion&action=logout" class="boutonNavDroite">Déconnexion</a>
                <?php else: // Si l'utilisateur n'est pas connecté ?>
                    <a href="index.php?controller=inscription&action=register" class="boutonNavDroite">Inscription</a>
                    <a href="index.php?controller=connexion&action=login" class="boutonNavDroite">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <footer class="footer">
        <p>&copy; 2025 | Tous droits réservés | Contactez-nous pour plus d'informations.</p>
    </footer>
</body>

</html>