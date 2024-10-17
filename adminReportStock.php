<?php

session_start();
require "connection.php";

if (isset($_SESSION["a"])) {

    $rs =  Database::search("SELECT * FROM `product`");
    $num =  $rs->num_rows;

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Stock Report</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body style="background-image: linear-gradient(to right, #d7d2cc 0%, #304352 100%);">

        <div class="container my-5">
            <a href="adminReport.php" class="h1"> <i class="fa-solid fa-chevron-left"></i></a>
            <div class="mt-4">
            <div class="card mt-1 shadow" id="printArea">
                <div class="card-head my-3 text-center">
                    <h1 class=" text-decoration-underline">Stock Report</h1>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover mt-5">
                        <thead class="bg-dark">
                            <tr>
                                <th>Stock Id</th>
                                <th>Product Name</th>
                                <th>Stock Quantity</th>
                                <th>Unit Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            for ($i = 0; $i < $num; $i++) {
                                $data = $rs->fetch_assoc(); ?>
                                <tr>
                                    <td><?php echo ($data["id"]); ?></td>
                                    <td><?php echo ($data["title"]); ?></td>
                                    <td><?php echo ($data["qty"]); ?></td>
                                    <td><?php echo ("Rs." . $data["price"]); ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end container mt-3 mb-1">
                        <button class="btn btn-secondary border border-black rounded-6" onclick="printDiv();">Print</button>
                    </div>
                </div>

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