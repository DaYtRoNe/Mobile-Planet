<?php
session_start();
require "connection.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Phone Shop | Advanced Search</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body class=" bg-body-secondary">

    <div class="container mt-6">
        <div class="row">

            <div class="col-12 bg-body mb-2">
                <?php include "header.php"; ?>
            </div>

            <div class="col-12 mb-2">
                <div class="row">
                    <div class="offset-lg-4 col-12 col-lg-4">
                        <div class="row d-flex">
                            <div class="col-2">
                                <div class="logo align-items-center justify-content-center" style="height: 80px;"></div>
                            </div>
                            <div class="col-10 text-center align-items-center justify-content-center">
                                <P class="fs-1 text-black fw-bold mt-3 pt-2">Advanced Search</P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mx-auto col-md-12 mb-3 bg-body rounded card shadow-5-strong">
                <div class="row">

                    <div class="offset-lg-1 col-12 col-lg-10">
                        <div class="row">
                            <div class="col-12 col-lg-10 mt-3 mb-1">
                                <input type="text" class="form-control  rounded-4" placeholder="Type keyword to search..." id="t"/>
                            </div>
                            <div class="col-12 col-lg-2 mt-3 mb-1 d-grid">
                                <button class="btn btn-primary  rounded-4" onclick="advancedSearch(0);">Search</button>
                            </div>
                            <div class="col-12">
                                <hr class="border border-3 border-primary">
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-12 col-lg-10">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">

                                    <div class="col-12 col-lg-3 mb-3">
                                        <select class="form-select" id="category">
                                            <option value="0">Select Category</option>
                                            <?php
                                            $category_rs = Database::search("SELECT * FROM `category`");
                                            $category_num = $category_rs->num_rows;

                                            for ($i = 0; $i < $category_num; $i++) {
                                                $category_data = $category_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $category_data["cat_id"] ?>"><?php echo $category_data["cat_name"] ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-3 mb-3">
                                        <select class="form-select" id="subcat">
                                            <option value="0">Select Sub Category</option>
                                            <?php
                                            $sub_category_rs = Database::search("SELECT * FROM `sub_category`");
                                            $sub_category_num = $sub_category_rs->num_rows;

                                            for ($i = 0; $i < $sub_category_num; $i++) {
                                                $sub_category_data = $sub_category_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $sub_category_data["subcat_id"] ?>"><?php echo $sub_category_data["subcat_name"] ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-3 mb-3">
                                        <select class="form-select" id="brand">
                                            <option value="0">Select Brand</option>
                                            <?php
                                            $brand_rs = Database::search("SELECT * FROM `brand`");
                                            $brand_num = $brand_rs->num_rows;

                                            for ($i = 0; $i < $brand_num; $i++) {
                                                $brand_data = $brand_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $brand_data["brand_id"] ?>"><?php echo $brand_data["brand_name"] ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-3 mb-3">
                                        <select class="form-select" id="m">
                                            <option value="0">Select Model</option>
                                            <?php
                                            $model_rs = Database::search("SELECT * FROM `model`");
                                            $model_num = $model_rs->num_rows;

                                            for ($i = 0; $i < $model_num; $i++) {
                                                $model_data = $model_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $model_data["model_id"] ?>"><?php echo $model_data["model_name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <select class="form-select" id="c2">
                                            <option value="0">Select Condition</option>
                                            <?php
                                            $condition_rs = Database::search("SELECT * FROM `condition`");
                                            $condition_num = $condition_rs->num_rows;

                                            for ($i = 0; $i < $condition_num; $i++) {
                                                $condition_data = $condition_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $condition_data["condition_id"] ?>"><?php echo $condition_data["condition_name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <select class="form-select" id="c3">
                                            <option value="0">Select Colour</option>
                                            <?php
                                            $color_rs = Database::search("SELECT * FROM `color`");
                                            $color_num = $color_rs->num_rows;

                                            for ($i = 0; $i < $color_num; $i++) {
                                                $color_data = $color_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $color_data["clr_id"] ?>"><?php echo $color_data["clr_name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <input type="number" class="form-control" min="0" id="pf" placeholder="Price From..."/>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <input type="number" class="form-control" min="0" id="pt" placeholder="Price To..."/>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 mx-auto col-md-12 bg-body rounded mb-3 card shadow-5-strong">
                <div class="row">
                    <div class="offset-8 col-4 mt-2 mb-2">
                        <select class="form-select border border-top-0 border-start-0 border-end-0 border-2 border-dark" id="s">
                            <option value="0">SORT BY</option>
                            <option value="1">PRICE LOW TO HIGH</option>
                            <option value="2">PRICE HIGH TO LOW</option>
                            <option value="3">QUANTITY LOW TO HIGH</option>
                            <option value="4">QUANTITY HIGH TO LOW</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="container">
            <div class="col-12 mx-auto col-md-12 bg-body-secondary rounded mb-3 card shadow-5-strong" id="view_area">
                <div class="row">
                    <div class="offset-lg-1 col-12 col-lg-10 text-center">
                        <div class="row">
                            <div class="offset-5 col-2 mt-5">
                                <span class="fw-bold text-black-50"><i class="bi bi-search h1" style="font-size: 100px;"></i></span>
                            </div>
                            <div class="offset-3 col-6 mt-3 mb-5">
                                <span class="h1 text-black-50 fw-bold">No Items Searched Yet...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
        <script src="script.js"></script>
</body>

</html>