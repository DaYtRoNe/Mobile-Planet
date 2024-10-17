<?php 

session_start();

$qty = $_POST["qty"];
$price = $_POST["price"];

$total = $qty * $price;

echo($total);

?>