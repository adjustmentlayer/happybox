<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Box;
use \App\Session;
use \App\Cart;



/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        Session::add('admin', 'You are welcome, admin user');
        Session::remove('admin');

        if(Session::has('admin')){
            $msg = Session::get('admin');
        }else{
            $msg = 'Not defined';
        }

        View::renderTemplate('Home/index.html');
        

        
    }

    public function showBoxesAction(){
        $boxes = Box::getAll();
        $cart = Cart::getItems();

        $response = ['boxes' => $boxes, 'cart' => $cart];

        echo json_encode($response);
    }

    public function addAction(){
        $id = $this->route_params['id'];
        if(isset($id)){
            Cart::add($id);
            $cart = Cart::getItems();

            $response = ['response' => array('cart' => $cart) ];

            echo json_encode($response);
        }
    }

    public function deleteAction(){
        $id = $this->route_params['id'];
        if(isset($id)){
            Cart::update($id, "-");

            $cart = Cart::getItems();
            $response = ['response' => array('cart' => $cart) ];

            echo json_encode($response);
        }
        
    }

    public function removeAction(){
        $index = $this->route_params['id'];
        if(isset($index)){
            Cart::remove($index);

            $cart = Cart::getItems();
            $response = ['response' => array('cart' => $cart) ];

            echo json_encode($response);
        }
    }

    public function showGiftsAction(){
        $id = $this->route_params['id'];
            
        if(isset($id)){
            
            $products = Box::getProducts($id);
            $response = ['response' => array('products' => $products)];
            
            echo json_encode($response);
        }
        
    }
    
}
