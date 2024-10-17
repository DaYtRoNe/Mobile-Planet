<?php
session_start();
require "connection.php";

if (isset($_SESSION["p"])) {
    $pid = $_SESSION["p"]["id"];

    $title = $_POST["t"];
    $clr = $_POST["c"];
    $qty = $_POST["q"];
    $cost = $_POST["p"];
    $dwc = $_POST["dwc"];
    $doc = $_POST["doc"];
    $desc = $_POST["d"];

    if (empty($title)) {
        echo "Title is empty";
    } else if ($clr == 0) {
        echo "Color is not selected";
    } else if ($qty <= 0) {
        echo "Quantity is not valid or empty";
    } else if ($cost <= 0) {
        echo "Cost is not valid or empty";
    }  else if ($dwc <= 0) {
        echo "Delivery within Colombo fee is not valid or empty";
    } else if ($doc <= 0) {
        echo "Delivery out of Colombo fee is not valid or empty";
    } else if (empty($desc)) {
        echo "Description is empty";
    } else {




        Database::iud("UPDATE `product` SET `title`='" . $title . "',`qty`='" . $qty . "',`delivery_fee_colombo`='" . $dwc . "', `price`='" . $cost . "', `dilivery_fee_other`='" . $doc . "',`description`='" . $desc . "' WHERE `id`='" . $pid . "'");

        $length = sizeof($_FILES);

        if ($length <= 4 && $length == 0) {

            // Database::iud("DELETE FROM `product_img` WHERE `product_id`='".$pid."'");

            $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $pid . "'");
            $img_num = $img_rs->num_rows;

            $img = array(); // array to store product_img IDs
            $img[0] = 0;
            $img[1] = 0;
            $img[2] = 0;
            $img[3] = 0;

            for ($i = 0; $i < 4; $i++) { // set product_img IDs to array
                $img_data = $img_rs->fetch_assoc();

                if (isset($img_data["img_id"])) { //check if there are no values
                    $img[$i] = $img_data["img_id"];
                }
            }


            for ($i = 0; $i < 4; $i++) {
                if (isset($_FILES["img" . $i])) {

                    $img_file = $_FILES["img" . $i];
                    $file_extention = $img_file["type"];

                    if (in_array($file_extention, $allowed_img_extentions)) {

                        $new_img_extention;

                        if ($file_extention == "image/jpg") {
                            $new_img_extention = ".jpg";
                        } else if ($file_extention == "image/jpeg") {
                            $new_img_extention = ".jpeg";
                        } else if ($file_extention == "image/png") {
                            $new_img_extention = ".png";
                        } else if ($file_extention == "image/svg+xml") {
                            $new_img_extention = ".svg";
                        }

                        if ($img[$i] != 0) {

                            Database::iud("DELETE FROM `product_img` WHERE `img_id`='" . $img[$i] . "'");
                        }

                        $file_name = "resources//products//" . $title . "_image" . $i . "_" . uniqid() . $new_img_extention;
                        move_uploaded_file($img_file["tmp_name"], $file_name);

                        Database::iud("INSERT INTO `product_img` (`img_path`,`product_id`) VALUES ('" . $file_name . "','" . $pid . "')");
                    } else {
                        echo ("Not an allowed image type.");
                    }
                }
            }

            echo ("success");
        } else {
            echo ("Image count not match");
        }
    }
} else {
    header("location:admin_login.php");
}
