<?php

spl_autoload_register(function ($class) {
    // Retirer "App\" du namespace
    $class = str_replace("App\\", "", $class);
    $class = str_replace("\\", "/", $class) . ".php";

    // Correction du chemin
    $file = __DIR__ . "/" . lcfirst($class); // Respecte la casse des dossiers sous Linux

    if (file_exists($file)) {
        require_once $file;
    } else {
        die("❌ ERREUR : Impossible de charger la classe '$class'. Fichier introuvable : $file");
    }
});
