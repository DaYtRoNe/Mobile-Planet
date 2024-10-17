<?php

session_start();
require("connection.php");

$category = $_GET["c"];
$subCName = $_GET["s"];

if ($category == 0) {
        echo ("Please select a main category");
} else if (empty($subCName)) {
    echo ("Please input new sub category name");
} else {

    $subC_rs = Database::search("SELECT * FROM sub_category WHERE `subcat_name` = '" . $subCName . "' OR `subcat_name` LIKE '" . $subCName . "_' OR `subcat_name` LIKE '" . $subCName . "__'");
    $subC_num = $subC_rs->num_rows;

    if ($subC_num == 1) {
        echo ("already");
    } else if ($subC_num == 0) {

        Database::iud("INSERT INTO `sub_category` (`subcat_name`, `category_cat_id`) VALUES ('" . $subCName . "', '" . $category . "')");

        echo ("success");
    } else {
        echo ("somthing went wrong");
    };
};
