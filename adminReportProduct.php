<?php

session_start();
require "connection.php";

if (isset($_SESSION["a"])) {

    $product_rs =  Database::search("SELECT * FROM `product` INNER JOIN `sub_category` ON product.sub_category_subcat_id = sub_category.subcat_id
    INNER JOIN `category` ON sub_category.category_cat_id = category.cat_id INNER JOIN `model` ON product.model_model_id = model.model_id
    INNER JOIN `brand` ON model.brand_brand_id = brand.brand_id INNER JOIN `color` ON product.color_clr_id = color.clr_id
    INNER JOIN `condition` ON product.condition_condition_id = condition.condition_id ORDER BY `product`.`id` ASC");
    $product_num =  $product_rs->num_rows;

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Product Report</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body style="background-image: linear-gradient(to right, #d7d2cc 0%, #304352 100%);">

        <div class="container my-5">
            <a href="adminReport.php" class="h1"> <i class="fa-solid fa-chevron-left"></i></a>
            <div class="card mt-4 shadow">
                <div class="mt-1" id="printArea">
                    <div class="card-head my-3 text-center">
                        <h1 class=" text-decoration-underline">Product Report</h1>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover mt-2">
                            <thead class="bg-dark">
                                <tr>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Condition</th>
                                    <th>Color</th>
                                    <th>Images</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                for ($i = 0; $i < $product_num; $i++) {
                                    $product_data = $product_rs->fetch_assoc(); ?>
                                    <tr>
                                        <td><?php echo ($product_data["id"]); ?></td>
                                        <td><?php echo ($product_data["title"]); ?></td>
                                        <td><?php echo ($product_data["brand_name"]); ?></td>
                                        <td><?php echo ($product_data["cat_name"]); ?></td>
                                        <td><?php echo ($product_data["subcat_name"]); ?></td>
                                        <td><?php echo ($product_data["condition_name"]); ?></td>
                                        <td><?php echo ($product_data["clr_name"]); ?></td>
                                        <td>
                                            <div class="row d-flex">

                                                <?php

                                                $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $product_data["id"] . "'");
                                                $img_num = $img_rs->num_rows;

                                                for ($j = 0; $j < $img_num; $j++) {
                                                    $img_data = $img_rs->fetch_assoc();
                                                ?>

                                                    <div class="col-3">
                                                        <img src="<?php echo ($img_data["img_path"]); ?>" style="height:50px; width:50px;" alt="">
                                                    </div>

                                                <?php
                                                }

                                                ?>


                                            </div>
                                        </td>
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