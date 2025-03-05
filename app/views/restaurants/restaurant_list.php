<?php require_once("template/template.php"); ?>

<section>
    <h2>Liste des Restaurants</h2>
    <ul>
        <?php foreach ($restaurants as $restaurant): ?>
            <li>
                <strong><?php echo htmlspecialchars($restaurant->getName()); ?></strong> - 
                Cuisine : <?php echo htmlspecialchars($restaurant->getCuisineType()); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
