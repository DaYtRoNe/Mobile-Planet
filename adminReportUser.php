<?php

session_start();
require "connection.php";

if (isset($_SESSION["a"])) {

    $user_rs =  Database::search("SELECT `fname`,`lname`,`email`,`mobile`,`joined_date`,`status`,`type`  FROM `users` INNER JOIN `user_type`
    ON users.user_type_id = user_type.id ORDER BY `type` ASC");
    $user_num =  $user_rs->num_rows;

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Customer Report</title>
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
                        <h1 class=" text-decoration-underline">Customer Report</h1>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover mt-2">
                            <thead class="bg-dark">
                                <tr>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>User Email</th>
                                    <th>User Mobile Number</th>
                                    <th>Joined Date</th>
                                    <th>User Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                for ($i = 1; $i <= $user_num; $i++) {
                                    $user_data = $user_rs->fetch_assoc();
                                    $user_status;
                                    if ($user_data["status"] == 1) {
                                        $user_status = "Active";
                                    } else if ($user_data["status"] == 2) {
                                        $user_status = "Inactive";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo ($i); ?></td>
                                        <td><?php echo ($user_data["fname"]); ?></td>
                                        <td><?php echo ($user_data["lname"]); ?></td>
                                        <td><?php echo ($user_data["email"]); ?></td>
                                        <td><?php echo ($user_data["mobile"]); ?></td>
                                        <td><?php echo ($user_data["joined_date"]); ?></td>
                                        <td><?php echo ($user_data["type"]); ?></td>
                                        <td><?php echo ($user_status); ?></td>
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