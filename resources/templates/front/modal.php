<?php $arr_box = get_box_by_id("1"); ?>
<button href="./resources/cart.php?add=<?php echo $arr_box['box_id']; ?>" class="open-modal-btn button button_size_l button_color_orange button_extended" rel="nofollow">Купить</button>
<div class="modal-box">
    <div class="modal-box__outer">
        <div class="modal-box__inner">
            <div class="modal-box__close-btn-container"><span class="modal-box__close-btn"><i class="fas fa-times fa-2x"></i></span></div>
            <div class="modal-box__row1 d-flex">
                <div class="modal-box__product-info d-flex">
                    <div class="modal-box__product-img">
                        <img src="img/mysuprisebox.png" alt="MySurpriseBox">
                    </div>
                    <div class="modal-box__product-label"><?php echo $arr_box['box_name']; ?></div>
                </div>
                <div class="modal-box__counter-section d-flex">
                    <div class="modal-box__product-price"><?php echo $arr_box['box_price']; ?>&nbsp;грн.</div>
                    <div class="modal-box__counter counter d-flex">
                        <a href="../resources/cart.php?remove=<?php echo $arr_box['box_id']; ?>" class="counter__item link link_color_black counter__decrease-btn" rel="nofollow" >-</a>
                        <div class="counter__item counter__quantity">0</div>
                        <a href="../resources/cart.php?add=<?php echo $arr_box['box_id']; ?>" class="counter__item link link_color_black counter__increase-btn" rel="nofollow">+</a>
                    </div>
                </div>
            </div>
            <div class="modal-box_row2 d-flex">
                <p class="modal-box__total-sum">Общая сумма: <span class="modal-box__total-sum-value"></span> грн.</p>
                <a href="checkout.php" class="button link link_color_black button_size_m ">Оформить заказ</a>
            </div>
        </div>
    </div>
</div>