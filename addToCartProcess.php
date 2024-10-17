<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];

    if (isset($_POST["id"])) {
        $pid = $_POST["id"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `users_email` = '" . $email . "' AND `product_id` = '" . $pid . "'");
        $cart_num = $cart_rs->num_rows;

        if (isset($_POST["qty"])) {
            $qty = $_POST["qty"];

            if ($cart_num == 1) {
                $cart_data = $cart_rs->fetch_assoc();
                $cart_id = $cart_data["cart_id"];

                Database::iud("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `users_email` = '" . $email . "' AND `cart_id` = '" . $cart_id . "'");
            } else {

                Database::iud("INSERT INTO `cart` (`product_id`,`users_email`,`qty`) VALUES ('" . $pid . "','" . $email . "','" . $qty . "')");
                echo ("Added");
            }
        } else {

            if ($cart_num != 1) {
                Database::iud("INSERT INTO `cart` (`product_id`,`users_email`,`qty`) VALUES ('" . $pid . "','" . $email . "','1')");
                echo ("Added");
            }
        }
    } else {
        echo ("Somthing Went Wrong!");
    }
} else {
    echo ("Something Went Wrong!");
}
