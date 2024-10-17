<?php
session_start();
require "connection.php";

$email = $_POST["e"];         //f.append("e", email.value);
$password = $_POST["p"];     // f.append("p", password.value);
$rememberme = filter_var($_POST["r"], FILTER_VALIDATE_BOOLEAN);  // Convert to boolean

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

        if ($d["status"] == 1) {
            $_SESSION["u"] = $d;
            echo ("success");

            if ($rememberme) {
                setcookie("email", $email, time() + (60 * 60 * 24 * 365), "/");
                setcookie("password", $password, time() + (60 * 60 * 24 * 365), "/");
            } else {
                setcookie("email", "", time() - 3600, "/");
                setcookie("password", "", time() - 3600, "/");
            }
        } else {
            echo ("Your Account has been Disabled. Please Contact Admin through the <a href='help.php'>Help & Contact</a> Page");
        }
    } else {
        echo ("Invalid Email Address or Password");
    }
}
?>
