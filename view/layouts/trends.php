<?php
// file: view/layouts/trends.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$trends = $view->getVariable("trends");
?>


<div class="col-12 list-group">
    <h5 class="m-0 list-group-item bg-gris text-center"><?= i18n("Trends") ?></h5>
    <?php foreach ($trends as $trend) { ?>
        <a href="index.php?controller=video&amp;action=search&amp;hashtag=<?= substr($trend, 1) ?>"
           class="list-group-item list-group-item-action"><?= $trend ?></a>
    <?php } ?>
</div>
