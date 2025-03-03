<?php foreach ($restaurants as $restaurant): ?>
    <div>
        <h2><?= $restaurant->getName() ?></h2>
        <p><?= $restaurant->getCuisineType() ?></p>
    </div>
<?php endforeach; ?>