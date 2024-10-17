<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    $user = $_SESSION["u"];
    $orderHistoryId = $_GET["orderId"];

    $ohrs = Database::search("SELECT * FROM `order_history` WHERE `ohid` = '" . $orderHistoryId . "'");
    $ohnum = $ohrs->num_rows;

    if ($ohnum > 0) {
        $ohdata = $ohrs->fetch_assoc();
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mobile Planet | Invoice</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
            <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="style.css">
            <link rel="icon" href="resources/logo.svg" />

        </head>

        <body style="background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);">
            <div class="container py-5">
                <div class="card mt-6 mb-5">
                    <div id="printArea">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-decoration-underline">Invoice</h2>
                                    <p><strong>ORDER ID:</strong> #<?php echo $ohdata["order_id"] ?></p>
                                    <p><strong>Order Date:</strong> <?php echo $ohdata["order_date"] ?></p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h4>Mobile Planet.lk</h4>
                                    <p>No,13, Murutholuwa <br> Melpitiya, Matale</p>
                                    <p><strong>Email:</strong> eshangunsekara@gmail.com</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">

                                    <?php

                                    $adrs = Database::search("SELECT * FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id = city.city_id 
                            WHERE `users_email` = '" . $user["email"] . "'");
                                    $addata = $adrs->fetch_assoc();

                                    ?>

                                    <p><strong>Bill To:</strong></p>
                                    <p><?php echo $user["fname"] ?> <?php echo $user["lname"] ?> <br>
                                        <?php echo $addata["line1"] ?>,<?php echo $addata["line2"] ?> <br>
                                        <?php echo $addata["city_name"] ?></p>
                                    <p><strong>Email:</strong> <?php echo $user["email"] ?></p>
                                </div>
                            </div>
                            <div class="table-responsive my-4">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Qantity</th>
                                            <th>Unit Price</th>
                                            <th>Delivery</th>
                                            <th>Amount</th>
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
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $pdata["title"] ?></td>
                                                <td><?php echo $pdata["oi_qty"] ?></td>
                                                <td>LKR <?php echo $pdata["price"] ?> x <?php echo $pdata["oi_qty"] ?></td>
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
                                                <td>LKR <?php echo $total ?></td>
                                            </tr>

                                        <?php
                                        }

                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Total</strong></td>
                                            <td>LKR <?php echo $ohdata["amount"] ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-end me-4 mb-3">
                        <a href="index.php" class="btn btn-success rounded-8">
                            <i class="fas fa-home"></i> Home
                        </a>
                        <button class="btn btn-primary rounded-8" onclick="printDiv();">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
            <script src="script.js"></script>
        </body>

        </html>


        </html>

<?php

    } else {
        header("location:index.php");
    }
}

?>