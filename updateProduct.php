<?php
session_start();
require "connection.php";

if (isset($_SESSION["a"])) {
    if (isset($_SESSION["p"])) {
        $product = $_SESSION["p"];
?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Mobile Planet | Update Product</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
            <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="style.css">

            <link rel="icon" href="resources/logo.svg" />
        </head>

        <body style="background-image: linear-gradient(to right, #d7d2cc 0%, #304352 100%);">

            <?php require "adminNavBar.php" ?>
            <?php require "popup.php" ?>

            <div class="container my-5">
                <div class="card mt-6 shadow-6-strong">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Update Product</h5>
                    </div>
                    <div class="col-12 p-2 d-none" id="adpmsgdiv">
                        <div class="alert alert-danger" role="alert" id="adpmsg"></div>
                    </div>
                    <div class="card-body">
                        <div>

                            <div class="mb-3">
                                <label class="form-label" for="title">Add new Product Title</label>
                                <input type="text" class="form-control" id="title" value="<?php echo ($product["title"]); ?>" placeholder="Enter product title">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="productCondition" class="form-label">Currunt product images</label>
                                    <div class="row">
                                        <?php

                                        $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $product["id"] . "'");
                                        $img_num = $img_rs->num_rows;

                                        for ($i = 0; $i < $img_num; $i++) {
                                            $img_data = $img_rs->fetch_assoc();
                                        ?>

                                            <div class="col-6 col-md-3">
                                                <img src="<?php echo ($img_data["img_path"]); ?>" class="upimg" alt="">
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="clr">Select Product Color</label>
                                    <select class="form-select" id="clr">
                                        <option value="0">Select Color</option>
                                        <?php

                                        $clr_rs = Database::search("SELECT * FROM `color`");
                                        $clr_num = $clr_rs->num_rows;

                                        for ($i = 0; $i < $clr_num; $i++) {
                                            $clr_data = $clr_rs->fetch_assoc();
                                            if ($product["color_clr_id"] == $clr_data["clr_id"]) {
                                        ?>
                                                <option value="<?php echo $clr_data["clr_id"]; ?>" selected><?php echo $clr_data["clr_name"]; ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?php echo $clr_data["clr_id"]; ?>"><?php echo $clr_data["clr_name"]; ?></option>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                    <div class="mt-2">
                                        <input type="text" class="form-control" placeholder="Add new Color" id="clr_in" />
                                        <button type="button" class="btn btn-dark btn-sm mt-2" id="button-addon2" onclick="clrup();">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="qty">Update Product Quantity</label>
                                    <input type="number" class="form-control" value="<?php echo ($product["qty"]); ?>" min="0" id="qty" placeholder="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="cost">Update Cost Per Item (Rs.)</label>
                                    <input type="number" class="form-control" id="cost" value="<?php echo ($product["price"]); ?>" placeholder="0.00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="dwc">Update Delivery Cost Within Colombo (Rs.)</label>
                                    <input type="number" class="form-control" id="dwc" value="<?php echo ($product["delivery_fee_colombo"]); ?>" placeholder="0.00">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="doc">Update Delivery Cost out of Colombo (Rs.)</label>
                                    <input type="number" class="form-control" id="doc" value="<?php echo ($product["dilivery_fee_other"]); ?>" placeholder="0.00">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="desc">Update Product Description</label>
                                <textarea class="form-control" id="desc" rows="3" placeholder="Enter product description"><?php echo ($product["description"]); ?></textarea>
                            </div>
                            <!-- <div class="mb-3 d-none">
                            <label class="form-label">Add Product Images</label><br>
                            <small>Please select all images at once.</small>
                            <div class="d-flex flex-wrap">
                                <div class="p-2">
                                    <img src="resources/upload-icon.png" class="img-fluid" style="width: 245px;" id="img0" />
                                </div>
                                <div class="p-2">
                                    <img src="resources/upload-icon.png" class="img-fluid" style="width: 245px;" id="img1" />
                                </div>
                                <div class="p-2">
                                    <img src="resources/upload-icon.png" class="img-fluid" style="width: 245px;" id="img2" />
                                </div>
                                <div class="p-2">
                                    <img src="resources/upload-icon.png" class="img-fluid" style="width: 245px;" id="img3" />
                                </div>
                                <div class="p-2">
                                    <input type="file" class="d-none" id="imageuploader" multiple />
                                    <label for="imageuploader" class="btn btn-info" onclick="changeProductImage();">Upload Images</label>
                                </div>
                            </div>
                        </div> -->

                            <!--Test -------------------------------------------------------------------------------------------------- -->

                            <div class="mb-3">
                                <label class="form-label">Add Product Images</label><br>
                                <small class="text-danger mb-2">First image will be the product preview image</small>

                                <?php
                                $img = array();
                                $img[1] = "resourses/addproductimg.svg";
                                $img[2] = "resourses/addproductimg.svg";
                                $img[3] = "resourses/addproductimg.svg";
                                $img[4] = "resourses/addproductimg.svg";
                                $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product["id"] . "'");
                                $img_num = $img_rs->num_rows;
                                for ($x = 1; $x <= $img_num; $x++) {
                                    $img_data = $img_rs->fetch_assoc();
                                    $img[$x] = $img_data["img_path"];
                                }
                                ?>

                                <div class="d-flex flex-wrap">
                                    <div class="p-2">
                                        <input type="file" class="form-control-file" id="file1" onchange="fileSelect(event,1)"><br>
                                        <img src="<?php echo $img[1]; ?>" class="img-fluid" style="width: 235px;" id="productImage1" />
                                    </div>
                                    <div class="p-2">
                                        <input type="file" class="form-control-file" id="file2" onchange="fileSelect(event,2)"><br>
                                        <img src="<?php echo $img[2]; ?>" class="img-fluid" style="width: 235px;" id="productImage2" />
                                    </div>
                                    <div class="p-2">
                                        <input type="file" class="form-control-file" id="file3" onchange="fileSelect(event,3)"><br>
                                        <img src="<?php echo $img[3]; ?>" class="img-fluid" style="width: 235px;" id="productImage3" />
                                    </div>
                                    <div class="p-2">
                                        <input type="file" class="form-control-file" id="file4" onchange="fileSelect(event,4)"><br>
                                        <img src="<?php echo $img[4]; ?>" class="img-fluid" style="width: 235px;" id="productImage4" />
                                    </div>
                                </div>
                            </div>
                            <!--Test -------------------------------------------------------------------------------------------------- -->
                            <button class="btn btn-primary" onclick="updateProduct();">Update Product</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php include "footer.php"; ?>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
            <script src="script.js"></script>
        </body>

        </html>

    <?php
    } else {
        header("Location:admin_login.php");
    }
} else {
    header("location:admin_login.php");
}
