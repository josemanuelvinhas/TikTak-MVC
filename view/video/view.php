<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

?>


<div class="col-12 justify-content-center">
    <div class="col-10 col-sm-12 row justify-content-center m-0 mt-3 mb-3 p-0">
        <div class="m-0 p-0 list-group">
            <div
                    class="row row-cols-2 justify-content-center align-items-center p-0 pb-2 pt-2 list-group-item bg-gris">
                <div class="col font-weight-bold">@yomiquesh</div>
                <div class="col text-right">
                    <div class="btn-group dropleft">
                        <img class="bt-menu m-2" src="static/img/menuHor.svg" data-toggle="dropdown" alt="abrir menu video">
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="dropdown-item"
                                   href="index.php?controller=home&action=index">Inicio</a></li>
                            <li><a class="dropdown-item"
                                   href="index.php?controller=user&action=home">Portada</a></li>
                            <li><a class="dropdown-item"
                                   href="index.php?controller=user&action=view&username=yomiquesh">Perfil</a>
                            </li>
                            <li><a class="dropdown-item" data-toggle="modal" data-target="#modalUpload"
                                   href="">Subir
                                    Video</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item"
                                   href="index.php?controller=user&amp;action=logout">Pechar
                                    Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 p-0 pt-3 pb-3 list-group-item">
                <div class="col row justify-content-center m-0">
                    <video class="video-card-view m-1" src="videos/video_2.mp4" autoplay muted loop
                           controls></video>
                </div>
            </div>

            <div class="row justify-content-between align-items-center pt-3 pb-3 list-group-item">

                <div class="row m-0 p-0 align-items-center">
                    <a data-toggle="modal" data-target="#modalLogin"><img class="bt-fav m-2"
                                                                          src="img/estrella_llena.svg"
                                                                          alt="me gusta"></a>
                    12736
                </div>
                <div class="row m-0 p-0 text-right">
                    <a onclick=""><img class="bt-fav m-2" src="img/compartir.svg" alt="compartir"></a>
                </div>
            </div>


            <div class="row pt-3 pb-3 list-group-item">

                <p class="m-0 p-0 text-center description">It’s starting to look like Christmas 🎄 a little bit
                    of creation #fyp #parati #christmas It’s starting to look like Christmas 🎄 a little bit
                    of creation #fyp #parati #christmas It’s starting to look like Christmas 🎄 a little bit
                    of creation #fyp #parati #christmas It’s starting to look like Christmas 🎄 a little bit
                    of creation #fyp #parati #christmas</p>
            </div>
        </div>
    </div>
</div>