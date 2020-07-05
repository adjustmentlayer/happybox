<?php

namespace App\Controllers;

use \Core\View;
use \App\Telegram;
use \App\Session;
use \App\Cart;
use \App\Config;

    
  
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Checkout extends \Core\Controller
{

    private $errors = [];

    private $reCAPTCHA = array(
        "token" => ""
    );


    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        
        $cartItems = cart::getItems();
        $formatedArray = [];

        foreach($cartItems['items'] as $key => $value){
            $formatedArray['product_' . $key] = [
                "value" => $value['name'] . ' x' . $value['quantity'],
                "required" => false,
                "descriptionRu" => "Заказано",
                "emoji"=>"\xF0\x9F\x8E\x81",
            ];
        }

        echo "<pre>";
        var_dump($formatedArray);
        echo "</pre>";


        View::renderTemplate('Checkout/index.html',cart::getitems());
        
    }

    public function thankYouAction()
    {

        View::renderTemplate('Checkout/thank-you.html');
        
    }

    public function proccessAction() {

        $arr_form_data = array(
            "first_name" => array(
                "value" => isset($_POST['first_name']) ? htmlentities($_POST['first_name']) : '',
                "required" => true,
                "maxLength" => 25,
                "descriptionRu" => "Имя",
                "emoji"=>"\xE2\x9C\x8F"
            ),
            "last_name" => array(
                "value" => isset($_POST['last_name']) ? htmlentities($_POST['last_name']) : '',
                "maxLength" => 30,
                "required" => true,
                "descriptionRu" => "Фамилия",
                "emoji"=>"\xE2\x9C\x92"
            ),
            "phone" => array(
                "value" => isset($_POST['phone']) ? htmlentities($_POST['phone']) : '',
                "required" => false,
                "descriptionRu" => "Телефон",
                "match_pattern" =>'/^\+38\(0\d{2}\)\-\d{3}\-\d{2}\d{2}$/',
                "emoji"=>"\xF0\x9F\x93\xB1"
            ),
            "email" => array(
                "value" => isset($_POST['email']) ? htmlentities($_POST['email']) : '',
                "maxLength" => 30,
                "required" => false,
                "descriptionRu" => "Email",
                "emoji"=>"\xF0\x9F\x93\xA7"
            ),
            "instagram" => array(
                "value" => isset($_POST['instagram']) ? htmlentities($_POST['instagram']) : '',
                "maxLength" => 30,
                "required" => true,
                "descriptionRu" => "Ник в Instagram",
                "emoji"=>"\xF0\x9F\x93\xB7"
            ),
            "area" => array(
                "value" => isset($_POST['area']) ? htmlentities($_POST['area']) : '',
                "required" => true,
                "descriptionRu" => "Область",
                "emoji"=>"\xF0\x9F\x93\xA6"
            ),
            "settlement" => array(
                "value" => isset($_POST['settlement']) ? htmlentities($_POST['settlement']) : '',
                "required" => true,
                "descriptionRu" => "Населенный пункт",
                "emoji"=>"\xF0\x9F\x93\xA6"
            ),
            "warehouse" => array(
                "value" => isset($_POST['warehouse']) ? htmlentities($_POST['warehouse']) : '',
                "required" => true,
                "descriptionRu" => "Отделение Новой Почты",
                "emoji"=>"\xF0\x9F\x93\xA6"
            ),
            "quantity" => array(
                "value" => isset($_SESSION['box_1']) ? $_SESSION['box_1']: "0",
                "required" => false,
                "descriptionRu" => "Кол-во коробок",
                "emoji" => "\xF0\x9F\x8E\x81"
            ),
            "total" => array(
                "value" => isset($_SESSION['box_1']) ? $_SESSION['box_1'] * get_box_by_id(1)['box_price']. " грн.": "0 грн.",
                "required" => false,
                "descriptionRu" => "Итого",
                "emoji" => "\xF0\x9F\x92\xB5"
            )
        );
        
        $this->validate_fields($arr_form_data);
        
        
        if(!empty($this->errors['fields'])) {
            
            $result_array = array('errors' => $this->errors);
            echo json_encode($result_array);
            exit;
        }

        $telegram = new Telegram(Config::BOT_TOKEN, Config::CHAT_ID);

        // Отправляем заголовок и письмо на телеграм чат
        $telegram->send("Новый заказ", $arr_form_data);
        

        $response = [
            "success" => true
        ];
        echo json_encode($response);
       
    }

    private function validate_fields($arr_fields){
        
        $this->errors["fields"] = array();
        foreach($arr_fields as $field_key => $field_value){
            if($field_value['required']){
                if($field_value['value'] == ''){
                    $this->errors['fields'][$field_key]['requiredError'] = true;
                    $this->errors['fields'][$field_key]['descriptionRu'] = $field_value['descriptionRu'];
                }
            }
            
            if(isset($field_value['maxLength'])){
                if(strlen($field_value['value']) >= $field_value['maxLength']){
                    $this->errors['fields'][$field_key]['maxLengthError'] = true;
                    $this->errors['fields'][$field_key]['descriptionRu'] = $field_value['descriptionRu'];
                }
            }
            
            if(isset($field_value['match_pattern'])){
                if(!preg_match($field_value['match_pattern'],$field_value['value'])){
                    $this->errors['fields'][$field_key]['patternError'] = true;
                    $this->errors['fields'][$field_key]['descriptionRu'] = $field_value['descriptionRu'];
                }
            }
            
        }
    }

    private function verifyREcaptcha($url){
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, $url);
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        return $response;
    }

    
    
    

    
    
}
