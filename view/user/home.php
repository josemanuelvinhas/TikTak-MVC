<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$posts = $view->getVariable("videos");
$idLikes = $view->getVariable("idLikes");

$followers = $view->getVariable("followers");

$next = $view->getVariable("next");
$previous = $view->getVariable("previous");
$page = $view->getVariable("page");
?>

<div class="col-12 row justify-content-center m-0">
    <h4 class="m-0 mt-4"><?= i18n("Home") ?></h4>
</div>

<div class="col-12 justify-content-center d-xl-none d-block">
    <div class="col-12 mt-4">
        <?php
        include(__DIR__ . "/../layouts/menu.php");
        ?>
    </div>
</div>


<div class="col-12 col-xl-9 row row-cols-lg-3 row-cols-md-2 row-cols-1 m-0 mt-3 mt-xl-5 justify-content-center">
    <?php foreach ($posts as $post): ?>
        <div class="col card">
            <div>
                <div class="card-header row justify-content-around align-items-center">
                    <div class="font-weight-bold"><a class="text-dark"
                                                     href="index.php?controller=user&action=view&username=<?= $post->getAuthor() ?>">@<?= $post->getAuthor() ?></a>
                    </div>
                    <?php if (isset($_SESSION["currentuser"])) {
                        if ($_SESSION["currentuser"] != $post->getAuthor()) {
                            if (in_array($post->getAuthor(), $followers)) { ?>
                                <form action="index.php?controller=follower&action=unfollow" method="post">
                                    <input type="hidden" name="username" value="<?= $post->getAuthor() ?>">
                                    <input class="btn bt-outline-primary m-1" type="submit"
                                           value="<?= i18n("Unfollow") ?>"">
                                </form>
                            <?php } else { ?>
                                <form action="index.php?controller=follower&action=follow" method="post">
                                    <input type="hidden" name="username" value="<?= $post->getAuthor() ?>">
                                    <input class="btn bt-primary m-1" type="submit" value="<?= i18n("Follow") ?>"">
                                </form>
                            <?php }
                        } else { ?>
                            <a><img class="bt-fav m-2" src="static/img/borrar.svg"
                                    alt="delete"></a>
                        <?php }
                    } else { ?>
                        <button class="btn bt-primary m-1" data-toggle="modal"
                                data-target="#modalLogin"><?= i18n("Follow") ?></button>
                    <?php } ?>
                </div>

                <div class="card-body row justify-content-center p-2">
                    <video class="video-card" src="upload_videos/<?= $post->getVideoname() ?>" autoplay muted loop
                           controls></video>
                </div>

                <div class="card-footer pt-0 ">
                    <div class="row align-items-center justify-content-around">
                        <div class="row align-items-center">

                            <?php if (isset($_SESSION["currentuser"])) {
                                if (in_array($post->getId(), $idLikes)) { ?>

                                    <form action="index.php?controller=like&action=dislike" method="post">
                                    <input type="hidden" name="id" value="<?= $post->getId() ?>">
                                    <input type="hidden" name="username" value="<?= $_SESSION["currentuser"] ?>">
                                    <input class="bt-fav m-2" type="image" src="static/img/estrella_llena.svg"
                                           alt="<?= i18n("Dislike") ?>">
                                    </form><?= $post->getNlikes() ?>
                                <?php } else { ?>

                                    <form action="index.php?controller=like&action=like" method="post">
                                    <input type="hidden" name="id" value="<?= $post->getId() ?>">
                                    <input type="hidden" name="username" value="<?= $_SESSION["currentuser"] ?>">
                                    <input class="bt-fav m-2" type="image" src="static/img/estrella_vacia.svg"
                                           alt="<?= i18n("Like") ?>">
                                    </form><?= $post->getNlikes() ?>
                                <?php } ?>

                            <?php } else { ?>

                                <a data-toggle="modal"
                                   data-target="#modalLogin"><img class="bt-fav m-2"
                                                                  src="static/img/estrella_vacia.svg"
                                                                  alt="me gusta"></a><?= $post->getNlikes() ?>
                            <?php } ?>
                        </div>

                        <a onclick="copyToClipboard()"><img class="bt-fav m-2" src="static/img/compartir.svg"
                                                            alt="compartir"></a>
                    </div>
                    <div class="row justify-content-center">
                        <p class="m-0 p-0"><?= $post->getVideodescription() ?></p>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<div class="col-3 justify-content-center d-none d-xl-block">
    <div class="row sticky-top">
        <div class="col-12 mb-4 mt-5">
            <?php
            include(__DIR__ . "/../layouts/menu.php");
            ?>
        </div>

        <div class="col-12 list-group">
            <h5 class="m-0 list-group-item bg-gris text-center"><?= i18n("Trends") ?></h5>
            <a href="#" class="list-group-item list-group-item-action">#DiversionConBanderas</a>
            <a href="#" class="list-group-item list-group-item-action">#ElImpostor</a>
            <a href="#" class="list-group-item list-group-item-action">#DiccionarioGamer</a>
            <a href="#" class="list-group-item list-group-item-action">#CrackDeLasMates</a>
            <a href="#" class="list-group-item list-group-item-action">#VivaErBeti</a>
        </div>

        <div class="col-12 list-group mt-4">
            <h5 class="m-0 list-group-item bg-gris text-center"><?= i18n("Top-5 Users") ?></h5>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="row justify-content-between align-items-center ml-1 mr-1">
                    @Yomiquesh
                    <img class="medalla" src="static/img/1Trophy.png" alt="medalla oro">
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="row justify-content-between align-items-center ml-1 mr-1">
                    @Dsteve
                    <img class="medalla" src="static/img/2Trophy_2.png" alt="medalla plata">
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="row justify-content-between align-items-center ml-1 mr-1">
                    @Xefinord
                    <img class="medalla" src="static/img/3Trophy_2.png" alt="medalla bronce">
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action">@DavidSholito</a>
            <a href="#" class="list-group-item list-group-item-action">@Maakarov</a>
        </div>

    </div>
</div>

<div class="col-12 row justify-content-center align-items-center mt-2">
    <?php if (isset($previous)): ?>
        <a href="index.php?controller=user&action=home&page=<?= $previous ?>" class="m-2">
            <img class="bt-pag m-2" src="static/img/anterior.svg" alt="anterior">
        </a>
    <?php endif ?>

    <a href="index.php?controller=user&action=home&page=<?= $page ?>" class="m-2"><?= $page ?></a>

    <?php if (isset($next)): ?>
        <a href="index.php?controller=user&action=home&page=<?= $next ?>" class="m-2">
            <img class="bt-pag m-2" src="static/img/proximo.svg" alt="siguiente">
        </a>
    <?php endif ?>
</div>
