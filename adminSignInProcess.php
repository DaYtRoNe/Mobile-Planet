<?php

session_start();
require "connection.php";

$email = $_POST["e"];         //f.append("e", email.value);
$password = $_POST["p"];     // f.append("p", password.value);

if (empty($email)) {
    echo ("Please enter your Email Address.");
} else if (strlen($email) > 100) {
    echo ("Incorrect Email Address.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address.");
} else if (empty($password)) {
    echo ("Please enter your Password.");
} else if (strlen($password) < 5 || strlen($password) > 20) {
    echo ("Incorrect password.");
} else {

    $rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $email . "' AND `password` = '" . $password . "'");
    $n = $rs->num_rows;

    if ($n == 1) {

        $d = $rs->fetch_assoc();

        if ($d["user_type_id"] == 1) {
            echo ("success");
            $_SESSION["a"] = $d;

        } else {
            echo ("Your are not a Admin");
        }
    } else {
        echo ("Invalid Email Address or Password");
    }
}
