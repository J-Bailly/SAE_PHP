<?php require_once("app/views/template/template_accueil.php")?>
<?php

require_once "app/autoload.php"; // Inclusion de l'autoloader

use app\controllers\RestaurantController;

$controller = new RestaurantController();
$controller->index();
