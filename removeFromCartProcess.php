<?php

session_start();

require "connection.php";

if(isset($_SESSION["u"])){
    $email = $_SESSION["u"]["email"];
    $pid = $_GET["id"];

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `users_email` = '" . $email . "' AND `product_id` = '" . $pid . "'");
    $cart_num = $cart_rs->num_rows;

    if($cart_num != 0){

        Database::iud("DELETE FROM `cart` WHERE `users_email` = '" . $email . "' AND `product_id` = '" . $pid . "'");

        echo("success");

    } else {
        echo ("Something Went Wrong!");
    }

} else {
    echo ("Something Went Wrong!");
}

?>