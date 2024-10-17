<?php

require "connection.php";

$status = $_GET["s"];
$ohid = $_GET["id"];

$ohrs = Database::search("SELECT * FROM `order_history` WHERE `ohid` = '" . $ohid . "'");

if ($ohrs->num_rows == 1) {

    $ohdata = $ohrs->fetch_assoc();

    if ($status > 0 && $status <= 4) {
        Database::iud("UPDATE `order_history` SET `order_status_os_id`='" . $status . "' WHERE `ohid`='" . $ohid . "'");
        echo ("success");
    } else {
        echo ("Something went wrong. Try again later.");
    }
} else {
    echo ("Something went wrong. Try again later.");
}
