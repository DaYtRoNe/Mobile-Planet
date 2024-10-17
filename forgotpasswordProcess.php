<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])){

    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `users` WHERE `email` = '".$email."'");
    $n = $rs->num_rows;

    if($n == 1){

        $code = uniqid();

        Database::iud("UPDATE `users` SET `verification_code`='".$code."' WHERE `email`='".$email."'");

        $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'eshangunsekara@gmail.com';
            $mail->Password = 'nwmpdratsoqxxjxm';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('eshangunsekara@gmail.com', 'Reset Password');
            $mail->addReplyTo('eshangunsekara@gmail.com', 'Reset Password');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Mobile Planet Forgot Password Verification Code';
            $bodyContent = '<h1 style="color:green;">Your verification code is </br> <span style="color:Black;">'.$code.'</span></h1>';
            $mail->Body = $bodyContent;

            if(!$mail->send()){
                echo ("Verification Code Sending Failed.");
            }else{
                echo ("Email sent to your Email Address");
            }

    }else{
        echo ("Invalid Email Address.");
    }

}else{
    echo ("Please Enter your Email address First.");
}

?>