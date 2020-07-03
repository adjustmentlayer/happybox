var button = document.querySelector('.form__submit-button');
var formErrors = document.querySelector('.form__error');
var formErrorsList = document.querySelector('.form__error-list');
var liqpay = document.querySelector("#liqpay");

function clearFormErrors() {
    formErrors.style.display = "none";
}

function displayErrors(errors) {

    formErrors.classList.remove('form__error_hidden');
    document.querySelector('.form__error').scrollIntoView({ behavior: 'smooth' });
    var inputs = document.getElementsByTagName('input');
    var selects = document.getElementsByTagName('select');
    for (i = 0; i < inputs.length; i++) {
        var input = inputs[i];

        if (errors.fields.hasOwnProperty(input.name)) {
            input.previousElementSibling.classList.add('label_invalid');
        }
    }
    for (i = 0; i < selects.length; i++) {
        var select = selects[i];
        if (errors.fields.hasOwnProperty(select.name)) {
            select.classList.add('select_invalid');
        }
    }
    for (var prop in errors.fields) {

        if (errors.fields[prop].hasOwnProperty('requiredError')) {
            formErrorsList.innerHTML += '<li class="list-item"><b class="strong">Поле ' + errors.fields[prop].descriptionRu + '</b> является обязательным полем</li>';
        }
        if (errors.fields[prop].hasOwnProperty('patternError')) {
            formErrorsList.innerHTML += '<li class="list-item">Введите поле<b class="strong"> ' + errors.fields[prop].descriptionRu + '</b> в правильном формате</li>';
        }
        if (errors.fields[prop].hasOwnProperty('maxLengthError')) {
            formErrorsList.innerHTML += '<li class="list-item"><b class="strong">Поле ' + errors.fields[prop].descriptionRu + '</b> слишком длинное</li>';
        }
    }
}

function clearErrors() {
    formErrors.classList.add('form__error_hidden');
    formErrorsList.innerHTML = "";
    var inputs = document.getElementsByTagName('input');
    var selects = document.getElementsByTagName('select');
    for (i = 0; i < inputs.length; i++) {
        inputs[i].previousElementSibling.classList.remove('label_invalid');
    }
    for (i = 0; i < selects.length; i++) {
        selects[i].classList.remove('select_invalid');
    }

}

function disableSubmitButton() {

    button.disabled = true;
}

function enableSubmitButton() {

    button.disabled = false;
}

function placeOrder() {
    showSpinner();
    clearErrors();
    disableSubmitButton();
    var form = document.querySelector(".checkout-panel__form");
    var action = form.getAttribute("action");

    // gather form data
    var form_data = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', action, true);

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            enableSubmitButton();

            var json = JSON.parse(result);
            if (json.hasOwnProperty('errors')) {
                displayErrors(json.errors);
                window.scrollTo({
                    top: 100,
                    behavior: "smooth"
                });
            } else {
                if(json.payment_method == "онлайн-оплата"){
                    liqpay.innerHTML = json.html_form;
                    let liqpayForm = document.querySelector("#liqpay-form");
                    liqpayForm.submit();
                }else{
                    window.location = "thankyou.php";
                }
                
            }
        }
        hideSpinner();
    };
    xhr.send(form_data);
}

button.addEventListener("click", function(e) {
    e.preventDefault();
    placeOrder();
});

$.jMaskGlobals = {
    translation: {
        'n': { pattern: /\d/ },
    }
};
$('.phone-mask').mask('+38(0nn)-nnn-nnnn').val('+38(0');
var reCaptchaWidth = 302;
var containerWidth = $('.form__recaptcha').width();
if (reCaptchaWidth > containerWidth) {
    var reCaptchaScale = containerWidth / reCaptchaWidth;
    $('.g-recaptcha').css({
        'transform': 'scale(' + reCaptchaScale + ')',
        'transform-origin': 'left top'
    });
}
window.addEventListener("resize", function() {
    var reCaptchaWidth = 302;
    var containerWidth = $('.form__recaptcha').width();
    if (reCaptchaWidth > containerWidth) {
        var reCaptchaScale = containerWidth / reCaptchaWidth;
        $('.g-recaptcha').css({
            'transform': 'scale(' + reCaptchaScale + ')',
            'transform-origin': 'left top'
        });
    }
});