<?php

session_start();

require "connection.php";

if (isset($_SESSION["a"])) {

    $email = $_SESSION["a"]["email"];

    $pageno;

?>


    <!DOCTYPE html>

    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Manage Products</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="style.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />

        <link rel="icon" href="resources/logo.svg" />

    </head>

    <body style="background-image: linear-gradient(to top, lightgrey 0%, lightgrey 1%, #e0e0e0 26%, #efefef 48%, #d9d9d9 75%, #bcbcbc 100%);">

        <div class="container py-5">
            <div class="row mx-2 mx-md-0">

                <?php require "adminNavBar.php"; ?>

                <!-- body -->
                <div class="mt-5">
                    <div class="row">

                        <div class="col-12 rounded-4 card bg-body-tertiary">
                            <div class="row mb-3">
                                <div class="text-center col-8">
                                    <p class="mt-3 fs-1 fw-bold">Manage Products</p>
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <button class="btn btn-warning fw-bold fs-4 rounded-3 mb-2 mt-1 mt-lg-2 rounded-4" onclick="window.location='addProduct.php'">Add Product</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3 d-flex justify-content-end">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <input type="text" placeholder="Search..." class="form-control rounded-4" id="se">
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <select name="sort_select" class="form-select rounded-4" id="sse">
                                        <option value="0">Sort by</option>
                                        <option value="1">Newest to oldest</option>
                                        <option value="2">Oldest to newest</option>
                                        <option value="3">Price high to low</option>
                                        <option value="4">Price low to high </option>
                                        <option value="5">Quantity high to low</option>
                                        <option value="6">Quantity low to high</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <select name="condition_select" class="form-select rounded-4" id="cse">
                                        <option value="0">Condition by</option>
                                        <?php

                                        $con_rs = Database::search("SELECT * FROM `condition`");
                                        $con_num = $con_rs->num_rows;

                                        for ($i = 0; $i < $con_num; $i++) {
                                            $con_data = $con_rs->fetch_assoc();

                                        ?>

                                            <option value="<?php echo $con_data["condition_id"]; ?>"><?php echo $con_data["condition_name"]; ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1 mb-3 d-flex justify-content-end">
                                    <button class="btn btn-primary fw-bold rounded-4" onclick="filter(0);">Sort</button>
                                </div>
                            </div>

                        </div>

                        <!-- product -->
                        <div class="mt-3 mb-3 card card-body rounded-4 container-fluid bg-body-tertiary">
                            <div class="row" id="sort">

                                <div class="text-center mt-3">
                                    <div class="row mx-2 mx-md-0 d-flex justify-content-center">

                                        <?php

                                        if (isset($_GET["page"])) {
                                            $pageno = $_GET["page"];
                                        } else {
                                            $pageno = 1;
                                        }

                                        $product_rs = Database::search("SELECT * FROM `product`");
                                        $product_num = $product_rs->num_rows;

                                        $results_per_page = 4;
                                        $number_of_pages = ceil($product_num / $results_per_page);

                                        $page_results = ($pageno - 1) * $results_per_page;
                                        $selected_rs = Database::search("SELECT * FROM `product` LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

                                        $selected_num = $selected_rs->num_rows;

                                        for ($x = 0; $x < $selected_num; $x++) {
                                            $selected_data = $selected_rs->fetch_assoc();

                                        ?>

                                            <!-- card -->
                                            <div class="card col-md-4 mb-4 mx-3 rounded-4">
                                                <div class="row">
                                                    <div class="col-md-4 mt-3 mb-2">
                                                        <?php

                                                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();

                                                        ?>

                                                        <img src="<?php echo $product_img_data["img_path"]; ?>" class="img-fluid rounded-start" />
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <h5 class="card-title fw-bold"><?php echo $selected_data["title"]; ?></h5>
                                                            <span class="card-text fw-bold text-primary">Rs. <?php echo $selected_data["price"]; ?>.00</span><br />
                                                            <span class="card-text fw-bold text-success"><?php echo $selected_data["qty"]; ?> Items left</span>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input fs-5" type="checkbox" role="switch" id="<?php echo $selected_data["id"]; ?>" onchange="changeProductStatus(<?php echo $selected_data['id']; ?>);" <?php if ($selected_data["status_status_id"] == 2) { ?> checked <?php } ?> />
                                                                <label class="form-check-label fw-bold text-info" for="<?php echo $selected_data["id"]; ?>">
                                                                    <?php if ($selected_data["status_status_id"] == 2) { ?>
                                                                        Activate Product
                                                                    <?php } else {
                                                                    ?>
                                                                        Deactivate Product
                                                                    <?php
                                                                    } ?>
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="row g-1">
                                                                        <div class="col-12 col-lg-6 d-grid">
                                                                            <button class="btn btn-success fw-bold" onclick="sendId(<?php echo $selected_data['id']; ?>);">Update</button>
                                                                        </div>
                                                                        <div class="col-12 col-lg-6 d-grid">
                                                                            <button class="btn btn-danger fw-bold" onclick="confirmDelete(<?php echo $selected_data['id']; ?>);">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card -->

                                        <?php
                                        }

                                        ?>



                                    </div>
                                </div>

                                <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-2">
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

                            </div>
                        </div>
                        <!-- product -->

                    </div>
                </div>
                <!-- body -->

            </div>
        </div>

        <?php require "footer.php"; ?>

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