<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$video = $view->getVariable("video");
$isLike = $view->getVariable("isLike");
$isFollow = $view->getVariable("isFollow");

?>


<div class="col-12 justify-content-center">
    <div class="col-10 col-sm-12 row justify-content-center m-0 mt-3 mb-3 p-0">
        <div class="m-0 p-0 list-group">
            <div
                    class="row row-cols-2 justify-content-center align-items-center p-0 pb-2 pt-2 list-group-item bg-gris">
                <div class="col font-weight-bold">
                    <a class="text-dark"
                       href="index.php?controller=user&action=view&username=<?= $video->getAuthor() ?>">
                        @<?= $video->getAuthor() ?></a>
                </div>
                <div class="col text-right">

                    <?php if (isset($_SESSION["currentuser"])) {
                        if ($video->getAuthor() === $_SESSION["currentuser"]) { ?>
                            <form action="index.php?controller=video&action=delete" method="post">
                                <input type="hidden" name="id" value="<?= $video->getId() ?>">
                                <input class="bt-fav m-2" type="image" src="static/img/borrar.svg"
                                       alt="<?= i18n("Delete") ?>">
                            </form>
                        <?php } else {
                            if ($isFollow === true) { ?>
                                <form action="index.php?controller=follower&action=unfollow" method="post">
                                    <input type="hidden" name="username" value="<?= $video->getAuthor() ?>">
                                    <input class="btn bt-outline-primary m-1" type="submit"
                                           value="<?= i18n("Unfollow") ?>"">
                                </form>
                            <?php } else { ?>
                                <form action="index.php?controller=follower&action=follow" method="post">
                                    <input type="hidden" name="username" value="<?= $video->getAuthor() ?>">
                                    <input class="btn bt-primary m-1" type="submit" value="<?= i18n("Follow") ?>"">
                                </form>
                            <?php }
                        }
                    } else { ?>
                    <button class="btn bt-primary m-1" data-toggle="modal"
                            data-target="#modalLogin"><?= i18n("Follow") ?>
                        <?php } ?>
                </div>
            </div>

            <div class="row row-cols-1 p-0 pt-3 pb-3 list-group-item">
                <div class="col row justify-content-center m-0">
                    <video class="video-card-view m-1" src="upload_videos/<?= $video->getVideoname() ?>" autoplay muted
                           loop
                           controls></video>
                </div>
            </div>

            <div class="row justify-content-between align-items-center pt-3 pb-3 list-group-item">

                <div class="row m-0 p-0 align-items-center">
                    <?php if (isset($_SESSION["currentuser"])) {
                        if ($isLike) { ?>

                            <form action="index.php?controller=like&action=dislike" method="post">
                            <input type="hidden" name="id" value="<?= $video->getId() ?>">
                            <input type="hidden" name="username" value="<?= $_SESSION["currentuser"] ?>">
                            <input class="bt-fav m-2" type="image" src="static/img/estrella_llena.svg"
                                   alt="<?= i18n("Dislike") ?>">
                            </form><?= $video->getNlikes() ?>
                        <?php } else { ?>

                            <form action="index.php?controller=like&action=like" method="post">
                            <input type="hidden" name="id" value="<?= $video->getId() ?>">
                            <input type="hidden" name="username" value="<?= $_SESSION["currentuser"] ?>">
                            <input class="bt-fav m-2" type="image" src="static/img/estrella_vacia.svg"
                                   alt="<?= i18n("Like") ?>">
                            </form><?= $video->getNlikes() ?>
                        <?php } ?>

                    <?php } else { ?>

                        <a data-toggle="modal"
                           data-target="#modalLogin"><img class="bt-fav m-2"
                                                          src="static/img/estrella_vacia.svg"
                                                          alt="<?= i18n("Like") ?>"></a><?= $video->getNlikes() ?>
                    <?php } ?>
                </div>
                <div class="row m-0 p-0 text-right">
                    <a onclick="copyToClipboard('<?= "localhost/tiktak/index.php?controller=video&amp;action=view&amp;id=" . $video->getId() ?>')"  data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?= i18n("Click to copy to clipboard") ?>"><img class="bt-fav m-2" src="static/img/compartir.svg"
                                                                                                                                                                                                                                                                                 alt="<?= i18n("Share") ?>"></a>
                </div>
            </div>


            <div class="row pt-3 pb-3 list-group-item">

                <p class="m-0 p-0 text-center description"><?= $video->getVideoDescription() ?></p>
            </div>
        </div>
    </div>
</div>