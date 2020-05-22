<?php
$telegram = array(
    "token" => "",
    "chat_id" => "",
    "message" => ""
);
$novaposhta = array(
    "token" => ""
);
$reCAPTCHA = array(
    "token" => ""
);
function verifyREcaptcha($url){
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, $url);
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    return $response;
}

//helper functions

function redirect($location){

    header("Location: $location");

}

function query($sql) {
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;

    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;

    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}

function get_products(){
    
$query = query("SELECT * FROM products");
    confirm($query);
    
    while($row = fetch_array($query)){
        $product =
        "<div class='products-list__product d-flex'>
            <div class='products-list__product-img'><img src='{$row['product_img']}' alt='{$row['product_name']}'></div>
            <p class='products-list__product-label'>{$row['product_name']}</p>
        </div>";

        echo $product;
    }
}  
function get_photos(){
    
    $query = query("SELECT * FROM photos");
        confirm($query);
        
        while($row = fetch_array($query)){
            $photo =
            "<div class='thumb/gallery__item item' data-src='img/medium/{$row['photo_id']}.jpg'>
                <img src='img/thumb/{$row['photo_id']}.jpg' />
            </div>";
    
            echo $photo;
        }
    }  
function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

$errors = array();
function validate_fields($arr_fields){
    global $errors;
    $errors["fields"] = array();
    foreach($arr_fields as $field_key => $field_value){
        if($field_value['required']){
            if($field_value['value'] == ''){
                $errors['fields'][$field_key]['requiredError'] = true;
                $errors['fields'][$field_key]['descriptionRu'] = $field_value['descriptionRu'];
            }
        }
        
        if(isset($field_value['maxLength'])){
            if(strlen($field_value['value']) >= $field_value['maxLength']){
                $errors['fields'][$field_key]['maxLengthError'] = true;
                $errors['fields'][$field_key]['descriptionRu'] = $field_value['descriptionRu'];
            }
        }
        
        if(isset($field_value['match_pattern'])){
            if(!preg_match($field_value['match_pattern'],$field_value['value'])){
                $errors['fields'][$field_key]['patternError'] = true;
                $errors['fields'][$field_key]['descriptionRu'] = $field_value['descriptionRu'];
            }
        }
        
    }
}

function get_box_by_id($id){
    $query = query("SELECT * FROM boxes WHERE box_id=".$id);
    confirm($query);
    
    while($row = fetch_array($query)){
        return $row;
    }
}



?>