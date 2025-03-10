<?php
namespace app\controllers;

use app\models\User;

class InscriptionController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');

            if (!$email || empty($password) || empty($nom) || empty($prenom)) {
                $error = "Veuillez remplir tous les champs obligatoires.";
                include __DIR__ . '/../views/template/inscription.php';
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = new User(null, $prenom, $email, $hashedPassword, $nom);

            if ($user->save()) {
                header('Location: index.php?controller=connexion&action=login');
                exit;
            } else {
                $error = "Erreur lors de l'inscription. Réessayez.";
                include __DIR__ . '/../views/template/inscription.php';
            }
        } else {
            include __DIR__ . '/../views/template/inscription.php';
        }
    }
}
