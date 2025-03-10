<?php
namespace app\controllers;

use app\models\User;

class ConnexionController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
                include __DIR__ . '/../views/template/connexion.php';
                return;
            }

            $user = User::findByEmail($email);

            if ($user) {
                if (password_verify($password, $user->getPassword())) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['user_name'] = $user->getPrenom();

                    header('Location: index.php');
                    exit;
                } else {
                    $error = "Email ou mot de passe incorrect.";
                }
            } else {
                $error = "Email ou mot de passe incorrect.";
            }

            include __DIR__ . '/../views/template/connexion.php';
        } else {
            include __DIR__ . '/../views/template/connexion.php';
        }
    }

    /**
     * Déconnexion
     */
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
