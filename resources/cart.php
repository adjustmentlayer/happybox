<?php require_once("config.php"); ?>
<?php
if(isset($_GET['add'])) {
    if(isset($_SESSION['box_' . $_GET['add']])) {
    $_SESSION['box_' . $_GET['add']] += 1;
    }else{
        $_SESSION['box_' . $_GET['add']] = '1';
    }
}
if(isset($_GET['remove'])){

   
   if($_SESSION['box_' . $_GET['remove']] == '1'){
    $_SESSION['box_' . $_GET['remove']] = '1';
   }else{
    $_SESSION['box_' . $_GET['remove']]--;
   }
}
if(isset($_GET['delete'])){
   $_SESSION['box_' . $_GET['delete']] = null;
}
$myArray = array();
foreach($_SESSION as $name => $value){
        if($value > 0){
            if(substr($name,0,4)== "box_"){
                
                $length = strlen($name) - 4;
                $id = substr($name, 4, $length);
                $query = query("SELECT * FROM boxes WHERE box_id = " . escape_string($id)." ");
                confirm($query);

                while($row = fetch_array($query)){
                    $row["box_quantity"] = $_SESSION["box_" . escape_string($id).""];
                    $myArray[] = $row;
                } 
            }
        }
} 
$json = json_encode($myArray);
echo $json;
?>