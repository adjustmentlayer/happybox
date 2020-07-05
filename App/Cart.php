<?php

namespace App;

use \App\Models\Box;
use \App\Session;

class Cart    
{
    protected static $isItemInCart = false;

    public static function add($id){
        
        $index = 0;
        if(isset($id)){
            
            if(!Session::has('user_cart') || count(Session::get('user_cart')) < 1){
                
                Session::add('user_cart', [
                    0 => ['product_id' => $id, 'quantity' => 1]
                ]);
            }else{
                foreach($_SESSION['user_cart'] as $cart_item){
                    $index++;
                    foreach($cart_item as $key => $value){
                        if($key == 'product_id' && $value == $id){
                            array_splice($_SESSION['user_cart'], $index-1, 1, [
                                ['product_id' => $id, 'quantity' => $cart_item['quantity'] + 1]
                            ]);
                            self::$isItemInCart = true;
                        }
                    }
                }
                if(!self::$isItemInCart){
                    array_push($_SESSION['user_cart'],[
                        'product_id' => $id, 'quantity' => 1
                    ]);
                }
            }
        }
    }
    public static function update($id,$operator = "+"){
        $index = 0;
        $quantity = '';
        foreach($_SESSION['user_cart'] as $cart_items){
            $index++;
            foreach($cart_items as $key => $value){
                if($key == 'product_id' && $value == $id){
                    switch($operator){
                        case "+":
                            $quantity = $cart_items['quantity'] + 1;
                        break;
                        case "-":
                            $quantity = $cart_items['quantity'] - 1;
                            if($quantity < 1){
                                $quantity = 1;
                            }
                        break;
                    }
                    array_splice($_SESSION['user_cart'],$index -1 , 1, [
                        [ 
                            'product_id' => $id,
                            'quantity' => $quantity
                        ]
                    ]);
                }
                
            }
        }
    }
    public static function remove($index)
    {
        
        if(count($_SESSION['user_cart'])<=1){
            self::clear();
        }else{
            unset($_SESSION['user_cart'][$index]);
            sort($_SESSION['user_cart']);
        }
    }
    public static function clear(){
        Session::remove('user_cart');
    }
    public static function getItems()
    {
        $result = array();
        $cartTotal = 0;
        if(!Session::has('user_cart') || count(Session::get('user_cart')) < 1){
            return ['fail' => "Ваша корзина пуста", 'items'=> [], 'cartTotal' => null];
            exit;
        }

        $index = 0;

        foreach($_SESSION['user_cart'] as $cart_item){
            $productId = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            $product = new Box();
            $item = $product->getOne($productId);

            if(!isset($item)){ continue; }

            $totalPrice = $item->price * $quantity;
            $cartTotal = $totalPrice + $cartTotal;
            $totalPrice = number_format($totalPrice,2);

            array_push($result, [
                'id' => $item->id,
                'name' => $item->name,
                'image' => $item->path.$item->image,
                'price' => $item->price,
                'total' => $totalPrice,
                'quantity' => $quantity,
                'index' => $index,

            ]);
            $index++;
        }
        $cartTotal = number_format($cartTotal,2);
        return ['items'=> $result, 'cartTotal' => $cartTotal];
        
        
    }
}