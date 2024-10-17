<?php

session_start();
require("connection.php");

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mobile Planet | Purchase History</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body>

    <?php require("header.php"); ?>

        <div class="container mt-6">
            <div class="">
                <div class="my-4">
                    <h1 class="text-center">Purchase History</h1>
                </div>

                <?php

                $order_rs = Database::search("SELECT * FROM `order_history` INNER JOIN `order_status` ON order_history.order_status_os_id = order_status.os_id 
                WHERE `users_email` = '" . $email . "' ORDER BY `ohid` ASC");
                $order_num = $order_rs->num_rows;

                for ($i = 0; $i < $order_num; $i++) {
                    $order_data = $order_rs->fetch_assoc();
                ?>

                    <!-- -----------------------------------card----------------------------- -->
                    <div class="card rounded-6 bg-primary-subtle my-4">
                        <div class="">
                            <div class="row text-center mt-2">
                                <div class="col-md-4">
                                    <p><span class="fw-bold">Order ID :</span> #<?php echo $order_data["order_id"]; ?></p>
                                </div>
                                <div class="col-md-4">
                                    <p><span class="fw-bold">Date of Order :</span> <?php echo $order_data["order_date"]; ?></p>
                                </div>
                                <div class="col-md-4">
                                    <p><span class="fw-bold">Delivery Status :</span> <?php echo $order_data["ostatus"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product Name</th>
                                        <th>quantity</th>
                                        <th>Price</th>
                                        <th>Delivery Fee</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $oitem_rs = Database::search("SELECT * FROM `order_item` WHERE `order_history_ohid` = '" . $order_data["ohid"] . "'");
                                    $oitem_num = $oitem_rs->num_rows;

                                    for ($j = 0; $j < $oitem_num; $j++) {
                                        $oitem_data = $oitem_rs->fetch_assoc();

                                        $prs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $oitem_data["product_id"] . "'");
                                        $pdata = $prs->fetch_assoc();

                                        $city_rs = Database::search("SELECT * FROM `users_has_address` WHERE `users_email` = '" . $email . "'");
                                        $city_data = $city_rs->fetch_assoc();

                                        $district_rs = Database::search("SELECT * FROM `city` WHERE `city_id` = '" . $city_data["city_city_id"] . "'");
                                        $district_data = $district_rs->fetch_assoc();

                                        $district_id = $district_data["district_district_id"];

                                        $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '".$pdata["id"]."'");
                                        $img_data = $img_rs->fetch_assoc();
                                    ?>

                                        <tr>
                                            <td>
                                                <img src="<?php echo $img_data["img_path"] ?>" alt="" style="height: 70px; width:70px;">
                                            </td>
                                            <td><?php echo $pdata["title"] ?></td>
                                            <td><?php echo $oitem_data["oi_qty"] ?></td>
                                            <td><?php echo $pdata["price"] ?> x <?php echo $oitem_data["oi_qty"] ?></td>
                                            <td><?php
                                                if ($district_id == 15) {
                                                    echo $pdata["delivery_fee_colombo"];
                                                } else {
                                                    echo $pdata["dilivery_fee_other"];
                                                }
                                                ?> x <?php echo $oitem_data["oi_qty"] ?></td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end me-5">
                            <p>total Amount : LKR <?php echo $order_data["amount"]; ?></p>
                        </div>
                        <div class="d-flex justify-content-end me-5 mb-3">
                            <a href="<?php echo "invoice.php?orderId=" . ($order_data["ohid"]); ?>" class="btn btn-outline-primary rounded-7">Print Invoice</a>
                        </div>
                    </div>
                    <!-- -----------------------------------card----------------------------- -->

                <?php
                }
                ?>

            </div>
        </div>

        <?php require("footer.php"); ?>



        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script> -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
        <script src="script.js"></script>
    </body>

    </html>


<?php
} else {
    header("location:SignIn.php");
}
?>