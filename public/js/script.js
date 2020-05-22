var bDecreasable = false;
// Получить модальное окно
var modal = document.querySelector(".modal-box");
// Получить кнопку закрытия модльного окна
var modalCloseBtn = document.querySelector(".modal-box__close-btn");

// Получить спинер
var spinner = document.querySelector(".spinner");

// Получить метку общей суммы в модальном окне
var totalSum = document.querySelector(".modal-box__total-sum-value");

// Получить метку количества счетчика
var counterQuantity = document.querySelector(".counter__quantity");

// Получить внешнюю обертку модального окна
var modalOuter = document.querySelector(".modal-box__outer");

// Получить кнопку, которая открывает модальное окно
var openModalBtn = document.querySelector(".open-modal-btn");

// Получить кнопку уменьшения количества коробок
var counterDecreaseBtn = document.querySelector(".counter__decrease-btn");

// Получить кнопку увеличения количества коробок
var counterInreaseBtn = document.querySelector(".counter__increase-btn");

function showSpinner(){
    spinner.style.display = "flex";
}

function hideSpinner(){
    spinner.style.display = "none";
}
// Ajax запрос
function makeRequest(url, func) {
    
    var httpRequest = false;

    if(window.XMLHttpRequest) {// Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if(httpRequest.overrideMimeType) {
            httpRequest.overrideMimeType('text/xml')
        }
    } else if (window.ActiveXObject) { //IE
        try {
            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {}
    }

    if(!httpRequest) {
        alert('Не вышло :( Невозможно создать экземляр класса XMLHTTP');
        return false;
    }
    httpRequest.onreadystatechange = function () { func(httpRequest);};
    httpRequest.open('GET', url, true);
    httpRequest.send(null);
}
function alertContents(httpRequest) {
    showSpinner();
    if(httpRequest.readyState == 4) {
        hideSpinner();
        var objOrder = JSON.parse(httpRequest.responseText);
        if(objOrder[0]['box_quantity']==1){
            counterDecreaseBtn.classList.add("link_disabled");
            bDecreasable = false;
        }else{
            bDecreasable = true;
            counterDecreaseBtn.classList.remove("link_disabled");
        }
        counterQuantity.innerHTML = objOrder[0]['box_quantity']+"";
        totalSum.innerHTML = objOrder[0]['box_quantity']*objOrder[0]['box_price'];  
    }
}
function openModal(httpRequest){
    showSpinner();
    if(httpRequest.readyState == 4) {
        
        var objOrder = JSON.parse(httpRequest.responseText);
        
        if(objOrder[0]['box_quantity']==1){
            counterDecreaseBtn.classList.add("link_disabled");
            bDecreasable = false;
        }else{
            bDecreasable = true;
            counterDecreaseBtn.classList.remove("link_disabled");
        }
        counterQuantity.innerHTML = objOrder[0]['box_quantity']+"";
        totalSum.innerHTML = objOrder[0]['box_quantity']*objOrder[0]['box_price'];
        modal.classList.add("modal-box_visible");
        hideSpinner();
        
    }else {
        modal.classList.remove("modal-box_visible");
    }
}


// Когда пользователь нажмет на кнопку, открыть модальное окно
openModalBtn.onclick = function(e) {
    e.preventDefault();
    var link = e.target.getAttribute('href');
    console.log(link);
    makeRequest(link,openModal);
    
}

// Когда пользователь нажмет на кнопку, уменьшить кол-во коробок
counterDecreaseBtn.onclick = function(e) {
    e.preventDefault();
    var link = e.target.getAttribute('href');
    if(bDecreasable){
        makeRequest(link,alertContents);
    }
    
}

// Когда пользователь нажмет на кнопку, увеличеть кол-во коробок
counterInreaseBtn.onclick = function(e) {
    e.preventDefault();
    var link = e.target.getAttribute('href');
    makeRequest(link,alertContents);
}

// Когда пользователь нажмет где-то вне модального окна, закрыть его
window.onclick = function(event) {
    if(event.target == modalOuter){
        modal.classList.remove("modal-box_visible");
    } 
}
modalCloseBtn.onclick = function() {
    modal.classList.remove("modal-box_visible"); 
}


