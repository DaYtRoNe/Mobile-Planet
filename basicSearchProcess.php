<?php

require "connection.php";

$search = $_POST["t"];
$select = $_POST["s"];
$text = str_replace(' ', '%', $search);

$query = "SELECT * FROM `product` 
INNER JOIN `sub_category` 
ON product.sub_category_subcat_id = sub_category.subcat_id 
INNER JOIN `category` 
ON sub_category.category_cat_id = category.cat_id 
INNER JOIN `status` 
ON product.status_status_id = status.status_id 
INNER JOIN `condition` 
ON product.condition_condition_id = condition.condition_id ";

if (!empty($text) && $select == 0) {

    $query .= "WHERE `title` LIKE '%" . $text . "%'";
} else if (empty($text) && $select != 0) {

    $query .= "WHERE `category_cat_id`='" . $select . "'";
} else if (!empty($text) && $select != 0) {

    $query .= "WHERE `title` LIKE '%" . $text . "%' AND `cat_id`='" . $select . "'";
}

?>

<div class="row rounded-3">
    <div class="offset-lg-1 col-12 col-lg-10 text-center">
        <div class="row justify-content-center gap-3">

            <?php

            if ("0" != $_POST["page"]) {
                $pageno = $_POST["page"];
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

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

                $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                                    `product_id`='" . $selected_data["id"] . "'");
                $product_img_data = $product_img_rs->fetch_assoc();

            ?>

                <!-- card -->

                <div class="col-lg-3 col-md-6 col-sm-6 my-3">
                    <div class="card px-4 shadow mb-4 mb-lg-0">
                        <div class="px-2" style="height: 50px;">
                            <div class="d-flex justify-content-between">

                                <?php

                                if ($selected_data["condition_condition_id"] == 1) {
                                ?>
                                    <h6><span class="badge bg-success pt-1 mt-3 ms-2 text-white">New</span></h6>
                                <?php
                                } else if ($selected_data["condition_condition_id"] == 2) {
                                ?>
                                    <h6><span class="badge bg-warning pt-1 mt-3 ms-2 text-white">Used</span></h6>
                                <?php
                                } else {
                                ?>
                                    <h6><span class="badge bg-danger-subtle pt-1 mt-3 ms-2 text-black">Recondition</span></h6>
                                <?php

                                }

                                ?>
                                <a href="#"><i class="fas fa-heart text-danger fa-lg float-end pt-2 m-2" onclick="addWatchlist(<?php echo $selected_data['id']; ?>);"></i></a>
                            </div>
                        </div>
                        <a href="<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>" class="">
                            <img src="<?php echo $product_img_data["img_path"] ?>" class="card-img-top rounded-2" />
                        </a>
                        <div class="card-body d-flex flex-column pt-3 border-top">
                            <a href="<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>" class="nav-link"><?php echo $selected_data["title"]; ?></a>
                            <div class="price-wrap mb-2">

                                <?php

                                $price = $selected_data["price"];
                                $add = ($price / 100) * 10;
                                $new_price = $price + $add;
                                $diff = $new_price - $price;
                                $percent = ($diff / $price) * 100;

                                ?>

                                <strong class="fs-5 me-2">Rs. <?php echo $price; ?>.00</strong>
                                <del class="text-danger">Rs.<?php echo $new_price; ?>.00</del>
                            </div>
                            <div class="row card-footer bg-white d-flex align-items-center">
                                <div class="pt-1 px-0 pb-0 mt-auto">
                                    <a href="#" class="btn btn-outline-primary w-100" onclick="homeaddtocart(<?php echo $selected_data['id']; ?>);">Add to cart</a>
                                </div>
                                <div class="pt-2 px-0 pb-0 mt-auto">
                                    <a href="<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>" class="btn btn-outline-success w-100">Buy now</a>
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

    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <button class="page-link bg-white border" <?php if ($pageno <= 1) {
                                                                    echo ("#");
                                                                } else {
                                                                ?> onclick="basicSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </button>
                </li>

                <?php

                for ($y = 1; $y <= $number_of_pages; $y++) {
                    if ($y == $pageno) {
                ?>
                        <li class="page-item active">
                            <button class="page-link bg-white text-primary border" onclick="basicSearch(<?php echo ($y); ?>);"><?php echo $y; ?></button>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <button class="page-link bg-white text-primary border" onclick="basicSearch(<?php echo ($y); ?>);"><?php echo $y; ?></button>
                        </li>
                <?php
                    }
                }

                ?>

                <li class="page-item">
                    <button class="page-link bg-white border" <?php if ($pageno >= $number_of_pages) {
                                                                    echo ("#");
                                                                } else {
                                                                ?> onclick="basicSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </button>
                </li>
            </ul>
        </nav>
    </div>

</div>