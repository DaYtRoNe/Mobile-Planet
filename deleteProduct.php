<?php
session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

if (isset($_GET["id"])) {
    $pid = $_GET["id"];

    Database::iud("DELETE FROM `product_img` WHERE `product_id` = '".$pid."'");

    Database::iud("DELETE FROM `product` WHERE `id` = '".$pid."' AND `users_email` = '".$email."'");

    echo "success";

} else {
    echo "Error: Product ID not provided.";
}
?>
