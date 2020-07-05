<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Box;
use \App\Session;
use \App\Cart;

    
  
/**
 * Delivary controller
 *
 * PHP version 7.0
 */
class Delivary extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        
        View::renderTemplate('Delivary/index.html',cart::getitems());
        
    }
    
    

    
    
}
