<?php require_once("../resources/config.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>My Surprise Box</title>
    <?php include(TEMPLATE_FRONT . DS . "header.php");?>
    <section class="checkout-panel">
        <div class="checkout-panel__inner container">

            <h3 class="h3">Оплата и доставка</h3>
            <form class="checkout-panel__form " action="process_order.php" method="POST">
                <div class="form__error form__error_hidden">
                    <ul class="form__error-list list">
                    </ul>
                </div>
                <div class="form__group-box">
                    <p>
                        <label class="label form__label" for="first_name">Имя&nbsp;<abbr class="label__required-star" title="обязательно">*</abbr></label>
                        <input id="first_name" name="first_name" class="form__input" type="text">
                    </p>
                    <p>
                        <label class="label form__label" for="phone">Телефон&nbsp;<abbr class="label__required-star" title="обязательно">*</abbr></label>
                        <input id="phone" name="phone" class="form__input phone-mask" type="text">
                    </p>
                    <p>
                        <label class="label form__label" for="email">Email&nbsp;</label>
                        <input id="email" name="email" class="form__input" type="text">
                    </p>
                    <p>
                        <label class="label form__label" for="instagram">Ник в Инстаграмме&nbsp;<abbr class="label__required-star" title="обязательно">*</abbr></label>
                        <input id="instagram" name="instagram" class="form__input" type="text">
                    </p>

                </div>
                <div class="form__group-box">
                <p>
                        <label class="label form__label" for="last_name">Фамилия&nbsp;<abbr class="label__required-star" title="обязательно">*</abbr></label>
                        <input id="last_name" name="last_name" class="form__input" type="text">
                    </p>
                </div>
                <div class="form__novaposhta">
                    <div class="novaposhta">
                        <h3 class="h3 novaposhta__heading">Укажите адрес доставки</h3>
                        <select class="novaposhta__select" name="area" id="selectAreas">
                            <option disabled selected value="not_selected">Оберіть область</option>
                        </select>
                        <select class="novaposhta__select" name="settlement" id="selectSettlements"></select>
                        <select class="novaposhta__select" name="warehouse" id="selectWarehouses"></select>
                    </div>
                </div>
                <div class="form__order-review order-review">
                    <h3 class="h3 order-review__heading">Ваш заказ</h3>
                    <?php
                        foreach($_SESSION as $name => $value){
                            if($value > 0){
                                if(substr($name,0,4)== "box_"){
                                    
                                    $length = strlen($name) - 4;
                                    $id = substr($name, 4, $length);
                                    $query = query("SELECT * FROM boxes WHERE box_id = " . escape_string($id)." ");
                                    confirm($query);

                                    while($row = fetch_array($query)){
                                        $row["box_quantity"] = $_SESSION["box_" . escape_string($id).""];?>
                                        <div class="order-review__table table strong">
                                            <div class="table__column">
                                                <div class="table__row">Товар</div>
                                                <div class="table__row light"><?php echo "{$row['box_name']}<strong class='strong'> × {$row['box_quantity']}</strong>" ?></div>
                                                <div class="table__row">Доставка</div>
                                                <div class="table__row">Итого</div>
                                            </div>
                                            <div class="table__column">
                                                <div class="table__row">Итого</div>
                                                <div class="table__row light"><?php echo $row['box_price']*$row['box_quantity'] ?>&nbsp;грн.</div>
                                                <div class="table__row">Новая Почта</div>
                                                <div class="table__row"><?php echo $row['box_price']*$row['box_quantity'] ?>&nbsp;грн.</div>
                                            </div>
                                        </div>
                                    <?php
                                        
                                    } 
                                }
                            }
                        } ?>
                    
                </div>
                <div class="form__recaptcha">
                    <div class="g-recaptcha" data-sitekey="6LfK_uIUAAAAAMshgATbz-vpxAN80ZwApTVluV1O"></div>
                    <div class="text-danger" id="recaptchaError"></div>
                </div>
                
                <div class="form__payment-methods">
                    <label class="label form__payment-method"> Оплата при доставке</label>
                    <button type="submit" class="form__submit-button button link link_color_black button_size_l " name="checkout_place_order" value="Подтвердить заказ" >Подтвердить заказ</button>
                    <div class="form__order-status"></div>
                </div>
            </form>
        </div>
    </section>
    <?php include(TEMPLATE_FRONT . DS . "footer.php");?>
    <script src="js/jquery.mask.js"></script>
    <script src="js/novaposhta.js"></script>
    <script src="js/checkout.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
</body>
</html>