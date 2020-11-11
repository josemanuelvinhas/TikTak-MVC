<div class="col-12 mb-4 mt-5">
    <form method="get" action="index.php">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">#</div>
            </div>
            <input type="hidden" name="controller" value="video">
            <input type="hidden" name="action" value="search">
            <input class="form-control" type="search" name="hashtag" placeholder="<?= i18n("SearchByHashtag") ?>">
        </div>
    </form>
</div>
