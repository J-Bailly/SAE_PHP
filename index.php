<?php 
require_once("app/views/template/template_accueil.php")?>
<?php
require_once "app/autoload.php";

use app\controllers\RestaurantController;

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

