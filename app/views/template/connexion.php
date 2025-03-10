<?php     require_once(__DIR__ . '/../template/template.php');?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="app/assets/css/inscription_style.css">
</head>
<body>
    <div class="form-container">
        <h1>Connexion</h1>
        <?php if(isset($error)) { echo '<p class="error-message">'.$error.'</p>'; } ?>
        <form method="post" action="index.php?controller=connexion&action=login">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>
            <input type="submit" class="submit-btn" value="Se connecter">
        </form>
    </div>
</body>
</html>
