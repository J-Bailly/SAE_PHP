<?php

namespace app\services;

class JsonLoader {
    public static function load($jsonFilePath) {
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die("❌ ERREUR : Impossible de décoder le fichier JSON.");
        }

        return $data;
    }
}