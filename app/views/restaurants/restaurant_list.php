<?php require_once("template/template.php"); ?>

<section>
    <h2>Liste des Restaurants</h2>
    <ul>
        <?php if ($Restaurants != []): ?>
            <?php foreach ($Restaurants as $restaurant): ?>
                <li>
                    <strong><?php echo htmlspecialchars($Restaurant->getName()); ?></strong> - 
                    Cuisine : <?php echo htmlspecialchars($Restaurant->getCuisineType()); ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <h1>ça marche a moitié</h1>
        <?php endif; ?>
    </ul>
</section>
