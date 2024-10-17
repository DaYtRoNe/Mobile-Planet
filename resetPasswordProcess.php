<?php

require "connection.php";

$email = $_POST["e"];
$newpw = $_POST["np"];
$retpw = $_POST["rnp"];
$vcode = $_POST["vc"];

if(empty($email)){
    echo ("Please enter your email address.");
}else if(empty($newpw)){
    echo ("Please enter your New Password.");
}else if(strlen($newpw)<5 || strlen($newpw)>20){
    echo ("Invalid New Password.");
}else if(empty($retpw)){
    echo ("Please Re Enter your New Password.");
}else if($newpw != $retpw){
    echo ("Password does not matched.");
}else if(empty($vcode)){
    echo ("Please enter your verification code.");
}else{

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."' AND 
    `verification_code`='".$vcode."'");
    
    $n = $rs->num_rows;

    if($n == 1){

        Database::iud("UPDATE `users` SET `password`='".$newpw."' WHERE `email`='".$email."' AND 
        `verification_code`='".$vcode."'");

        echo ("success");

    }else{
        echo ("Invalid user details.");
    }

}

?>