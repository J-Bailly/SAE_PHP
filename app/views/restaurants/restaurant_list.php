<?php
echo "<h1>Liste des restaurants</h1>";
if (!empty($restaurants)) {
    foreach ($restaurants as $restaurant) {
        echo "<div class='restaurant-bord'>";
        echo "<div class='restaurant-interieur'>";
        echo "<h2>".$restaurant->getName()."</h2>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>Aucun restaurant trouvé.</p>";
}