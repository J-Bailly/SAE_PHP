<?php

if (!empty($restaurants)) {
    foreach ($restaurants as $restaurant) {
        echo "<div class='restaurant'>";
        echo "<h2>{$restaurant['name']}</h2>";
        echo "<p>Adresse : {$restaurant['address']}</p>";
        echo "<p>Téléphone : {$restaurant['phone']}</p>";
        echo "<p>Site web : <a href='{$restaurant['website']}' target='_blank'>{$restaurant['website']}</a></p>";
        echo "<p>Horaires : {$restaurant['opening_hours']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>Aucun restaurant trouvé.</p>";
}