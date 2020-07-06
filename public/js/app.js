const h = require('virtual-dom/h');
const hh = require('hyperscript-helpers'); 

var diff = require('virtual-dom/diff');
var patch = require('virtual-dom/patch');
var createElement = require('virtual-dom/create-element');

var VNode = require('virtual-dom/vnode/vnode');
var VText = require('virtual-dom/vnode/vtext');

var convertHTML = require('html-to-vdom')({
    VNode: VNode,
    VText: VText
});

const {
    div,
    h1,
    pre,
    button,
    a,
    p,
    img,
    h3,
    i
} = hh(h);




const MSGS = {
    ADD_TO_CART_CLICK: 'ADD_TO_CART_CLICK',
    OPEN_CART_CLICK: 'OPEN_CART_CLICK',
    CLOSE_CART_CLICK: 'CLOSE_CART_CLICK',
    REMOVE_PRODUCT_CLICK: 'REMOVE_PRODUCT_CLICK',
    SHOW_INSIDE_PRODUCTS_CLICK: 'SHOW_INSIDE_PRODUCTS_CLICK',
    CLOSE_WHATS_INSIDE_CLICK: 'CLOSE_WHATS_INSIDE_CLICK',
};

function addToCartClickMsg(response){
    return {
        type: MSGS.ADD_TO_CART_CLICK,
        response,
    }
}

function openCartClickMsg(){
    return {
        type: MSGS.OPEN_CART_CLICK
    }
}

function closeCartClickMsg(){
    return {
        type: MSGS.CLOSE_CART_CLICK
    }
}

function removeProductClickMsg(response){
    return {
        type: MSGS.REMOVE_PRODUCT_CLICK,
        response,
    }
}

function showInsideProductsClickMsg(response){
    return {
        type: MSGS.SHOW_INSIDE_PRODUCTS_CLICK,
        response,
    }
}
function closeWhatsInsideClickMsg(){
    return {
        type: MSGS.CLOSE_WHATS_INSIDE_CLICK
    }
}


function getAllBoxes(){
    spinner.style.display = "flex";

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "Home/showBoxes", true);
    xhr.send(); 

    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const result = this.responseText;
                const json = JSON.parse(result);
                const initModel = {
                    boxes:[
                        ...json.boxes,
                    ],
                    cart: [
                        ...json.cart.items,
                    ],
                    cartTotal: json.cart.cartTotal,
                    showCart: false,
                    showWhatsInside: false,
                    insideProducts: [],
                    
                }
                app(initModel, update, view, node);
                spinner.style.display = "none";
            } else {
            console.error(xhr.statusText);
            }
        }else{
            console.log(xhr.responseText);
        }
    };
    xhr.onerror = function (e) {
        console.error(xhr.statusText);
    };

}

function addItem(dispatch, msg, link){
    spinner.style.display = "flex";
    const xhr = new XMLHttpRequest();
    xhr.open("GET", link, true);
    
    xhr.send(); 
    xhr.onload = function (e) {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
    
            const result = this.responseText;
            const json = JSON.parse(result);
            dispatch(msg(json.response));
            spinner.style.display = "none";
        } else {
        console.error(xhr.statusText);
        }
    }else{
        
        console.log(xhr.responseText);
    }
    };
    xhr.onerror = function (e) {
        console.error(xhr.statusText);
    };
}





function update (msg, model) {
    switch(msg.type){
        
        case MSGS.ADD_TO_CART_CLICK:{

            const {items, cartTotal} = msg.response.cart;
            return {...model, cart:[...items],  cartTotal }
        }

        case MSGS.OPEN_CART_CLICK:{
            return { ...model, showCart: true }
        }

        case MSGS.CLOSE_CART_CLICK:{

            return { ...model, showCart: false }
        }

        case MSGS.REMOVE_PRODUCT_CLICK:{

            const {items, cartTotal} = msg.response.cart;

            if(items.length == 0){
                return {...model, cart:[...items],  cartTotal, showCart:false };
            }
            return {...model, cart:[...items],  cartTotal }
        }

        case MSGS.SHOW_INSIDE_PRODUCTS_CLICK:{

            const whatsInsideProducts = msg.response.products;
            return {...model, whatsInsideProducts: [...whatsInsideProducts], showCart: false, showWhatsInside: true }
        }

        case MSGS.CLOSE_WHATS_INSIDE_CLICK:{
            return {...model, showCart: false, showWhatsInside: false }
        }
    }
    return model; 
}

function insideProduct(product){
    return div({className:'w-third'},[
        img({src: '/img/products/' + product.product_img, alt: product.product_name}),
        p({className:'tc'}, product.product_name)
    ]);
}

function whatsInside(dispatch, model){

    if(model.showWhatsInside && !model.showCart){
        const cards = model.whatsInsideProducts.map(element => {
            return insideProduct(element)
        })
           
        return div({
            className: 'fixed top-0 bottom-0 right-0 left-0 flex justify-center items-center z-999 bg-black-70 pa2',
            onclick: (e) => {if(e.target !== e.currentTarget) return; dispatch(closeWhatsInsideClickMsg());}
        }, [
           
            div({
                className: 'relative w7 pa3 bg-light-gray z-max overflow-y-auto',
                style:'max-height: 455px',
            },[
                div({
                    className: 'absolute right-0 top-0 pointer dim',
                    onclick: () => dispatch(closeWhatsInsideClickMsg()),
                }, i({className: 'pa2 fas fa-times f4 f5-l'})),
                div({className: 'pa3  flex flex-wrap'}, cards),
            ]),
            
        ]);
    }
}

function card(dispatch, box) {
    return div({className: 'relative w-100 bg-white br4 pa3 flex flex-row-m flex-row-l flex-column justify-between items-center-ns mv3'},[
        a({
            href: `/home/${box.index}/remove`,
            className: 'link absolute right-0 top-0 pointer dim pa2 fas fa-times',
            onclick: (e) =>  { console.log(e.target);e.preventDefault(); addItem(dispatch, removeProductClickMsg, e.target.getAttribute('href'))},
        }),
        div({className:'flex w-100'},[
            div({className: ''}, boxImage('mw3', box.image, box.name)),
            div({className: 'w-100 flex flex-column flex-row-ns justify-center justify-between-ns items-center-ns ph2'}, [
                boxName(box.name),
                boxPrice(box.price),
            ]),
        ]),
        div({className: 'mt2 mt0-ns'}, counter(box.id, box.quantity, dispatch)),
    ]); 
}

function cartActions(model){
    return div({className: 'bt mt4 pa2 b--moon-gray flex flex-column items-center'},[
        cartTotal(model),
        button({
            className: 'bn mw4  pointer pa0 w-100'
        }, a({
            className: 'ba b--black bg-white db link pv2 ph4 hover-bg-black hover-white', 
            href: '/checkout/index',
            
        },'ОФОРМИТЬ')),
    ]);
    
}

function cartTotal(model){
    return p({className: ''},`Общая сумма: ${model.cartTotal} грн.`);
}

function cart(dispatch, model){
    if(model.showCart && model.cart.length > 0){

        const cards = model.cart.map(element => {
            return card(dispatch, element)
        });
        return div({
            className: 'fixed top-0 bottom-0 right-0 left-0 flex justify-center items-center z-999 bg-black-70 pa2',
            onclick: (e) => {if(e.target !== e.currentTarget) return; dispatch(closeCartClickMsg()) }
        }, [
            div({
                className: 'overflow-y-auto relative w7 pa3 bg-light-gray z-max',
                style:'max-height: 455px',
            },[
                div({
                    className: 'absolute right-0 top-0 pointer dim',
                    onclick: (e) =>{e.stopPropagation(); dispatch(closeCartClickMsg())},
                }, i({className: 'pa2 fas fa-times f4 f5-l'})),
                div({className: 'pa3 maxh5 overflow-y-auto'}, cards),
                cartActions(model),
            ]),
        ]);
    }
    return null;
}



function boxImage(className, path, alt){
    return div({className},[
        img({src: path, className: '', alt: alt}),
    ]);
}

function boxName(name){
    return h3({className: 'mv1 ph2 pr0-ns'}, name)
}

function boxPrice(price){
    return p({className: 'red fw7 mv1 mh2'}, `${price} грн.`);
}

function boxButton(cart,id, dispatch){
    if(isInCart(cart, id)){
        return addedToCartBtn(dispatch, id);
    }else{
        return addToCartBtn(dispatch, id);
    }
}



function addToCartBtn(dispatch, id){
    return div({className: 'mw4 mv1'}, [
        button({
            className: 'ba b--black bg-white pointer pa0 w-100'
        }, a({
            className: 'db link pv2 ph4 hover-bg-black hover-white', 
            href: `/home/${id}/add`,
            onclick: (e) => { e.preventDefault(); addItem(dispatch, addToCartClickMsg, e.target.getAttribute('href'))},
        },'В КОРЗИНУ')),
        
    ]);
}

function addedToCartBtn(dispatch, id){
    return div({className: 'mw4 mv1'}, [
        button({
            className: 'ba b--black bg-white pointer pa0 w-100'
        }, a({
            className: 'db link pv2 ph4 hover-bg-black hover-white', 
            onclick: (e) => { e.stopPropagation();e.preventDefault(); dispatch(openCartClickMsg())},
            title: "Перейти в корзину"
        },i({className:'fas fa-shopping-cart' }),
            
            
        )),
        
    ]);
}

function counter(id, quantity, dispatch){
 
    return div({className: 'flex justify-between-ns bg-white mw4'},[
        a({
            className: 'ph3 pv2 pointer link ba hover-white hover-bg-black b--black',
            href: `/home/${id}/delete`,
            onclick: (e) => { e.preventDefault(); addItem(dispatch, addToCartClickMsg, e.target.getAttribute('href'))},
        }, '-'),
        div({className: 'pv2 ph3 bt bb flex items-center justify-center'}, quantity),
        a({
            className: 'ph3 pv2 pointer link ba hover-white hover-bg-black b--black',
            href: `/home/${id}/add`,
            onclick: (e) => { e.preventDefault(); addItem(dispatch, addToCartClickMsg, e.target.getAttribute('href'))},
        }, '+'),
    ]);
}

function whatsInsideLabel(dispatch, id){
    return a({
        className: 'blue pointer mv1 dim',
        href: `/home/${id}/showGifts`,
        onclick: (e) => {e.preventDefault(); addItem(dispatch, showInsideProductsClickMsg, e.target.getAttribute('href'))},
    }, 'Что внутри?')
}

function isInCart(cart,id){
    const item = cart.filter(element => {
        return element.id == id;
    });
    return item.length > 0;
}

function getQuantity(cart, id){
    const item = cart.filter(element => {
        return element.id == id;
    });
    return item[0].quantity;
}

function box(box, cart, dispatch){
    return div({className: 'w-100 w-50-m w-third-l pa2 '},[
        div({className:'pa3 flex flex-column items-center bg-white br4 '},[
            boxImage('mw4', box.path+box.image, box.name),
            boxName(box.name),
            boxPrice(box.price),
            boxButton(cart, box.id, dispatch),
            whatsInsideLabel(dispatch, box.id),
        ]),
        
    ]);
}

function boxes(model, dispatch){
    const boxes = model.boxes.map(element => {
        return box(element, model.cart, dispatch);
    });

    return div({className: 'flex flex-wrap'}, boxes);
}



function view(dispatch, model) {
    return div({ className: 'w-80 mw8 center' }, [
        cart(dispatch, model),
        whatsInside(dispatch, model),
        boxes(model, dispatch),
        //pre({className: 'center w-50 bg-inherit'}, JSON.stringify(model, null, 2)),
    ]);
}
const node = document.querySelector('#app');
const cartInHeader = document.querySelector("#cart");
const spinner = document.querySelector(".spinner");

function app(initModel, update, view, node) {
    let model = initModel;
    let currentView = view(dispatch, model);
    let rootNode = createElement(currentView);
    node.appendChild(rootNode);
    console.log(model);
        if(model.cart.length !== 0){
            const cartRootNode = div({
                className: 'relative flex items-center pointer',
                onclick: (e) => { e.stopPropagation();e.preventDefault(); dispatch(openCartClickMsg())},
            },[
                div({
                    className: 'flex justify-center items-center lh-solid absolute bg-red br-100',
                    style: 'width:20px; height:20px; top:7px; left:12px'
                },[
                    p({className:'mv0 f7 white '}, model.cart.length),
                ]),
                div({
                    className:'fas fa-shopping-cart mr2 fa-lg',
                }),
                div({className:''}, 'Корзина')
            ]);
            cartInHeader.innerHTML = '';
            cartInHeader.appendChild(createElement(cartRootNode));
        }else{
            cartInHeader.innerHTML = '';
        }
    
    function dispatch(msg) {
        model = update(msg, model);
        const updatedView = view(dispatch, model);
        const patches = diff(currentView, updatedView);
        rootNode = patch(rootNode, patches);
        currentView = updatedView;
        if(model.cart.length !== 0){
            const cartRootNode = div({
                className: 'relative flex items-center pointer',
                onclick: (e) => { e.stopPropagation();e.preventDefault(); dispatch(openCartClickMsg())},
            },[
                div({
                    className: 'flex justify-center items-center lh-solid absolute bg-red br-100',
                    style: 'width:20px; height:20px; top:7px; left:12px'
                },[
                    p({className:'mv0 f7 white '}, model.cart.length),
                ]),
                div({
                    className:'fas fa-shopping-cart mr2 fa-lg',
                }),
                div({className:''}, 'Корзина')
            ]);
            cartInHeader.innerHTML = '';
            cartInHeader.appendChild(createElement(cartRootNode));
        }else{
            cartInHeader.innerHTML = '';
        }
    }
}


getAllBoxes();







