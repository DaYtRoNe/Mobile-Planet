<?php

session_start();
require "connection.php";

$email = $_SESSION["a"]["email"];

$subcat = $_POST["subcat"];
$brand = $_POST["b"];
$model = $_POST["m"];
$title = $_POST["t"];
$condition = $_POST["con"];
$clr = $_POST["col"];
$qty = $_POST["qty"];
$cost = $_POST["cost"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["desc"];


if(empty($subcat)){
    echo("sub category is not selected");
} else if(empty($brand)){
    echo("brand is not selected");
} else if(empty($model)){
    echo("model is not selected");
} else if(empty($title)){
    echo("title field is empty");
} else if(empty($condition)){
    echo("condition is not selected");
} else if(empty($clr)){
    echo("Color is not selected");
} else if(empty($qty) && $qty <= 0){
    echo("Quantity is not valid or empty");
} else if(empty($cost) && $cost <= 0){
    echo("Cost is not valid or empty");
} else if(empty($dwc) && $dwc <= 0){
    echo("Delivery fee within colombo is not valid or empty");
} else if(empty($doc) && $doc <= 0){
    echo("Delivery fee out of colombo is not valid or empty");
} else if(empty($desc)){
    echo("Description field is empty");
} else {
    
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");
    
    $status = 1;
    
    Database::iud("INSERT INTO `product` (`price`, `qty`, `title`, `description`, `datetime_added`, `delivery_fee_colombo`, `dilivery_fee_other`, `color_clr_id`, `status_status_id`, `condition_condition_id`, `users_email`, `sub_category_subcat_id`, `model_model_id`) 
    VALUES ('".$cost."', '".$qty."', '".$title."', '".$desc."', '".$date."', '".$dwc."', '".$doc."', '".$clr."', '".$status."', '".$condition."', '".$email."', '".$subcat."', '".$model."')");
    
    $product_id = Database::$connection->insert_id;
    
    $length = sizeof($_FILES);
    
    if($length <= 4 && $length > 0){
    
        $allowed_img_extentions = array("image/jpg","image/jpeg","image/png","image/svg+xml");
    
        for($i = 0; $i < $length; $i++){
            if(isset($_FILES["img".$i])){
    
                $img_file = $_FILES["img".$i];
                $file_extention = $img_file["type"];
    
                if(in_array($file_extention,$allowed_img_extentions)){
    
                    $new_img_extention;
    
                    if($file_extention == "image/jpg"){
                        $new_img_extention = ".jpg";
                    }else if($file_extention == "image/jpeg"){
                        $new_img_extention = ".jpeg";
                    }else if($file_extention == "image/png"){
                        $new_img_extention = ".png";
                    }else if($file_extention == "image/svg+xml"){
                        $new_img_extention = ".svg";
                    }
    
                    $file_name = "resources//products//".$title."_image".$i."_".uniqid().$new_img_extention;
                    move_uploaded_file($img_file["tmp_name"],$file_name);
    
                    Database::iud("INSERT INTO `product_img` (`img_path`,`product_id`) VALUES ('".$file_name."','".$product_id."')");
    
                }else{
                    echo ("Not an allowed image type.");
                }
    
            }
        }
    
        echo ("success");
    
    }else{
        echo ("Invalid Image Count");
    }

}



?>