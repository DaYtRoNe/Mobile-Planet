<?php

require("connection.php");

session_start();

$user = $_SESSION["u"];

$productList = array();
$qtyList = array();



$city_rs = Database::search("SELECT * FROM `users_has_address` WHERE `users_email` = '" . $user["email"] . "'");
$city_num = $city_rs->num_rows;

if ($city_num == 1) {
    $city_data = $city_rs->fetch_assoc();

    $city_id = $city_data["city_city_id"];
    $address = $city_data["line1"] . "," . $city_data["line2"];

    $district_rs = Database::search("SELECT * FROM `city` WHERE `city_id` = '" . $city_id . "'");
    $district_data = $district_rs->fetch_assoc();

    $district_id = $district_data["district_district_id"];
    $delivery = 0;


    if (isset($_POST["cart"]) && $_POST["cart"] == "true") {
        // echo("From cart");
        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `users_email` = '" . $user["email"] . "'");
        $cart_num = $cart_rs->num_rows;

        for ($i = 0; $i < $cart_num; $i++) {
            $cart_data = $cart_rs->fetch_assoc();

            $productList[] = $cart_data["product_id"];
            $qtyList[] = $cart_data["qty"];
        }
    } else {
        // echo ("From buy now");

        $productList[] = $_POST["pid"];
        $qtyList[] = $_POST["qty"];
    }

    $fname = $user["fname"];
    $lname = $user["lname"];
    $mobile = $user["mobile"];
    $u_address = $address;
    $city = $district_data["city_name"];

    $merchant_id = "1226674";
    $merchant_secret = "MTA1NDk1MzM3NTc5NjI4NTc3ODEzNDg0Nzc4MTEyMzkxMjcxMTYw";
    $items = "";
    $amount = 0;
    $currency = "LKR";
    $order_id = uniqid();
    $hash;

    for ($i = 0; $i < sizeof($productList); $i++) {
        $prs = Database::search("SELECT * FROM `product` WHERE `product`.`id` = '" . $productList[$i] . "'");
        $pdata = $prs->fetch_assoc();

        $stock = $pdata["qty"];

        if ($stock >= $qtyList[$i]) {
            //stock available
            $items .= $pdata["title"];

            if ($i != sizeof($productList) - 1) {
                $items .= ", ";
            }

            $amount += (intval($pdata["price"]) * intval($qtyList[$i]));

            if ($district_id == 15) {
                $delivery = $pdata["delivery_fee_colombo"] * $qtyList[$i];
            } else {
                $delivery = $pdata["dilivery_fee_other"] * $qtyList[$i];
            }

            $amount += (intval($delivery));
        } else {
            echo ("unavailable item quantity.");
        }
    }

    $hash = strtoupper(
        md5(
            $merchant_id .
                $order_id .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
        )
    );

    $payment = array();
    $payment["sandbox"] = true;
    $payment["merchant_id"] = $merchant_id;
    $payment["first_name"] = $fname;
    $payment["last_name"] = $lname;
    $payment["email"] = $user["email"];
    $payment["phone"] = $mobile;
    $payment["address"] = $address;
    $payment["city"] = $city;
    $payment["country"] = "Sri Lanka";
    $payment["order_id"] = $order_id;
    $payment["items"] = $items;
    $payment["currency"] = $currency;
    $payment["amount"] = number_format($amount, 2, '.', '');
    $payment["hash"] = $hash;
    $payment["return_url"] = "";
    $payment["cancel_url"] = "";
    $payment["notify_url"] = "";

    echo json_encode($payment);
    // echo($amount);
} else {
    echo ("address error");
}
