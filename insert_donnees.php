<?php
// Informations de connexion à la base de données
$user="postgres.dhhugougxeqqjglegovv";
$password="root";
$host="aws-0-eu-west-3.pooler.supabase.com";
$port="6543";
$dbname="postgres";

// Connexion à la base de données
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Charger le fichier JSON
$jsonFile = 'restaurants_orleans.json';
$jsonData = file_get_contents($jsonFile);
$restaurants = json_decode($jsonData, true);

// Fonction pour insérer une cuisine si elle n'existe pas déjà
function insertCuisine($pdo, $cuisineName) {
    $stmt = $pdo->prepare("SELECT cuisine_id FROM public.".'"Cuisines"'." WHERE name = :name");
    $stmt->execute(['name' => $cuisineName]);
    $cuisine = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cuisine) {
        $stmt = $pdo->prepare("INSERT INTO public.".'"Cuisines"'." (name) VALUES (:name) RETURNING cuisine_id");
        $stmt->execute(['name' => $cuisineName]);
        $cuisine = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $cuisine['cuisine_id'];
}

function sanitizeBoolean($value) {
    print($value . "\n");
    if ($value === 'yes') {
        return true;
    } elseif ($value === 'no') {
        print("ici". "\n");
        return 0;
    } else {
        return null; // ou false selon votre préférence
    }
}

// Parcourir chaque restaurant dans le JSON
foreach ($restaurants as $restaurant) {
    // Préparer les données pour la table Restaurants
    print_r($restaurant);
    printf($restaurant["wheelchair"]. "\n");
    $restaurantData = [
        'name' => $restaurant['name'] ?? null,
        'type' => $restaurant['type'] ?? null,
        'vegetarian' => sanitizeBoolean($restaurant['vegetarian'] ),
        'vegan' => sanitizeBoolean($restaurant['vegan'] ),
        'delivery' => sanitizeBoolean($restaurant['delivery'] ),
        'takeaway' => sanitizeBoolean($restaurant['takeaway'] ),
        'phone' => $restaurant['phone'] ?? null,
        'website' => $restaurant['website'] ?? null,
        'address' => $restaurant['com_nom'] ?? null, // Vous pouvez ajuster ce champ selon vos besoins
        'latitude' => $restaurant['geo_point_2d']['lat'] ?? null,
        'longitude' => $restaurant['geo_point_2d']['lon'] ?? null,
        'opening_hours' => $restaurant['opening_hours'] ?? null,
        'wheelchair_accessibility' => sanitizeBoolean($restaurant['wheelchair']),
        'internet_access' => $restaurant['internet_access'] === 'wlan' ?? null,
        'smoking_allowed' => sanitizeBoolean($restaurant['smoking'] ),
        'capacity' => $restaurant['capacity'] ?? null,
        'drive_through' => sanitizeBoolean($restaurant['drive_through'] ),
        'facebook' => $restaurant['facebook'] ?? null,
        'siret' => $restaurant['siret'] ?? null,
        'department' => $restaurant['departement'] ?? null,
        'region' => $restaurant['region'] ?? null,
        'brand' => $restaurant['brand'] ?? null,
        'wikidata' => $restaurant['wikidata'] ?? null,
        'brand_wikidata' => $restaurant['brand_wikidata'] ?? null,
        'com_insee' => $restaurant['com_insee'] ?? null,
        'code_region' => $restaurant['code_region'] ?? null,
        'code_departement' => $restaurant['code_departement'] ?? null,
        'commune' => $restaurant['commune'] ?? null,
        'com_nom' => $restaurant['com_nom'] ?? null,
        'code_commune' => $restaurant['code_commune'] ?? null,
        'osm_edit' => $restaurant['osm_edit'] ?? null,
        'osm_id' => $restaurant['osm_id'] ?? null,
        'operator' => $restaurant['operator'] ?? null
    ];

    // Insérer le restaurant dans la table Restaurants
    $sql = "INSERT INTO public.".'"Restaurants"'." (
        name, type, vegetarian, vegan, delivery, takeaway, phone, website, address, latitude, longitude, 
        opening_hours, wheelchair_accessibility, internet_access, smoking_allowed, capacity, drive_through, 
        facebook, siret, department, region, brand, wikidata, brand_wikidata, com_insee, code_region, 
        code_departement, commune, com_nom, code_commune, osm_edit, osm_id, operator
    ) VALUES (
        :name, :type, :vegetarian, :vegan, :delivery, :takeaway, :phone, :website, :address, :latitude, :longitude, 
        :opening_hours, :wheelchair_accessibility, :internet_access, :smoking_allowed, :capacity, :drive_through, 
        :facebook, :siret, :department, :region, :brand, :wikidata, :brand_wikidata, :com_insee, :code_region, 
        :code_departement, :commune, :com_nom, :code_commune, :osm_edit, :osm_id, :operator
    ) RETURNING restaurant_id";

    $stmt = $pdo->prepare($sql);
    print_r($restaurantData);
    print("\n");
    print($restaurantData['wheelchair_accessibility']);
    $stmt->execute($restaurantData);
    $restaurantId = $stmt->fetchColumn();

    // Insérer les cuisines associées au restaurant
    if (!empty($restaurant['cuisine'])) {
        foreach ($restaurant['cuisine'] as $cuisineName) {
            $cuisineId = insertCuisine($pdo, $cuisineName);

            // Insérer la relation dans la table Restaurants_Cuisines
            $stmt = $pdo->prepare("INSERT INTO public.".'"Restaurants_Cuisines"'." (restaurant_id, cuisine_id) VALUES (:restaurant_id, :cuisine_id)");
            $stmt->execute(['restaurant_id' => $restaurantId, 'cuisine_id' => $cuisineId]);
        }
    }
}

echo "Données insérées avec succès!";
?>