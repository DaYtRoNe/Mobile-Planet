<?php

session_start();
require("connection.php");

$category = $_GET["c"];
$brand = $_GET["b"];

if ($category == 0) {
    echo ("Please select a main category");
} else if (empty($brand)) {
    echo ("Please input new brand name");
} else {

    $number;
    if ($category == 1) {
        $number = 2;
    } else if ($category == 2) {
        $number = 1;
    }

    $cat_rs = Database::search("SELECT * FROM `category` WHERE `cat_id` = '" . $category . "'");
    $cat_data = $cat_rs->fetch_assoc();

    $brand_rs = Database::search("SELECT * FROM `brand` WHERE `brand_name` = '" . $brand . "'");
    $brand_num = $brand_rs->num_rows;

    if ($brand_num == 1) {

        $brand_data = $brand_rs->fetch_assoc();

        $bhc_rs = Database::search("SELECT * FROM brand_has_category WHERE `brand_brand_id` = '" . $brand_data["brand_id"] . "'");
        $bhc_num = $bhc_rs->num_rows;
        $bhc_data = $bhc_rs->fetch_assoc();

        if ($bhc_num == 1) {
            if ($bhc_data["category_cat_id"] == $category) {
                echo ("This brand already connected to " . $cat_data["cat_name"] . " category");
            } else if ($bhc_data["category_cat_id"] == $number) {
                Database::iud("INSERT INTO `brand_has_category` (`brand_brand_id`, `category_cat_id`) VALUES ('" . $brand_data["brand_id"] . "', '" . $category . "')");
                echo ("success");
            }
        } else if ($bhc_num == 2) {
            echo ("This brand connected both phones and accessory categories already");
        }
    } else if ($brand_num == 0) {

        Database::iud("INSERT INTO `brand` (`brand_name`) VALUES ('" . $brand . "')");
        $brand_id = Database::$connection->insert_id;

        Database::iud("INSERT INTO `brand_has_category` (`brand_brand_id`, `category_cat_id`) VALUES ('" . $brand_id . "', '" . $category . "')");

        echo ("success");
    } else {
        echo ("somthing went wrong");
    };
};
