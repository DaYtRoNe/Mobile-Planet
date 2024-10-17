<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];
?>

    <!DOCTYPE html>

    <head>

        <meta charset="utf-8">
        <title>Mobile Planet | Watch List</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="mdb.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="css/bootstrap.css" />

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body class="bg-secondary-subtle">

        <?php 
        require "header.php"; 
        require "popup.php"; 
        ?>

        <div class="container mt-6 mb-4 bg-body">
            <div class="row">

                <div class="col-12 mb-3 mt-3 border-bottom">
                    <div class="row w-100">
                        <div class="offset-lg-2 col-12 col-lg-7 mb-3">
                            <input type="text" class="form-control bg-secondary-subtle" id="kw" placeholder="Search in Watchlist..." />
                        </div>
                        <div class="col-12 col-lg-2 mb-3 d-grid">
                            <button class="btn btn-primary" onclick="watchSearch(0);">Search</button>
                        </div>
                    </div>
                </div>

                <div class="d-sm-flex align-items-center justify-content-center border-bottom mb-4 pb-3">

                    <?php

                    $pagination_rs = Database::search("SELECT * FROM `watchlist` WHERE `users_email`='" . $email . "'");
                    $pagination_num = $pagination_rs->num_rows;

                    ?>

                    <div class="col-4 logo my-3 d-block py-1 fw-bold" style="height: 60px;"></div>
                </div>

                <!-- sidebar -->
                <div class="nav flex-column nav-pills col-12 col-lg-3 mt-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active w-100" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">My Watchlist</button>
                </div>
                <!-- sidebar -->

                <!-- content -->
                <div class="tab-content col-12 col-lg-9 border-start" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                        <div class="row">

                            <?php

                            if (isset($_GET["page"])) {
                                $pageno = $_GET["page"];
                            } else {
                                $pageno = 1;
                            }

                            $watclist_rs = Database::search("SELECT * FROM `watchlist` WHERE `users_email`='" . $email . "'");
                            $watchlist_num = $watclist_rs->num_rows;

                            $results_per_page = 2;
                            $number_of_pages = ceil($watchlist_num / $results_per_page);

                            $page_results = ($pageno - 1) * $results_per_page;

                            $product_rs = Database::search("SELECT * FROM `product` 
                            INNER JOIN color 
                            ON product.color_clr_id = color.clr_id 
                            INNER JOIN status 
                            ON product.status_status_id = status.status_id 
                            INNER JOIN `condition` 
                            ON product.condition_condition_id = condition.condition_id 
                            INNER JOIN `watchlist`
                            ON product.id = watchlist.product_id
                            WHERE watchlist.users_email = '" . $email . "' LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

                            $product_num = $product_rs->num_rows;


                            if ($watchlist_num == 0) {
                            ?>
                                <!-- Empty View -->
                                <div class="col-12 border-end">
                                            <div class="row">
                                                <div class="col-12 emptyView"></div>
                                                <div class="col-12 text-center mb-2">
                                                    <label class="form-label fs-1 fw-bold">
                                                        You have no items in your Watch List yet.
                                                    </label>
                                                </div>
                                                <div class="offset-lg-4 col-12 col-lg-4 mb-4 d-grid">
                                                    <a href="index.php" class="btn btn-warning fs-3 fw-bold">
                                                        Start Shopping
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Empty View -->
                                <?php
                            } else {
                                for ($x = 0; $x < $product_num; $x++) {
                                    $product_data = $product_rs->fetch_assoc();

                                ?>

                                    <div class="row justify-content-center mb-3">
                                        <div class="col-md-12">
                                            <!-- card -->
                                            <div class="card shadow-0 border rounded-3">
                                                <div class="card-body">
                                                    <div class="row g-0">
                                                        <div class="col-xl-3 col-md-4 d-flex justify-content-center">

                                                            <?php

                                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["product_id"] . "'");
                                                            $img_num = $img_rs->num_rows;

                                                            if ($img_num != 0) {
                                                                $img_data = $img_rs->fetch_assoc();
                                                                $first_img_path = $img_data["img_path"];

                                                            ?>

                                                                <div class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                                                    <img src="<?php echo $first_img_path; ?>" class="w-100" />
                                                                </div>

                                                            <?php
                                                            } else {
                                                            ?>

                                                                <div class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                                                    <img src="resources/empty.svg" class="w-100" />
                                                                </div>

                                                            <?php
                                                            }

                                                            ?>
                                                        </div>
                                                        <div class="col-xl-6 col-md-5 col-sm-7">
                                                            <h5><?php echo $product_data['title']; ?></h5>
                                                            <div class="d-flex flex-row">
                                                                <div class="text-warning mb-3 me-2">
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                    <span class="ms-1">
                                                                        4.5
                                                                    </span>
                                                                </div>
                                                                <span class="text-muted">154 orders</span>
                                                            </div>

                                                            <div class="row mt-2">

                                                                <dt class="col-3">Colour:</dt>
                                                                <dd class="col-9"><?php echo $product_data["clr_name"]; ?></dd>

                                                                <dt class="col-3">Condition:</dt>
                                                                <dd class="col-9"><?php echo $product_data["condition_name"]; ?></dd>

                                                                <dt class="col-3">Available:</dt>
                                                                <dd class="col-9"><?php echo $product_data["qty"]; ?></dd>

                                                            </div>
                                                        </div>

                                                        <?php

                                                        $price = $product_data["price"];
                                                        $add = ($price / 100) * 10;
                                                        $new_price = $price + $add;
                                                        $diff = $new_price - $price;
                                                        $percent = ($diff / $price) * 100;

                                                        ?>

                                                        <div class="col-xl-3 col-md-3 col-sm-5">
                                                            <div class="d-flex flex-row align-items-center mb-1">
                                                                <h4 class="mb-1 me-1">Rs. <?php echo $price; ?>.00</h4>
                                                                <span class="text-danger"><s>Rs. <?php echo $new_price; ?>.00</s></span>
                                                            </div>
                                                            <h6 class="text-success"><?php echo $product_data['status_name']; ?></h6>
                                                            <div class="mt-4">
                                                                <div class="col-12">
                                                                    <a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>" class="btn btn-primary shadow-0 w-50" type="button">Buy this</a>
                                                                    <button class="btn btn-light border px-2 pt-2 icon-hover" onclick="homeaddtocart(<?php echo $product_data['id']; ?>);"><i class="fa fa-shopping-cart fa-lg mx-1"></i></button>
                                                                </div>
                                                                <div class="col-12 mt-2">
                                                                    <button class="btn btn-danger shadow-0 w-75" type="button" onclick="confirmRemove(<?php echo $product_data['product_id']; ?>);">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card -->
                                        </div>
                                    </div>

                            <?php

                                }
                            }

                            ?>

                            <hr />

                            <!-- Pagination -->
                            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="ms-lg-3 pagination pagination-lg justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="
                                                <?php if ($pageno <= 1) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno - 1);
                                                } ?>
                                                " aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <?php

                                        for ($y = 1; $y <= $number_of_pages; $y++) {
                                            if ($y == $pageno) {
                                        ?>
                                                <li class="page-item active">
                                                    <a class="page-link" href="<?php echo "?page=" . ($y); ?>"><?php echo $y; ?></a>
                                                </li>
                                            <?php
                                            } else {
                                            ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?php echo "?page=" . ($y); ?>"><?php echo $y; ?></a>
                                                </li>
                                        <?php
                                            }
                                        }

                                        ?>

                                        <li class="page-item">
                                            <a class="page-link" href="
                                                <?php if ($pageno >= $number_of_pages) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno + 1);
                                                } ?>
                                                " aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Pagination -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
                </div>

            </div>

        </div>
        <!-- content -->

        <?php require "footer.php"; ?>

        <script type="text/javascript" src="bootstrap.bundle.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location:SignIn.php");
}

?>