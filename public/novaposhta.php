<?php require_once("../resources/config.php"); ?>
<?php 
header('Content-Type: application/json; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
if(is_ajax_request()){
    $settings = $_POST['settings']; 

    $n_pages = json_decode($settings,true)['methodProperties']['Page'];//Кол-во страниц с населенными пунктами области. Страница содержит 150 записей

    function make_request($settings,$n_pages){
        global $novaposhta;
        $arr_result=[];
        
        for($i=1;$i<$n_pages+1;$i++){
            $settings = json_decode($settings,true);
            $settings['apiKey'] =$novaposhta['token'];
            $settings['methodProperties']['Page'] = $i."";
            $settings = json_encode($settings);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => True,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $settings,
            CURLOPT_HTTPHEADER => array("content-type: application/json",),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                $arr_result['error'] = "Помилка! Спробуйте ще раз"; 
            } else {
                foreach (json_decode($response,true)['data'] as $key => $value) {
                    $arr_result[] = $value;
                } 
            }
        }
        echo json_encode($arr_result,JSON_UNESCAPED_UNICODE,JSON_FORCE_OBJECT);
    }

        
    make_request($settings,$n_pages);

}else{
    redirect("index.php");
}


?>