<?php

namespace app\services;

class jsonloader {
    /**
     * Charge les données JSON depuis un fichier.
     */
    public static function load($jsonFilePath) {
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die("❌ ERREUR : Impossible de décoder le fichier JSON.");
        }

        return $data;
    }

    /**
     * Récupère l'adresse à partir des coordonnées (latitude, longitude) en utilisant l'API Nominatim.
     */
    public static function getAddressFromCoordinates($lat, $lon) {
        // URL de l'API Nominatim pour le géocodage inversé
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon";

        // Configuration de la requête HTTP
        $options = [
            "http" => [
                "header" => "User-Agent: MyApp/1.0\r\n" // Nominatim exige un User-Agent
            ]
        ];
        $context = stream_context_create($options);

        // Envoyer la requête et récupérer la réponse
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return "Adresse non trouvée";
        }

        $data = json_decode($response, true);

        if (isset($data['address'])) {
            $address = $data['address'];

            $houseNumber = $address['house_number'] ?? '';

            // Construire l'adresse complète
            return implode(", ", array_filter([
                $houseNumber,
                $address['road'] ?? '',
                $address['postcode'] ?? '',
                $address['city'] ?? '',
                $address['country'] ?? ''
            ]));
        }

        return "Adresse non trouvée";
    }
}