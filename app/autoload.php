<?php

spl_autoload_register(function ($class) {
    // Convertir le namespace en chemin de fichier
    $class = str_replace("App\\", "app/", $class);
    $class = str_replace("\\", "/", $class) . ".php";

    $file = __DIR__ . "/../" . $class;

    if (file_exists($file)) {
        require_once $file;
    } else {
        die("❌ ERREUR : Impossible de charger la classe $class. Fichier introuvable : $file");
    }
});
