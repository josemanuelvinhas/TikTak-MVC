<?php
// file: view/layouts/modal_login.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors_log");
$user = $view->getVariable("user");
?>

<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= i18n("Log in") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="index.php?controller=user&amp;action=login" method="post">
                <div class="modal-body">
                    <?php if (isset($errors["general"])) { ?>
                        <p class="form-text text-danger"><?= i18n($errors["general"]) ?></p>
                    <?php } ?>
                    <div class="form-group">
                        <label for="formLoginInUsername"><?= i18n("Username") ?></label>
                        <input type="text" class="form-control" name="username" id="formLoginInAlias"
                               placeholder="<?= i18n("Username") ?>"
                               value="<?= (isset($user) & isset($errors)) ? $user->getUsername() : "" ?>">
                        <?php if (isset($errors["username"])) { ?>
                            <small class="form-text text-danger">
                                <?php foreach ($errors["username"] as $err) { ?>
                                    <?= i18n($err) . " " ?>
                                <?php } ?>
                            </small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="formLoginInPassword"><?= i18n("Password") ?></label>
                        <input type="password" class="form-control" name="passwd" id="formLoginInPassword"
                               placeholder="<?= i18n("Password") ?>"
                               value="<?= (isset($user) & isset($errors)) ? $user->getPasswd() : "" ?>">
                        <?php if (isset($errors["passwd"])) { ?>
                            <small class="form-text text-danger">
                                <?php foreach ($errors["passwd"] as $err) { ?>
                                    <?= i18n($err) . " " ?>
                                <?php } ?>
                            </small>
                        <?php } ?>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn bt-secondary"><?= i18n("Log in") ?></button>
                </div>
            </form>
        </div>
    </div>
</div>