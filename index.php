<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use app\controllers\RestaurantController;

// Charger les classes nécessaires
require_once "app/autoload.php";

// Vérification des paramètres 'controller' et 'action' dans l'URL
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controllerName = ucfirst($_GET['controller']) . 'Controller';
    $actionName = $_GET['action'];
    $controllerClass = "app\\controllers\\" . $controllerName;

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();
        if (method_exists($controller, $actionName)) {
            // Si l'action est "show", il faut passer l'ID en paramètre
            if ($actionName == 'show' && isset($_GET['id'])) {
                $controller->$actionName($_GET['id']);
            } else {
                $controller->$actionName();
            }
            exit;
        } else {
            // Si la méthode n'existe pas, renvoyer une erreur 404
            http_response_code(404);
            echo "Action non trouvée.";
            exit;
        }
    } else {
        // Si le contrôleur n'existe pas, renvoyer une erreur 404
        http_response_code(404);
        echo "Contrôleur non trouvé.";
        exit;
    }
}

// Logique de gestion des URL propres (ex : /restaurant/{id})
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si la requête est pour la page d'accueil
if ($requestPath == '/' || $requestPath == '/index.php') {
    // Inclure le template d'accueil uniquement pour la page d'accueil
    require_once "app/views/template/template_accueil.php";
    $controller = new RestaurantController();
    $controller->index();
} elseif (preg_match('/^\/restaurant\/(\d+)$/', $requestPath, $matches)) {
    // Si la requête est pour afficher un restaurant spécifique
    $controller = new RestaurantController();
    if (isset($matches[1])) {
        $controller->show($matches[1]);
    } else {
        http_response_code(404);
        echo "Restaurant non trouvé.";
    }
} else {
    // Si la route n'est pas trouvée, renvoyer une erreur 404
    http_response_code(404);
    echo "Page non trouvée";
}
