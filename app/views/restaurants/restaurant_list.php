<?php
if (!empty($restaurants)) {
    foreach ($restaurants as $restaurant) {
        $imageUrl = isset($restaurant->image_url) ? $restaurant->image_url : 'default_image.png';
        $name = $restaurant->getName();
        $openingHours = $restaurant->getOpeningHours();
        if (empty($openingHours)) {
            $openingHours = "Non renseignées par l'établissement";
        }
        $stars = isset($restaurant->stars) ? $restaurant->stars : 'Cet établissement n\'a pas encore été noté'; 

        echo "<a href='app/views/restaurants/restaurant_details.php?id=" . $restaurant->getRestaurantId() . "' class='restaurant-bord'>";
        echo "<img class='restaurant-image' src='{$imageUrl}' alt='{$name}'>";
        echo "<div class='restaurant-interieur'>";
        echo "<h2>{$name}</h2>";
        echo "<p>Avis : {$stars}</p>";
        echo "<p>Horaires : {$openingHours}</p>";
        echo "</div>";
        echo "</a>";
    }
} else {
    echo "<p>Aucun restaurant trouvé.</p>";
}
