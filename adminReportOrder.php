<?php

session_start();
require "connection.php";

if (isset($_SESSION["a"])) {

    $ohrs = Database::search("SELECT * FROM `order_history` INNER JOIN `order_status` 
    ON order_history.order_status_os_id = order_status.os_id");
    $ohnum = $ohrs->num_rows;

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Order Report</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body style="background-image: linear-gradient(to right, #d7d2cc 0%, #304352 100%);">

        <div class="container my-5">
            <a href="adminReport.php" class="h1"> <i class="fa-solid fa-chevron-left"></i></a>
            <div class="card mt-4">
                <div class="mt-1" id="printArea">
                    <div class="card-head my-3 text-center">
                        <h1 class=" text-decoration-underline">Order Report</h1>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover mt-2">
                            <thead class="bg-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Order Id</th>
                                    <th>Order Date</th>
                                    <th>User Email</th>
                                    <th>Product Names</th>
                                    <th>Amount</th>
                                    <th>Customer Address</th>
                                    <th>Order Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                for ($i = 1; $i <= $ohnum; $i++) {
                                    $ohdata = $ohrs->fetch_assoc();

                                    $uadd_rs = Database::search("SELECT * FROM `users_has_address` INNER JOIN `city` 
                                    ON users_has_address.city_city_id = city.city_id
                                    INNER JOIN `district`
                                    ON city.district_district_id = district.district_id
                                    WHERE `users_email` = '".$ohdata["users_email"]."'");
                                    $addata = $uadd_rs->fetch_assoc();

                                    $address = $addata["line1"].",".$addata["line2"];

                                ?>
                                    <tr>
                                        <td><?php echo ($i); ?></td>
                                        <td>#<?php echo ($ohdata["order_id"]); ?></td>
                                        <td><?php echo ($ohdata["order_date"]); ?></td>
                                        <td><?php echo ($ohdata["users_email"]); ?></td>

                                        <?php

                                        $oitem_rs = Database::search("SELECT * FROM `order_item` INNER JOIN `product`
                                        ON order_item.product_id = product.id
                                        WHERE `order_history_ohid` = '" . $ohdata["ohid"] . "'");
                                        $oitem_num = $oitem_rs->num_rows;

                                        ?>

                                        <td><?php 
                                        
                                        for ($j=0; $j < $oitem_num; $j++) {
                                            $oitem_data = $oitem_rs->fetch_assoc();
                                            echo("<p>". $oitem_data["title"] ."</p>");
                                        }
                                        
                                        ?></td>
                                        <td><?php echo ($ohdata["amount"]); ?></td>
                                        <td><?php echo ("<p>". $addata["line1"].", ".$addata["line2"]. "</br>".$addata["district_name"]."</p>"); ?></td>
                                        <td><?php echo ($ohdata["ostatus"]); ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end container mb-3">
                    <button class="btn btn-secondary border border-black rounded-6" onclick="printDiv();">Print</button>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
        <script src="script.js"></script>
    </body>

    </html>


<?php

} else {
    header("Location:admin_login.php");
}

?>