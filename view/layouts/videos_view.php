<?php
// file: view/layouts/videos_view.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$posts = $view->getVariable("videos");
$idLikes = $view->getVariable("idLikes");
$followers = $view->getVariable("followers");

?>


<div class="col-12 row row-cols-lg-3 row-cols-md-2 row-cols-1 m-0justify-content-center ">
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
                                           value="<?= i18n("Unfollow") ?>">
                                </form>
                            <?php } else { ?>
                                <form action="index.php?controller=follower&action=follow" method="post">
                                    <input type="hidden" name="username" value="<?= $post->getAuthor() ?>">
                                    <input class="btn bt-primary m-1" type="submit" value="<?= i18n("Follow") ?>">
                                </form>
                            <?php }
                        } else { ?>
                            <a><img class="bt-fav m-2 invisible" src="static/img/borrar.svg"
                                    alt="<?= i18n("Delete") ?>"></a>
                        <?php }
                    } else { ?>
                        <button class="btn bt-primary m-1" data-toggle="modal"
                                data-target="#modalLogin"><?= i18n("Follow") ?></button>
                    <?php } ?>
                </div>

                <div class="card-body row justify-content-center p-2">
                    <a href="index.php?controller=video&amp;action=view&amp;id=<?= $post->getId() ?>">
                        <video class="video-card" src="upload_videos/<?= $post->getVideoname() ?>" autoplay muted
                               loop
                               ></video>
                    </a>
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
                                                                  alt="<?= i18n("Like") ?>"></a><?= $post->getNlikes() ?>
                            <?php } ?>
                        </div>

                        <a onclick="copyToClipboard('<?= "localhost/tiktak/index.php?controller=video&amp;action=view&amp;id=" . $post->getId() ?>')"  data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?= i18n("Click to copy to clipboard") ?>"><img class="bt-fav m-2" src="static/img/compartir.svg"
                                                                    alt="<?= i18n("Share") ?>"></a>
                    </div>
                    <div class="row justify-content-center">
                        <p class="m-0 p-0"><?= $post->getVideodescription() ?></p>
                    </div>

                </div>


            </div>
        </div>
    <?php endforeach; ?>
</div>