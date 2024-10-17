<?php

session_start();

require "connection.php";

$email = $_SESSION["u"]["email"];

$pid = $_POST["id"];
$qty = $_POST["qty"];


$query = Database::iud("UPDATE cart SET qty = '".$qty."' WHERE `product_id` = '".$pid."' AND `users_email` = '".$email."';");

?>
