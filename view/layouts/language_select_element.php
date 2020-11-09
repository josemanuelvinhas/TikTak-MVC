<?php
// file: view/layouts/language_select_element.php
?>
<div class="col-4 dropup">
    <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">Idioma</button>
    <ul id="languagechooser" class="dropdown-menu">
        <li><a class="dropdown-item" href="index.php?controller=language&amp;action=change&amp;lang=es">
                <?= i18n("Spanish") ?>
            </a></li>
        <li><a class="dropdown-item" href="index.php?controller=language&amp;action=change&amp;lang=en">
                <?= i18n("English") ?>
            </a></li>
        <li><a class="dropdown-item" href="index.php?controller=language&amp;action=change&amp;lang=gl">
                <?= i18n("Galician") ?>
            </a></li>
    </ul>
</div>