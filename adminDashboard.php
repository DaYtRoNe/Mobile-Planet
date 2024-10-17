<?php

session_start();

if (isset($_SESSION["a"])) {

    require "connection.php";

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="mdb.min.css">
        <title>Mobile Planet | Admin Dashboard</title>
        <link rel="icon" href="resources/logo.svg">

    </head>

    <body onload="loadChart();">

        <?php require "adminNavBar.php" ?>

        <?php

        $user_rs = Database::search("SELECT * FROM `users` WHERE `user_type_id` = '2' ORDER BY fname ASC");
        $urows = $user_rs->num_rows;
        ?>

        <div class="container py-5 mt-5">
            <div class="mb-5">
                <div class="row gx-xl-5">
                    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">

                        <a class="d-flex align-items-center p-4 bg-glass shadow-4-strong rounded-6 text-reset text-decoration-none" href="manageUsers.php" data-ripple-color="hsl(0, 0%, 75%)">
                            <div class="p-3 bg-theme rounded-4">
                                <i class="fa fa-users fa-lg text-white fa-fw"></i>
                            </div>
                            <div class="ms-4">
                                <p class="mb-2">Users</p>
                                <p class="mb-0">
                                    <span class="h5 me-2"> <?php echo ($urows); ?></span>
                                </p>
                            </div>
                        </a>

                    </div>

                    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">

                        <div class="d-flex align-items-center p-4 bg-glass shadow-4-strong rounded-6 text-reset text-decoration-none">
                            <div class="p-3 bg-theme rounded-4">
                                <i class="fas fa-file-alt fa-lg text-white fa-fw"></i>
                            </div>
                            <div class="ms-4 bg">

                                <?php

                                $ohrs = Database::search("SELECT * FROM `order_history`");
                                $ohnum = $ohrs->num_rows;
                                $income = 0;

                                ?>
                                <p class="mb-2">Sales</p>
                                <p class="mb-0">
                                    <span class="h5 me-2"><?php echo ($ohnum); ?></span>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">

                        <div class="d-flex align-items-center p-4 bg-glass shadow-4-strong rounded-6 text-reset text-decoration-none">
                            <div class="p-3 bg-theme rounded-4">
                                <i class="far fa-money-bill-alt fa-lg text-white fa-fw"></i>
                            </div>
                            <div class="ms-4">
                                <p class="mb-2">Income</p>
                                <?php
                                for ($i = 0; $i < $ohnum; $i++) {
                                    $ohdata = $ohrs->fetch_assoc();
                                    $income += $ohdata["amount"];
                                }
                                ?>
                                <p class="mb-0">
                                    <span class="h5 me-2">LKR.<?php echo $income; ?></span>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">

                        <div class="d-flex align-items-center p-4 bg-glass shadow-4-strong rounded-6 text-reset text-decoration-none">
                            <div class="p-3 bg-theme rounded-4">
                                <i class="fas fa-envelope fa-lg text-white fa-fw"></i>
                            </div>
                            <div class="ms-4">
                                <p class="mb-2 text-decoration-none">Messeges</p>
                                <p class="mb-0">
                                    <span class="h4 me-2">3</span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 mt-5">
                    <h2 class="text-center">Most Sold Product</h2>
                    <canvas id="myChart"></canvas>
                </div>
            </div>


            <!-- <div class="container" style="width: 800px;">
                <h2 class="text-center">Most Sold Product</h2>
                <canvas id="myChart"></canvas>
            </div> -->


        </div>


        <?php require "footer.php" ?>


        <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB5-Pro-Advanced_3.8.1/js/mdb.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </body>

    </html>


<?php

} else {
    header("Location:admin_login.php");
}

?>