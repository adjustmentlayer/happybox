<?php require_once("../resources/config.php");
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

validate_fields($arr_form_data);


if(!empty($errors['fields'])) {
    if(is_ajax_request()){
        $result_array = array('errors' => $errors);
        echo json_encode($result_array);
    }else{
        echo "<p>Неверно заполнены поля</p>";
        echo "<p><a href='checkout.php'>Назад</a></p>";
    }
    exit;
}
$telegram['message']="\xF0\x9F\x93\x83 <b>Новая заявка</b> %0A %0A";
foreach($arr_form_data as $key => $value){
    $telegram['message'] .= $value['emoji']." <b>".$value['descriptionRu']."</b>: ".$value['value'].".%0A";
}
$sendToTelegram = fopen("https://api.telegram.org/bot{$telegram['token']}/sendMessage?chat_id={$telegram['chat_id']}
&parse_mode=html&text={$telegram['message']}","r");
if($sendToTelegram){

}
if(is_ajax_request()){
    //do something

    $response = array(
        "success" => true
    );
    echo json_encode($response);
}else{
    echo "<p>Спасибо! Ваш заказ обрабатывается!</p>";
}


?>