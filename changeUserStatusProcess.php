<?php

require "connection.php";

$email = $_GET["e"];

$user_rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."'");

if($user_rs->num_rows == 1){

    $user_data = $user_rs->fetch_assoc();
    $status = $user_data["status"];

    if($status == 1){
        Database::iud("UPDATE `users` SET `status`='2' WHERE `email`='".$email."'");
        echo ("inactive");
    }else if($status == 2){
        Database::iud("UPDATE `users` SET `status`='1' WHERE `email`='".$email."'");
        echo ("active");
    }

}else{
    echo ("Something went wrong. Try again later.");
}

?>