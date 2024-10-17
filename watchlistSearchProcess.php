<?php

session_start();

require "connection.php";

$email = $_SESSION["u"]["email"];

$text = $_POST["t"];

$query = "SELECT product.price,product.qty,product.title,product.description,color.clr_name,
    status.status_name,condition.condition_name,product.id AS product_id FROM `product` 
    INNER JOIN `color` 
    ON product.color_clr_id = color.clr_id 
    INNER JOIN `status` 
    ON product.status_status_id = status.status_id 
    INNER JOIN `condition` 
    ON product.condition_condition_id = condition.condition_id 
    INNER JOIN `watchlist` 
    ON product.id = watchlist.product_id ";

if (empty($text)) {
    $query .= "WHERE watchlist.users_email = '" . $email . "'";
} else {
    $query .= "WHERE watchlist.users_email = '" . $email . "' AND `title` LIKE '%" . $text . "%'";
}

?>

<div class="row">

    <?php

    if (isset($_GET["page"])) {
        $pageno = $_GET["page"];
    } else {
        $pageno = 1;
    }

    $product_rs = Database::search($query);
    $product_num = $product_rs->num_rows;

    $results_per_page = 4;
    $number_of_pages = ceil($product_num / $results_per_page);

    $page_results = ($pageno - 1) * $results_per_page;
    $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " 
                                            OFFSET " . $page_results . " ");

    $selected_num = $selected_rs->num_rows;

    if ($selected_num == 0) {
    ?>
        <!-- empty view -->
        <div class="card shadow-0 border rounded-3 bg-secondary-subtle">
            <div class="card-body">
                <div class="row g-0">
                    <div class="col-lg-12 col-md-5 col-sm-7">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <img style="width: 100%;" src="https://cdni.iconscout.com/illustration/premium/thumb/no-meat-only-organic-food-985788.png?f=webp">
                                </div>
                                <div class="col-12 col-md-9 text-center">
                                    <div class="col-12 mt-5">
                                        <p class="form-label fs-2 fw-bold my-3">No matching items in your watch list.</p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <a href="home.php" class="btn btn-warning fs-4 fw-bold">Start Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- empty view -->
        <?php
    } else {


        for ($x = 0; $x < $selected_num; $x++) {
            $selected_data = $selected_rs->fetch_assoc();

            $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                                `product_id`='" . $selected_data["product_id"] . "'");
            $img_num = $product_img_rs->num_rows;

        ?>

            <div class="row justify-content-center mb-3">
                <div class="col-md-12">
                    <!-- card -->
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col-xl-3 col-md-4 d-flex justify-content-center">

                                    <?php

                                    if ($img_num != 0) {
                                        $product_img_data = $product_img_rs->fetch_assoc();
                                        $first_img_path = $product_img_data["img_path"];

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
                                    <h5><?php echo $selected_data['title']; ?></h5>
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
                                        <dd class="col-9"><?php echo $selected_data["clr_name"]; ?></dd>

                                        <dt class="col-3">Condition:</dt>
                                        <dd class="col-9"><?php echo $selected_data["condition_name"]; ?></dd>

                                        <dt class="col-3">Available:</dt>
                                        <dd class="col-9"><?php echo $selected_data["qty"]; ?></dd>

                                    </div>
                                </div>

                                <?php

                                $price = $selected_data["price"];
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
                                    <h6 class="text-success"><?php echo $selected_data['status_name']; ?></h6>
                                    <div class="mt-4">
                                        <div class="col-12">
                                            <a href="<?php echo "singleProductView.php?id=" . ($selected_data["product_id"]); ?>" class="btn btn-primary shadow-0 w-50" type="button">Buy this</a>
                                            <a href="#!" class="btn btn-light border px-2 pt-2 icon-hover"><i class="fa fa-shopping-cart fa-lg mx-1"></i></a>
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