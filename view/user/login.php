<?php
//file: /view/user/login.php

include(__DIR__ . "/../home/index.php");
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

?>


<?php $view->moveToFragment("modal"); ?>
    onLoad="abrirLogin()"
<?php $view->moveToDefaultFragment(); ?>