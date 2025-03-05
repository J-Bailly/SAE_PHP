<?php require_once("app/views/template/template_accueil.php")?>
<?php

require_once "app/autoload.php"; // Inclusion de l'autoloader

use App\Controllers\RestaurantController;

$controller = new RestaurantController();
$controller->index();
