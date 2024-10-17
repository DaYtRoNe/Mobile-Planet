<?php
session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

if (isset($_GET["id"])) {
    $pid = $_GET["id"];

    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `users_email` = '".$email."' AND `product_id` = '".$pid."'");
    $watchlist_num = $watchlist_rs->num_rows;

    if($watchlist_num != 0){

    Database::iud("DELETE FROM `watchlist` WHERE `users_email` = '".$email."' AND `product_id` = '".$pid."'");
    echo "success";

    } else {
        echo "Something went wrong";
    }

}

?>