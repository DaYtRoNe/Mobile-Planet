<?php

require("connection.php");
session_start();
$user = $_SESSION["u"];

if (isset($_POST["payment"])) {

    $payment = json_decode($_POST["payment"], true);

    $date = new DateTime();
    $date->setTimezone(new DateTimeZone("Asia/Colombo"));
    $time = $date->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `order_history` (`order_id`, `order_date`, `amount`, `users_email`, `order_status_os_id`) 
    VALUES ('" . $payment["order_id"] . "','" . $time . "','" . $payment["amount"] . "','" . $user["email"] . "', '1')");

    $orderHistoryId = Database::$connection->insert_id;

    $crs = Database::search("SELECT * FROM `cart` WHERE `users_email` = '" . $user["email"] . "'");
    $cnum = $crs->num_rows;

    for ($i = 0; $i < $cnum; $i++) {
        $cdata = $crs->fetch_assoc();

        Database::iud("INSERT INTO `order_item` (`oi_qty`, `order_history_ohid`, `product_id`) 
        VALUES ('" . $cdata["qty"] . "', '" . $orderHistoryId . "', '" . $cdata["product_id"] . "')");

        $prs = Database::search("SELECT * FROM `product` WHERE `product`.`id` = '" . $cdata["product_id"] . "'");
        $pdata = $prs->fetch_assoc();

        $newQty = $pdata["qty"] - $cdata["qty"];
        Database::iud("UPDATE `product` SET `qty` = '" . $newQty . "' WHERE `id` = '" . $cdata["product_id"] . "'");
    }

    Database::iud("DELETE FROM `cart` WHERE `users_email` = '".$user["email"]."'");
    // echo("success");

    $order = array();
    $order["resp"] = "success";
    $order["order_id"] = $orderHistoryId;

    echo json_encode($order);

}
