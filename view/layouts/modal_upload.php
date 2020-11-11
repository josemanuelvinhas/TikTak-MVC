<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors_upload");
$user = $view->getVariable("user");

?>

<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= i18n("Upload Video") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="index.php?controller=video&amp;action=upload" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="formUploadInVideo"><?= i18n("Video") ?></label>
                        <input type="file" accept="video/mp4" class="form-control-file" name="videoUpload"
                               id="formUploadInVideo"
                               placeholder="<?= i18n("Video") ?>">
                        <?php if (isset($errors["video"])) { ?>
                            <small class="form-text text-danger">
                                <?php foreach ($errors["video"] as $err) { ?>
                                    <?= i18n($err) . " " ?>
                                <?php } ?>
                            </small>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="formUploadInDescripcion"><?= i18n("Description") ?></label>
                        <textarea class="form-control" id="formUploadInDescripcion" name="description"
                                  placeholder="<?= i18n("Description") ?>" rows="5"></textarea>
                        <?php if (isset($errors["videodescription"])) { ?>
                            <small class="form-text text-danger">
                                <?php foreach ($errors["videodescription"] as $err) { ?>
                                    <?= i18n($err) . " " ?>
                                <?php } ?>
                            </small>
                        <?php } ?>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn bt-secondary"><?= i18n("Upload Video") ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
