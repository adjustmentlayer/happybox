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
class Rights extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function agreementAction()
    {

        
        View::renderTemplate('Rights/agreement.html',cart::getitems());
        
    }

    public function dogovorAction()
    {

        
        View::renderTemplate('Rights/dogovor.html',cart::getitems());
        
    }
    

    
    
}