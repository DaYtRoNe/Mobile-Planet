<?php

session_start();

require "connection.php";

if (isset($_SESSION["a"])) {
    $orderHistoryId = $_GET["orderId"];

    $ohrs = Database::search("SELECT * FROM `order_history` INNER JOIN `order_status` ON `order_history`.order_status_os_id = order_status.os_id WHERE `ohid` = '" . $orderHistoryId . "'");
    $ohdata = $ohrs->fetch_assoc();

    $urs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $ohdata["users_email"] . "'");
    $user = $urs->fetch_assoc();

    $adrs = Database::search("SELECT * FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id = city.city_id 
    WHERE `users_email` = '" . $ohdata["users_email"] . "'");
    $addata = $adrs->fetch_assoc();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mobile Planet | Order Details</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
        <link rel="icon" href="resources/logo.svg">
    </head>

    <body class=" bg-secondary-subtle">

        <?php require("adminNavBar.php"); ?>

        <div class="container mt-6 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4 p-2">
                <h2>Order Details</h2>
                <a href="manageOrders.php" class="btn btn-primary">Back to Orders</a>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order #<?php echo $ohdata["order_id"]; ?></h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Customer Information</h5>
                    <p class="card-text"><strong>Name: </strong><?php echo $user["fname"]; ?> <?php echo $user["lname"]; ?></p>
                    <p class="card-text"><strong>Email: </strong><?php echo $ohdata["users_email"]; ?></p>
                    <p class="card-text"><strong>Phone:</strong> <?php echo $user["mobile"]; ?></p>
                    <p class="card-text"><strong>Address:</strong> <?php echo $addata["line1"] ?>, <?php echo $addata["line2"] ?>, <?php echo $addata["city_name"] ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Delivery</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $prs = Database::search("SELECT * FROM `product` INNER JOIN `order_item` ON product.id = order_item.product_id INNER JOIN `order_history` 
                                ON order_item.order_history_ohid = order_history.ohid WHERE `ohid` = '" . $orderHistoryId . "'");
                            $pnum = $prs->num_rows;

                            for ($i = 1; $i <= $pnum; $i++) {
                                $pdata = $prs->fetch_assoc();
                                $df;
                            ?>
                                <tr>
                                    <td><?php echo $pdata["title"]; ?></td>
                                    <td><?php echo $pdata["oi_qty"]; ?></td>
                                    <td>LKR <?php echo $pdata["price"]; ?> x <?php echo $pdata["oi_qty"]; ?></td>
                                    <td>LKR <?php if ($addata["district_district_id"] == 15) {
                                                $df = $pdata["delivery_fee_colombo"];
                                                echo $pdata["delivery_fee_colombo"];
                                            } else {
                                                $df = $pdata["dilivery_fee_other"];
                                                echo $pdata["dilivery_fee_other"];
                                            }
                                            ?> x <?php echo $pdata["oi_qty"] ?></td>

                                    <?php

                                    $total = (intval($pdata["price"]) * intval($pdata["oi_qty"]));
                                    $total += (intval($df) * intval($pdata["oi_qty"]));

                                    ?>

                                    <td>LKR <?php echo $total; ?></td>
                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end"><strong>Total:</strong></th>
                                <th>LKR <?php echo $ohdata["amount"] ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Payment and Status</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Payment Status:</strong> <span class="badge bg-success">Paid</span></p>
                    <p class="card-text"><strong>Status:</strong> <span class="badge bg-warning"><?php echo $ohdata["ostatus"] ?></span></p>
                </div>
            </div>
        </div>

        <?php require("footer.php"); ?>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    </body>

    </html>

<?php
}
?>