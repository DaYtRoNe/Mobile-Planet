<?php

require "connection.php";

$search_txt = $_POST["t"];
$category = $_POST["cat"];
$subcategory = $_POST["subcat"];
$brand = $_POST["b"];
$model = $_POST["mo"];
$condition = $_POST["con"];
$color = $_POST["col"];
$from = $_POST["pf"];
$to = $_POST["pt"];
$sort = $_POST["s"];

$query = "SELECT * FROM `product` 
INNER JOIN `sub_category` 
ON product.sub_category_subcat_id = sub_category.subcat_id 
INNER JOIN `category` 
ON sub_category.category_cat_id = category.cat_id 
INNER JOIN `status` 
ON product.status_status_id = status.status_id 
INNER JOIN `condition` 
ON product.condition_condition_id = condition.condition_id
INNER JOIN `model` 
ON product.model_model_id = model.model_id";

$status = 0;

if ($sort == 0) {

    if (!empty($search_txt)) {
        $query .= " WHERE `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= " WHERE `category_cat_id`='" . $category . "'";
        $status = 1;
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    if ($subcategory != 0 && $status == 0) {
        $query .= " WHERE `subcat_id`='" . $subcategory . "'";
        $status = 1;
    } else if ($subcategory != 0 && $status != 0) {
        $query .= " AND `subcat_id`='" . $subcategory . "'";
    }

    if ($brand != 0 && $status == 0) {
        $query .= " WHERE `brand_brand_id`='" . $brand . "'";
        $status = 1;
    } else if ($brand != 0 && $status != 0) {
        $query .= " AND `brand_brand_id`='" . $brand . "'";
    }

    if ($model != 0 && $status == 0) {
        $query .= " WHERE `model_id`='" . $model . "'";
        $status = 1;
    } else if ($model != 0 && $status != 0) {
        $query .= " AND `model_id`='" . $model . "'";
    }

    if ($condition != 0 && $status == 0) {
        $query .= " WHERE `condition_condition_id`='" . $condition . "'";
        $status = 1;
    } else if ($condition != 0 && $status != 0) {
        $query .= " AND `condition_condition_id`='" . $condition . "'";
    }

    if ($color != 0 && $status == 0) {
        $query .= " WHERE `color_clr_id`='" . $color . "'";
        $status = 1;
    } else if ($color != 0 && $status != 0) {
        $query .= " AND `color_clr_id`='" . $color . "'";
    }

    if (!empty($from) && empty($to)) {
        if ($status == 0) {
            $query .= " WHERE `price` >= '" . $from . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` >= '" . $from . "'";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status == 0) {
            $query .= " WHERE `price` <= '" . $to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` <= '" . $to . "'";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status == 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "'";
        }
    }
} else if ($sort == 1) {

    if (!empty($search_txt)) {
        $query .= " WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `price` ASC";
        $status = 1;
    }
} else if ($sort == 2) {

    if (!empty($search_txt)) {
        $query .= " WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `price` DESC";
        $status = 1;
    }
} else if ($sort == 3) {

    if (!empty($search_txt)) {
        $query .= " WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `qty` ASC";
        $status = 1;
    }
} else if ($sort == 4) {

    if (!empty($search_txt)) {
        $query .= " WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `qty` DESC";
        $status = 1;
    }
}

?>

<div class="row">
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

            if ($selected_num == 0) {
            ?>
                <div class="row">
                    <div class="offset-lg-1 col-12 col-lg-10 text-center">
                        <div class="row">
                            <div class="offset-5 col-2 mt-5">
                                <span class="fw-bold text-black-50"><i class="bi bi-tools h1" style="font-size: 100px;"></i></span>
                            </div>
                            <div class="offset-3 col-6 mt-3 mb-5">
                                <span class="h1 text-black-50 fw-bold">OOPS <br> No Result Found...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {

                for ($x = 0; $x < $selected_num; $x++) {
                    $selected_data = $selected_rs->fetch_assoc();

                    $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                    $product_img_data = $product_img_rs->fetch_assoc();

                ?>

                    <!-- ------new card------- -->

                    <div class="col-lg-3 col-md-6 col-sm-6 my-3">
                        <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                            <div class="px-2" style="height: 50px;">
                                <div class="d-flex justify-content-between">

                                    <?php

                                    if ($selected_data["condition_id"] == 1) {
                                    ?>
                                        <h6><span class="badge bg-success pt-1 mt-3 ms-2 text-white">New</span></h6>
                                    <?php
                                    } else if ($selected_data["condition_id"] == 2) {
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

                    <!-- ------new card------- -->

            <?php
                }
            }
            ?>


        </div>
    </div>

    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($pageno <= 1) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="advancedSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                    } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php

                for ($y = 1; $y <= $number_of_pages; $y++) {
                    if ($y == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="advancedSearch(<?php echo ($y); ?>);"><?php echo $y; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="advancedSearch(<?php echo ($y); ?>);"><?php echo $y; ?></a>
                        </li>
                <?php
                    }
                }

                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="advancedSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                    } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</div>