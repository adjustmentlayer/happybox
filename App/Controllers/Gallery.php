<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Photo;
use \App\Session;
use \App\Cart;

    
  
/**
 * Gallery controller
 *
 * PHP version 7.0
 */
class Gallery extends \Core\Controller
{
    
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        $photos = Photo::getAll();

        /* echo "<pre>";
        var_dump($photos);
        echo '</pre>'; */

        View::renderTemplate('Gallery/index.html', [
            'photos' => $photos,
        ]);
        
    }
    
    

    
    
}
