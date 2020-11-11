<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$hashtag = $view->getVariable("hashtag");
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
        <h4 class="m-0 mt-4"><?= i18n("Search by") . " #" . $hashtag ?></h4>
    </div>

    <?php
    include(__DIR__ . "/../layouts/videos_view.php");
    ?>

    <?php
    include(__DIR__ . "/../layouts/page_bar.php");
    ?>
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


