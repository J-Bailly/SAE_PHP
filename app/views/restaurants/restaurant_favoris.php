<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="app/assets/css/inscription_style.css">
</head>
<body>
    <div class="form-container">
        <h1>Inscription</h1>
        <?php if(isset($error)) { echo '<p class="error-message">'.$error.'</p>'; } ?>
        <form method="post" action="index.php?controller=inscription&action=register">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>
            <input type="submit" class="submit-btn" value="S'inscrire">
        </form>
    </div>
</body>
</html>
