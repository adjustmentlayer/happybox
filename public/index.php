<?php require_once("../resources/config.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>My Surprise Box</title>
    <?php include(TEMPLATE_FRONT .DS. "header.php"); ?>
        <main class="page__main main" role="main">
            <div class="main__content container d-flex">
                <div class="main__img img-wrapper">
                    <img src="img/mysuprisebox.png" alt="MySurpriseBox">
                </div>
                <div class="main__info">
                    <h1 class="main__h1">Найди<br> <span class="smaller-text">гарантированно&nbsp;приз,<br></span> который&nbsp;тебе <br><span class="smaller-text">точно&nbsp;понравится!</span></h1>
                    <?php include(TEMPLATE_FRONT . DS . "modal.php"); ?> 
                </div>
                
            </div>
        </main>
        <section class="features container">
            <div class="features__feature">
                <div class="features__icon"><img src="img/gift.png" alt="Подарок"></i></div>
                <p class="features__text text-center ">Гарантировано получаете полезный подарок.</p>
            </div>
            <div class="features__feature">
                <div class="features__icon"><img src="img/win-ticket.png" alt="Победный билет"></div>
                <p class="features__text text-center ">Ежемесячный розыгрыш супер приза.</p>
            </div>
            <div class="features__feature">
                <div class="features__icon"><img src="img/95chance.png" alt="95%"></div>
                <p class="features__text text-center ">Окупаемость бокса в 95% случаях.</p>
            </div>
            <div class="features__feature">
                <div class="features__icon"><img src="img/truck.png" alt="Машина"></div>
                <p class="features__text text-center ">Отправка бокса в течении 2-х дней.</p>
            </div> 
        </section>
        <section class="container">
            <h2 class="page__h2 text-center">Список товаров:</h2>
            <div class="products-list d-grid">
            <?php 
                get_products(); 
            ?>
            </div>
        </section>
        <?php include(TEMPLATE_FRONT . DS . "footer.php");?>
    <script src="js/script.js"></script>
</body>
</html>