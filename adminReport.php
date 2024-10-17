<?php

session_start();
require "connection.php";

if (isset($_SESSION["a"])) {

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Add Product</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body style="background-image: linear-gradient(to right, #d7d2cc 0%, #304352 100%);">

        <?php require "adminNavBar.php" ?>
        <?php require "popup.php" ?>

        <div style="height:61vh" class="d-flex justify-content-center align-items-center">
        <div class="container my-5">
            <div class="card mt-6 shadow-6-strong rounded-4">

                <div class="card-header text-center">
                    <h1 class="">Reports</h1>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 my-3">
                            <a href="adminReportStock.php" class="btn btn-primary col-12 rounded-5">Stock Report</a>
                        </div>
                        <div class="col-md-3 my-3">
                            <a href="adminReportProduct.php" class="btn btn-primary col-12 rounded-5">Product Report</a>
                        </div>
                        <div class="col-md-3 my-3">
                            <a href="adminReportUser.php" class="btn btn-primary col-12 rounded-5">User Report</a>
                        </div>
                        <div class="col-md-3 my-3">
                            <a href="adminReportOrder.php" class="btn btn-primary col-12 rounded-5">Order Report</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>

        <div class="">
            <?php include "footer.php"; ?>
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