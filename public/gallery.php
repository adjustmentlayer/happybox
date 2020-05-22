<?php require_once("../resources/config.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@1.6.12/dist/css/lightgallery.min.css" >
    <title>Фотогалерея</title>
    <?php include(TEMPLATE_FRONT .DS. "header.php"); ?>
    <main class="page__main container">
        <div class="main__gallery">
            <h1 class="main__gallery-heading">Фотогалерея</h1>
            <div class="gallery" id="gallery">
                <?php get_photos(); ?>
            </div>
        </div>
    </main>
    <?php include(TEMPLATE_FRONT . DS . "footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@1.6.12/dist/js/lightgallery.min.js"></script>
    <script type="text/javascript">
        $('#gallery').lightGallery({
            selector: '.item'
        });
    </script>
</body>
</html>