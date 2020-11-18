<?php
// file: view/layouts/top_users.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$topUsuarios = $view->getVariable("topUsuarios");
?>


<div class="col-12 list-group mt-4">
    <h5 class="m-0 list-group-item bg-gris text-center"><?= i18n("Top-5 Users") ?></h5>
    <?php
    $cont = 1;
    foreach ($topUsuarios as $topUsuario) { ?>
        <a href="index.php?controller=user&amp;action=view&amp;username=<?= $topUsuario["username"] ?>" class="list-group-item list-group-item-action">
            <div class="row justify-content-between align-items-center ml-1 mr-1">
                @<?= $topUsuario["username"] ?>
                <?php if ($cont == 1) { ?>
                    <img class="medalla" src="static/img/1Trophy.png" alt="<?= i18n("Gold Medal") ?>">
                <?php } elseif ($cont == 2) { ?>
                    <img class="medalla" src="static/img/2Trophy_2.png" alt="<?= i18n("Silver Medal") ?>">
                <?php } elseif ($cont == 3) { ?>
                    <img class="medalla" src="static/img/3Trophy_2.png" alt="<?= i18n("Bronze Medal") ?>">
                <?php }
                $cont++;
                ?>
            </div>
        </a>
    <?php } ?>
</div>
