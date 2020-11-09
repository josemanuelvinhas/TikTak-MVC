<?php
// file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $view->getVariable("title", "TikTak") ?></title>
    <link rel="icon" type="image/png" href="static/img/logo.png">
    <link href="static/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="static/css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="static/css/imagenes.css" rel="stylesheet" type="text/css">
    <link href="static/css/botones.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/js/login_register.js"></script>
</head>
<body <?= $view->getFragment("login_register") ?>>
<div class="container-fluid bg-white">
    <header class="row align-items-center justify-content-around border-bottom border-ligth pt-2 pb-2">
        <div class="col-12 col-sm-6 col row align-items-center justify-content-center justify-content-sm-start">
            <a href="index.php?controller=home&action=index">
                <img class="logo_header" src="static/img/logo.png" alt="Logo">
            </a>

            <a href="index.php?controller=home&action=index">
                <img class="nombre_header" src="static/img/nombre.png" alt="TikTak">
            </a>
        </div>

        <div class="col-12 col-sm-6 row justify-content-center align-items-center justify-content-sm-end">
            <?php if (!isset($currentuser)) { ?>
                <button class="btn bt-secondary m-1" data-toggle="modal"
                        data-target="#modalLogin"><?= i18n("Log in") ?></button>
                <button class="btn bt-outline-secondary m-1" data-toggle="modal"
                        data-target="#modalRegister"><?= i18n("Sing in") ?></button>
            <?php } else { ?>
                <div class="m-0 mr-3 font-weight-bold"><a class="text-dark"
                                                          href="index.php?controller=user&action=view&username=<?= $_SESSION["currentuser"] ?>"><?= "@" . $_SESSION["currentuser"] ?></a>
                </div>
                <div class="btn-group dropleft">
                    <img class="bt-menu m-2" src="static/img/menu.svg" data-toggle="dropdown" alt="abrir menu">
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-item"
                               href="index.php?controller=home&action=index"><?= i18n("Index") ?></a></li>
                        <li><a class="dropdown-item" href="index.php?controller=user&action=home"><?= i18n("Home") ?></a></li>
                        <li><a class="dropdown-item"
                               href="index.php?controller=user&action=view&username=<?= $_SESSION["currentuser"] ?>"><?= i18n("Profile") ?></a>
                        </li>
                        <li><a class="dropdown-item" data-toggle="modal"
                               data-target="#modalUpload" href="" ><?= i18n("Upload Video") ?></a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item"
                               href="index.php?controller=user&amp;action=logout"><?= i18n("Log out") ?></a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>

    </header>

    <main class="row mb-5">
        <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>

    <?php if (!isset($currentuser)):
        include(__DIR__ . "./modal_login.php");
        include(__DIR__ . "./modal_register.php");
    else:
        include(__DIR__ . "./modal_upload.php");
    endif ?>

    <footer class="row align-items-md-center border-top border-ligth fixed-bottom bg-white mt-5 p-2">
        <?php
        include(__DIR__ . "./language_select_element.php");
        ?>

        <div class="col-8">
            <p class="text-right m-0">©2020 TikTak</p>
        </div>

    </footer>
</div>

</body>
</html>