<?php

session_start();

if (isset($_SESSION["u"])) {

    $user = $_SESSION["u"]["email"];

    require "connection.php";

?>

    <!DOCTYPE html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Cart</title>

        <link rel="stylesheet" href="mdb.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
        <script rel="stylesheet" src="style.css"></script>

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body class="bg-body-secondary">

        <div class="container-fluid">

            <?php

            require "header.php";

            $item = 0;
            $delivery = 0;
            $delivery_total = 0;
            $total = 0;
            $final_total = 0;

            ?>

            <div class="bg-light mt-6 mb-5 bg-body-secondary">

                <div class="col-12 border-bottom border-danger">
                    <div class="row">
                        <div class="col-lg-1 mt-lg-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="container mt-2">
                    <div class="row">
                        <!-- cart -->
                        <div class="col-lg-9">
                            <div class="card border shadow-0">
                                <div class="m-4">
                                    <h4 class="card-title mb-4">Your Shopping Cart</h4>

                                    <?php

                                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `users_email`='" . $user . "'");
                                    $cart_num = $cart_rs->num_rows;

                                    if ($cart_num == 0) {

                                    ?>
                                       
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 emptyCart"></div>
                                                <div class="col-12 text-center mb-2">
                                                    <label class="form-label fs-1 fw-bold">
                                                        You have no items in your cart yet.
                                                    </label>
                                                </div>
                                                <div class="offset-lg-4 col-12 col-lg-4 mb-4 d-grid">
                                                    <a href="index.php" class="btn btn-dark btn-outline-info fs-3 fw-bold">
                                                        Start Shopping
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <?php

                                    } else {

                                        for ($x = 0; $x < $cart_num; $x++) {
                                            $cart_data = $cart_rs->fetch_assoc();

                                            $product_rs = Database::search("SELECT * FROM `product` INNER JOIN color ON product.color_clr_id = color.clr_id 
                                            WHERE `id`='" . $cart_data["product_id"] . "'");
                                            $product_data = $product_rs->fetch_assoc();

                                            $address_rs = Database::search("SELECT `district_id` AS did, city.city_name AS cname FROM `users_has_address` INNER JOIN `city` 
                                            ON users_has_address.city_city_id = city.city_id INNER JOIN `district` 
                                            ON city.district_district_id = district.district_id WHERE `users_email`='" . $user . "'");
                                            $address_data = $address_rs->fetch_assoc();

                                            if ($address_data["did"] == 5) {
                                                $delivery = $product_data["delivery_fee_colombo"];
                                            } else {
                                                $delivery = $product_data["dilivery_fee_other"];
                                            }

                                            $seller_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $product_data["users_email"] . "'");
                                            $seller_data = $seller_rs->fetch_assoc();
                                            $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                                            $sum = $cart_data["qty"] * $product_data["price"];

                                            $delivery_total = $delivery_total + ($cart_data["qty"] * $delivery);

                                            $total = $total + $sum;

                                            $final_total = ($total + $delivery_total);

                                            $item = $item + 1;

                                        ?>

                                            <!-- product img -->
                                            <div class="row mb-4">
                                                <div class="col-lg-5">
                                                    <div class="me-lg-5">
                                                        <div class="d-flex">

                                                            <?php

                                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["id"] . "'");
                                                            $img_num = $img_rs->num_rows;

                                                            if ($img_num != 0) {
                                                                $img_data = $img_rs->fetch_assoc();
                                                                $first_img_path = $img_data["img_path"];

                                                            ?>

                                                                <img src="<?php echo $img_data["img_path"]; ?>" class="border rounded me-3" style="width: 96px; height: 96px;" />

                                                            <?php
                                                            } else {
                                                            ?>

                                                                <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/11.webp" class="border rounded me-3" style="width: 96px; height: 96px;" />

                                                            <?php
                                                            }
                                                            ?>

                                                            <?php

                                                            $defaultTotalPrice = $cart_data["qty"] * $product_data["price"];

                                                            ?>

                                                            <div class="">
                                                                <a href="#" class="nav-link"><?php echo $product_data["title"]; ?></a>
                                                                <p class="text-muted"><?php echo $product_data["clr_name"]; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- product img -->

                                                
                                                <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                                                    <div class="mt-3">
                                                        <div class="input-group mb-3" style="width: 140px;">
                                                            
                                                            <button class="btn btn-white border px-3" type="button" onclick="cartqty_dec(<?php echo $item; ?>); updateqty(<?php echo $item; ?>,<?php echo $product_data['id']; ?>); 
                                                            total(<?php echo $item; ?>,<?php echo $product_data['price']; ?>); subtotal();">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="text" class="form-control text-center border fw-bold" style="outline: none;" pattern="[1-9]" value="<?php echo $cart_data["qty"]; ?>" onkeyup='check_value(<?php echo $product_data["qty"]; ?>);' id="cartqty_input_<?php echo $item; ?>" disabled />
                                                            <button class="btn btn-white border px-3" type="button" onclick="cartqty_inc(<?php echo $product_data['qty']; ?>,<?php echo $item; ?>); 
                                                            updateqty(<?php echo $item; ?>,<?php echo $product_data['id']; ?>); total(<?php echo $item; ?>,<?php echo $product_data['price']; ?>); subtotal();">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="ms-3 mt-2">
                                                        <text class="h6 ms-1">Rs. <span id="totalPrice_<?php echo $item; ?>"><?php echo $defaultTotalPrice; ?></span>.00</text> <br /> <!--total price-->
                                                        <text class="text-muted text-nowrap ms-1">Rs. <?php echo $product_data["price"]; ?>.00 / per item </text><!--per item price-->
                                                        <table class="mt-2 mb-2">
                                                            <tr>
                                                                <th>Delivery :</th>
                                                                <td>Rs. <span><?php echo $delivery; ?></span>.00</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-lg col-sm-6 d-flex justify-content-center justify-content-sm-end justify-content-md-end align-content-center justify-content-md-start justify-content-lg-center justify-content-xl-end mt-lg-3">
                                                    <div class="float-md-end">
                                                        <button class="btn btn-light border px-2 icon-hover-primary"><i class="fas fa-heart fa-lg px-1 text-secondary" onclick="addWatchlist(<?php echo $product_data['id']; ?>);"></i></button>
                                                        <button class="btn btn-light border text-danger icon-hover-danger" onclick="removeFromCart(<?php echo $product_data['id']; ?>);"> Remove</button>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php

                                        }
                                    }

                                    ?>

                                </div>
                                <div class="border-top pt-4 mx-4 mb-4">
                                    <p><i class="fas fa-truck text-muted fa-lg"></i> Delivery within 1-2 days</p>
                                    <p class="text-muted">
                                        Experience swift and reliable delivery with <span class="text-warning fw-bold fs-5">Mobile Planet</span>. We're delighted to offer: <br> <br>

                                        <b>Within Colombo</b><br>
                                        Enjoy the convenience of receiving your order within one business day. <br>

                                        <b>Outside Colombo</b><br>
                                        Expect delivery at your doorstep within 1-2 business days.
                                        Shop with confidence knowing that our dedicated delivery team is committed to ensuring your products arrive promptly and in excellent condition.

                                        For any inquiries or special requests, feel free to reach out to our customer service team at <a href="">Planet.lk™</a>.

                                        Thank you for choosing <span class="text-warning fw-bold fs-5">Mobile Planet</span> <b>!</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- cart -->

                        
                        <div class="col-lg-3">
                            <div class="card shadow-0 border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2">Items:</p>
                                        <p class="mb-2">( <span id="item"><?php echo $item; ?></span> )</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2">Sub Total price:</p>
                                        <p class="mb-2">Rs. <span id="subTot">
                                                <?php

                                                if ($cart_num == 0) {
                                                ?>0<?php
                                                } else {
                                                    echo $total;
                                                }
                                                    ?></span>.00</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2">Delivery to
                                            <?php

                                                $user_city_rs = Database::search("SELECT `city_name` FROM city INNER JOIN users_has_address
                                                ON city.city_id = users_has_address.city_city_id
                                                WHERE users_has_address.users_email = '".$user."'");
                                                $user_city_data = $user_city_rs -> fetch_assoc();

                                            if (isset($address_data['cname'])) {
                                                $address_data['cname'];
                                            } else {
                                                echo $user_city_data['city_name'];
                                            }
                                            ?> :</p>
                                        <p class="mb-2">Rs. <span>
                                                <?php

                                                if ($cart_num == 0) {
                                                    echo "0";
                                                } else {
                                                    echo $delivery_total;
                                                }
                                                ?></span>.00</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2">Total price:</p>
                                        <p class="mb-2 fw-bold">Rs. <span><?php

                                                                            if ($cart_num == 0) {
                                                                            ?>0<?php
                                                                            } else {
                                                                                echo $final_total;
                                                                            }
                                                                                ?></span>.00</p>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-success w-100 shadow-0 mb-2" onclick="checkout();"> Confirm Purchase </button>
                                        <a href="index.php" class="btn btn-light w-100 border mt-2"> Back to shop </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <hr>


            

            <div class="container my-5">
                <header class="mb-4">
                    <h3>Recommended items</h3>
                </header>

                <div class="row">

                    <?php

                    $product_rs = Database::search("SELECT * FROM `product` ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0");

                    $product_num = $product_rs->num_rows;

                    for ($x = 0; $x < $product_num; $x++) {
                        $product_data = $product_rs->fetch_assoc();

                    ?>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                                <div class="row">
                                    <div class="px-2" style="height: 50px;">
                                        <div class="d-flex col-12 justify-content-between">

                                            <?php

                                            if ($product_data["condition_condition_id"] == 1) {
                                            ?>
                                                <h6><span class="badge bg-info pt-1 mt-3 ms-2 text-black">New</span></h6>
                                            <?php
                                            } else if ($product_data["condition_condition_id"] == 2) {
                                            ?>
                                                <h6><span class="badge bg-warning pt-1 mt-3 ms-2 text-black">Used</span></h6>
                                            <?php
                                            } else {
                                            ?>
                                                <h6><span class="badge bg-danger-subtle pt-1 mt-3 ms-2 text-black">Recondition</span></h6>
                                            <?php

                                            }

                                            ?>


                                            <a href="#"><i class="fas fa-heart text-danger fa-lg float-end pt-2 m-2" onclick="addWatchlist(<?php echo $product_data['id']; ?>);"></i></a>
                                        </div>
                                    </div>

                                    <?php

                                    $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["id"] . "'");
                                    $img_data = $img_rs->fetch_assoc();

                                    ?>

                                    <div class="col-12">
                                        <a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>" class="">
                                            <img src="<?php echo $img_data["img_path"]; ?>" class="card-img-top rounded-2" />
                                        </a>
                                    </div>
                                </div>


                                <div class="card-body d-flex flex-column pt-3 border-top">
                                    <a href="#" class="nav-link"><?php echo $product_data["title"]; ?></a>
                                    <div class="price-wrap mb-2">

                                        <?php

                                        $price = $product_data["price"];
                                        $add = ($price / 100) * 10;
                                        $new_price = $price + $add;
                                        $diff = $new_price - $price;
                                        $percent = ($diff / $price) * 100;

                                        ?>

                                        <strong class="fs-5 me-2">Rs. <?php echo $price; ?>.00</strong>
                                        <del class="text-danger">Rs.<?php echo $new_price; ?>.00</del>
                                    </div>
                                    <div class="row card-footer bg-white d-flex align-items-center">
                                        <div class="pt-1 px-0 pb-0 mt-auto">
                                            <a href="#" class="btn btn-outline-primary w-100" onclick="homeaddtocart(<?php echo $product_data['id']; ?>);">Add to cart</a>
                                        </div>
                                        <div class="pt-2 px-0 pb-0 mt-auto">
                                            <a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>" class="btn btn-outline-success w-100">Buy now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php

                    }

                    ?>

                </div>
            </div>

            <?php require "footer.php"; ?>

        </div>


        <script src="script.js"></script>
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location: SignIn.php");
    exit();
}

?>