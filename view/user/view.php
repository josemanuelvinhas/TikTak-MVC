<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$posts = $view->getVariable("videos");
$usuario = $view->getVariable("usuario");
$isFollowing = $view->getVariable("isFollowing");

?>

<div class="col-12 row justify-content-center m-0 mt-5 mb-3 p-0">
    <div class="col-xl-6 col-lg-8 col-10 m-0 p-0 list-group">

        <div class="row row-cols-2 justify-content-between align-items-center p-0 pb-2 pt-2 list-group-item bg-gris">
            <h5 class="col text-center m-0 p-0 font-weight-bold"><?= "@" . $usuario->getUsername() ?></h5>
            <?php if (isset($_SESSION["currentuser"])) {
                if ($usuario->getUsername() === $_SESSION["currentuser"]): ?>
                    <div class="col text-center">
                        <a data-toggle="modal" data-target="#modalUpload">
                            <img class="bt-subir m-2" src="static/img/subir.svg"
                                 alt="<?= i18n("Upload Video") ?>">
                        </a>
                    </div>
                <?php else:
                    if ($isFollowing === true):?>
                        <div class="col text-center">
                            <form action="index.php?controller=follower&action=unfollow" method="post">
                                <input type="hidden" name="username" value="<?= $usuario->getUsername() ?>">
                                <input class="btn bt-outline-primary m-1" type="submit" value="<?= i18n("Unfollow") ?>"">
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="col text-center">
                            <form action="index.php?controller=follower&action=follow" method="post">
                                <input type="hidden" name="username" value="<?= $usuario->getUsername() ?>">
                                <input class="btn bt-primary m-1" type="submit" value="<?= i18n("Follow") ?>"">
                            </form>
                        </div>
                    <?php endif;
                endif;
            } else { ?>
                <div class="col text-center">
                    <button class="btn bt-primary m-1" data-toggle="modal"
                            data-target="#modalLogin"><?= i18n("Follow") ?></button>
                </div>
            <?php } ?>


        </div>

        <div class="row row-cols-3 justify-content-between p-0 pt-3 pb-3 list-group-item">
            <div class="col row row-cols-1 justify-content-center p-0">
                <div class="col text-center"><?= count($posts) ?></div>
                <div class="col text-center"><?= i18n("videos") ?></div>
            </div>
            <div class="col row row-cols-1 justify-content-center p-0">
                <div class="col text-center"><?= $usuario->getNfollowers() ?></div>
                <div class="col text-center"><?= i18n("followers") ?></div>
            </div>
            <div class="col row row-cols-1 justify-content-center p-0">
                <div class="col text-center"><?= $usuario->getNfollowings() ?></div>
                <div class="col text-center"><?= i18n("following") ?></div>
            </div>
        </div>

        <div class="row row-cols-sm-3 row-cols-1 p-0 pt-3 pb-3 list-group-item">
            <?php
            $cont = 0;
            foreach ($posts as $post):
                if (($cont % 3) === 0):
                    ?>
                    <div class="col row justify-content-sm-end justify-content-center m-0">
                        <a href="index.php?controller=video&amp;action=view&amp;id=<?= $post->getId() ?>">
                            <video class="video-card-perfil m-1" src="upload_videos/<?= $post->getVideoname() ?>"
                                   muted loop></video>
                        </a>
                    </div>
                <?php elseif (($cont % 3) === 1): ?>
                    <div class="col row justify-content-sm-center justify-content-center m-0">
                        <a href="index.php?controller=video&amp;action=view&amp;id=<?= $post->getId() ?>">
                            <video class="video-card-perfil m-1" src="upload_videos/<?= $post->getVideoname() ?>"
                                   muted loop></video>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="col row justify-content-sm-start justify-content-center m-0">
                        <a href="index.php?controller=video&amp;action=view&amp;id=<?= $post->getId() ?>">
                            <video class="video-card-perfil m-1" src="upload_videos/<?= $post->getVideoname() ?>"
                                   muted loop></video>
                        </a>
                    </div>
                <?php endif;
                $cont++;
            endforeach; ?>
        </div>

    </div>
</div>