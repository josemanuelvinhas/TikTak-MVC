<?php
//file: view/home/index.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$next = $view->getVariable("next");
$previous = $view->getVariable("previous");
$page = $view->getVariable("page");

?>

<div class="col-12 justify-content-center d-xl-none d-block">
    <div class="col-12 mt-4">
        <?php
        include(__DIR__ . "/../layouts/search_bar.php");
        ?>
    </div>
</div>


<div class="col-12 col-xl-9 row m-0justify-content-center">
    <div class="col-12 row  mt-3 justify-content-center m-0">
        <h4 class="m-0 mt-4"><?= i18n("Index") ?></h4>
    </div>

    <?php
    include(__DIR__ . "/../layouts/videos_view.php");
    ?>

    <div class="col-12 row justify-content-center align-items-center mt-2">
        <?php if (isset($previous)): ?>
            <a href="index.php?controller=home&action=index&page=<?= $previous ?>" class="m-2">
                <img class="bt-pag m-2" src="static/img/anterior.svg" alt="<?= i18n("Previous") ?>">
            </a>
        <?php endif ?>

        <a href="index.php?controller=home&action=index&page=<?= $page ?>"
           class="m-2"><?= $page ?></a>

        <?php if (isset($next)): ?>
            <a href="index.php?controller=home&action=index&page=<?= $next ?>" class="m-2">
                <img class="bt-pag m-2" src="static/img/proximo.svg" alt="<?= i18n("Next") ?>">
            </a>
        <?php endif ?>
    </div>
</div>


<div class="col-3 justify-content-center d-none d-xl-block">
    <div class="row sticky-top">
        <?php
        include(__DIR__ . "/../layouts/search_bar.php");
        ?>

        <?php
        include(__DIR__ . "/../layouts/trends.php");
        ?>

        <?php
        include(__DIR__ . "/../layouts/top_users.php");
        ?>
    </div>
</div>
