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
        <title>Mobile Planet | Customer Management</title>
        <link rel="icon" href="resources/logo.svg">

    </head>

    <body>

        <?php require "adminNavBar.php" ?>

        <?php

        $user_rs = Database::search("SELECT * FROM `users` WHERE `user_type_id` = '2' ORDER BY fname ASC");
        $urows = $user_rs->num_rows;
        ?>

        <div class="container py-5 mt-5">

            <div class="container">
                <div class="row text-center mb-2 fw-bold">
                    <h2>Customer management</h2>
                </div>
            </div>

            <section class="mb-5">
                <div class="table-responsive bg-glass shadow-4-strong rounded-6">
                    <table class="table table-borderless table-hover align-middle mb-0 text-white">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Joined Date</th>
                                <th>Gender</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $user_rs = Database::search("SELECT * FROM `users` WHERE `user_type_id` = '2' ORDER BY fname ASC");
                            $urows = $user_rs->num_rows;

                            for ($i = 0; $i < $urows; $i++) {
                                $user_data = $user_rs->fetch_assoc();

                                $prof_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $user_data["email"] . "'");
                                $prof_img_data = $prof_img_rs->fetch_assoc();
                            ?>

                                <tr class="text-white">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php
                                            if (empty($prof_img_data["path"])) {
                                            ?>
                                                <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png" alt="" style="width: 45px; height: 45px" class="rounded-circle">
                                            <?php
                                            } else {
                                            ?>
                                                <img src=<?php echo $prof_img_data["path"] ?> alt="" style="width: 45px; height: 45px" class="rounded-circle">
                                            <?php
                                            }
                                            ?>

                                            <div class="ms-3">
                                                <p class="fw-bold mb-1"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></p>
                                                <p class="text-muted mb-0" id="mail<?php echo $i ?>"><?php echo $user_data["email"] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"><?php echo $user_data["mobile"] ?></p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"><?php echo $user_data["joined_date"] ?></p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"><?php if ($user_data["gender_id"] == 1) {
                                                                        echo ("Male");
                                                                    } else {
                                                                        echo ("Female");
                                                                    }  ?></p>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" id="id<?php echo $i ?>" onchange="changeUserStatus(<?php echo $i ?>);" <?php if ($user_data["status"] == 2) { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="id<?php echo $i ?>"></label>
                                        </div>
                                    </td>
                                </tr>

                            <?php
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </section>

        </div>


        <?php require "footer.php" ?>

        <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB5-Pro-Advanced_3.8.1/js/mdb.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
        <script src="script.js"></script>
    </body>

    </html>


<?php

} else {
    header("Location:admin_login.php");
}

?>