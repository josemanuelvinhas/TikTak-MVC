<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors_reg");
$user = $view->getVariable("user");

?>

<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= i18n("Sing in") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="index.php?controller=user&amp;action=register" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="formRegisterInAlias"><?= i18n("Username") ?></label>
                        <input type="text" class="form-control" name="username" id="formRegisterInAlias"
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
                        <label for="formRegisterInEmail"><?= i18n("Email") ?></label>
                        <input type="text" class="form-control" name="email" id="formRegisterInEmail"
                               placeholder="example@example.com"
                               value="<?= (isset($user) & isset($errors)) ? $user->getEmail() : "" ?>">
                        <?php if (isset($errors["email"])) { ?>
                            <small class="form-text text-danger">
                                <?php foreach ($errors["email"] as $err) { ?>
                                    <?= i18n($err) . " " ?>
                                <?php } ?>
                            </small>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="formRegisterInPassword"><?= i18n("Password") ?></label>
                        <input type="password" class="form-control" name="passwd" id="formRegisterInPassword"
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
                    <button type="submit" class="btn bt-secondary"><?= i18n("Sing in") ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
