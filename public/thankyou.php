<?php require_once("../resources/config.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Спасибо за заказ!</title>
    <?php include(TEMPLATE_FRONT .DS. "header.php"); ?>
    <div class="thank-you-content">
        <div class="thanks">Благодарим Вас за заказ!</div>
        <div class="check-mark"><img src="img/check-mark.png" alt="Галочка"></div>
        <div class="order-success-notification">"Ваш заказ успешно принят и отправлен в работу!"</div>
        <div class="process-explanation"><p>В ближайшее время Вам перезвонит менеджер для подтверждения заказа. Затем заказ будет подготовлен и отправлен на указанный Вами адрес.</p></div>
    </div>
    <?php include(TEMPLATE_FRONT . DS . "footer.php");?>
</body>
</html>