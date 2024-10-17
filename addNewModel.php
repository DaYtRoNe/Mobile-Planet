<?php

session_start();
require("connection.php");

$category = $_GET["c"];
$brand = $_GET["b"];
$Mname = $_GET["m"];

if ($category == 0) {
        echo ("Please select a main category");
} else if($brand == 0){
    echo ("Please select a brand");
} else if (empty($Mname)) {
    echo ("Please input new sub category name");
} else {

    $text = str_replace(' ', '%', $Mname);

    $model_rs = Database::search("SELECT * FROM `model` WHERE `model_name` LIKE '%".$text."%'");
    $model_num = $model_rs->num_rows;

    if ($model_num >= 1) {
        echo ("already");
    } else if ($model_num == 0) {

        Database::iud("INSERT INTO `model` (`model_name`, `brand_brand_id`, `category_cat_id`) VALUES ('".$Mname."', '".$brand."', '".$category."')");

        echo ("success");
    } else {
        echo ("somthing went wrong");
    };
};
