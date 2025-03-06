<?php require_once("app/views/template/template_accueil.php")?>
<?php

require_once "app/autoload.php";

use app\controllers\RestaurantController;

$controller = new RestaurantController();

// Gestion des routes
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case '/':
        $controller->index();
        break;
    case (preg_match('/\/restaurant\/(\d+)/', $request, $matches) ? true : false):
        $controller->show($matches[1]);
        break;
    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}
