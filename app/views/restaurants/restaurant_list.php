<?php

if (!empty($restaurants)) {
    foreach ($restaurants as $restaurant) {
        echo "<a href='app/views/restaurants/restaurant_details.php' class='restaurant-bord'>";
        echo "<img class='restaurant-image' src='{$restaurant['image_url']}' alt='{$restaurant['name']}'>";
        echo "<div class='restaurant-interieur'>";
        echo "<h2>{$restaurant['name']}</h2>";
        echo "<p>Avis : {$restaurant['stars']}</p>";
        echo "<p>Horaires : {$restaurant['opening_hours']}</p>";
        echo "</div>";
        echo "</a>";
    }
} else {
    echo "<p>Aucun restaurant trouvé.</p>";
}