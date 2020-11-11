<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$next = $view->getVariable("next");
$previous = $view->getVariable("previous");
$page = $view->getVariable("page");

?>


<div class="col-12 row justify-content-center align-items-center mt-2">
    <?php if (isset($previous)): ?>
            <!-- TODO arreglar link cuando no hay hashtag -->
        <a href="index.php?controller=video&action=search<?php if (isset($hashtag)){?> <?= "&hashtag=" . $hashtag ?> <?php } ?>&page=<?= $previous ?>" class="m-2">
            <img class="bt-pag m-2" src="static/img/anterior.svg" alt="anterior">
        </a>
    <?php endif ?>

    <a href="index.php?controller=video&action=search&hashtag=<?= $hashtag ?>&page=<?= $page ?>"
       class="m-2"><?= $page ?></a>

    <?php if (isset($next)): ?>
        <a href="index.php?controller=video&action=search&hashtag=<?= $hashtag ?>&page=<?= $next ?>" class="m-2">
            <img class="bt-pag m-2" src="static/img/proximo.svg" alt="siguiente">
        </a>
    <?php endif ?>
</div>
