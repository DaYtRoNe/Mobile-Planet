<?php

session_start();
require("connection.php");

if (isset($_SESSION["a"])) {

    $order_rs = Database::search("SELECT * FROM `order_history` INNER JOIN `order_status` ON `order_history`.order_status_os_id = order_status.os_id ORDER BY `ohid` ASC");
    $order_num = $order_rs->num_rows;
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Management</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">
        <title>Mobile Planet | Admin Dashboard</title>
        <link rel="icon" href="resources/logo.svg">
    </head>

    <body class=" bg-secondary-subtle">

        <?php require("adminNavBar.php"); ?>

        <div class="container mt-6 mb-3">
            <div class="card p-3 rounded-6">
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <h2>Order Management</h2>
                </div>

                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        for ($i = 1; $i <= $order_num; $i++) {
                            $order_data = $order_rs->fetch_assoc();

                            $urs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $order_data["users_email"] . "'");
                            $user = $urs->fetch_assoc();
                        ?>

                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>#<?php echo $order_data["order_id"]; ?></td>
                                <td>
                                    <p><strong><?php echo $user["fname"]; ?> <?php echo $user["lname"]; ?></strong><br>
                                        <small><?php echo $order_data["users_email"]; ?></small>
                                    </p>
                                </td>
                                <td><?php echo $order_data["order_date"]; ?></td>
                                <td><?php echo $order_data["ostatus"]; ?></td>
                                <td>LKR <?php echo $order_data["amount"]; ?></td>
                                <td>
                                    <a href="<?php echo "orderDetails.php?orderId=" . ($order_data["ohid"]); ?>" class="btn btn-sm btn-info">View</a>
                                    <select class="bg-warning form-select-sm border-3 border-warning" id="os<?php echo $i ?>" onchange="changeOrderStatus(<?php echo $order_data['ohid'] ?>,<?php echo $i ?>);">

                                        <?php

                                        $strs = Database::search("SELECT * FROM `order_status` ORDER BY `os_id` ASC");
                                        $stnum = $strs->num_rows;

                                        for ($j = 0; $j < $stnum; $j++) {
                                            $sdata = $strs->fetch_assoc();
                                            if ($order_data["order_status_os_id"] == $sdata["os_id"]) {
                                        ?>
                                                <option value="<?php echo $sdata["os_id"]; ?>" selected><?php echo $sdata["ostatus"]; ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?php echo $sdata["os_id"]; ?>"><?php echo $sdata["ostatus"]; ?></option>
                                        <?php
                                            }
                                        }

                                        ?>

                                    </select>
                                </td>
                            </tr>

                        <?php
                        }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>

        <?php require("footer.php"); ?>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
        <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB5-Pro-Advanced_3.8.1/js/mdb.min.js"></script>
    </body>

    </html>



<?php
} else {
    header("Location:admin_login.php");
}
?>