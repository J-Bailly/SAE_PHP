<?php 
session_start();
require_once "app/autoload.php";

if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controllerName = ucfirst($_GET['controller']) . 'Controller';
    $actionName = $_GET['action'];
    $controllerClass = "app\\controllers\\" . $controllerName;
    
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();
        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
            exit;
        }
    }
}

use app\controllers\RestaurantController;
require_once("app/views/template/template_accueil.php");

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$controller = new RestaurantController();

// Gestion des routes
if ($requestPath == '/' || $requestPath == '/index.php') {
    $controller->index();
} elseif (preg_match('/\/restaurant\/(\d+)/', $requestPath, $matches)) {
    $controller->show($matches[1]);
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
?>
