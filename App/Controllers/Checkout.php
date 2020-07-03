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
class Checkout extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Checkout/index.html');
        
    }

    
    
}
