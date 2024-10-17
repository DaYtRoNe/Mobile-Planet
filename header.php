<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <?php
    $email = isset($_SESSION["u"]["email"]) ? $_SESSION["u"]["email"] : null;
    ?>

    <!-- Navigation -->
    <div class="fixed-top">
        <div class="topbar bg-black">
            <div class="container">
                <div class="row">
                    <!-- Social icons -->
                    <div class="col-sm-12 d-flex justify-content-end">
                        <ul class="list-unstyled list-inline">
                            <li class="nav-item list-inline-item">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-heart fs-5 icon text-white" onclick="window.location='watchlist.php';"></i>
                                </a>
                            </li>
                            <li class="nav-item list-inline-item">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-shopping-cart fs-5 icon text-white" onclick="window.location='cart.php';"></i>
                                </a>
                            </li>
                            <li class="list-inline-item text-decoration-none mt-2">
                                <?php if (isset($_SESSION["u"])) : ?>
                                    <a href="userProfile.php" class="text-decoration-none text-light h5 fw-bold">
                                        <?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?>
                                    </a>
                                <?php else : ?>
                                    <a href="SignIn.php" class="text-decoration-none text-light h5 fw-bold">Sign In or Register</a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item list-inline-item">
                                <?php
                                if (isset($_SESSION["u"])) {
                                    $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $email . "'");
                                    $image_data = $image_rs->fetch_assoc();
                                    if (empty($image_data["path"])) {
                                        echo '<img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png" width="40" height="40" class="rounded-circle">';
                                    } else {
                                        echo '<img src="' . $image_data["path"] . '" width="50" height="50" class="rounded-circle">';
                                    }
                                } else {
                                    echo '<img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png" width="40" height="40" class="rounded-circle">';
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear bg-black">
            <div class="container">
                <a class="navbar-brand" rel="nofollow" href="index.php" style="text-transform: uppercase;">Mobile Planet</a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION["u"])) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="userProfile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="purchaseHistory.php">Purchased History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="help.php">Help & Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="signOut();">SignOut</a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="help.php">Help and Contact</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script>
    <script src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </script>
</body>

</html>