<?php

session_start();
require "connection.php";

if (isset($_SESSION["a"])) {

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mobile Planet | Add Product</title>
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
                    <h5 class="mb-0">Add New Product</h5>
                </div>
                <div class="col-12 p-2 d-none" id="adpmsgdiv">
                    <div class="alert alert-danger" role="alert" id="adpmsg"></div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" for="category">Select Product Category</label>
                                <select class="form-select" id="category" onchange="loadBrands(); loadsubcategory(); loadModel();">
                                    <option value="0">Select Category</option>
                                    <?php

                                    $category_rs = Database::search("SELECT * FROM `category`");
                                    $category_num = $category_rs->num_rows;

                                    for ($i = 0; $i < $category_num; $i++) {
                                        $category_data = $category_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $category_data["cat_id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label" for="subcat">Select Product Sub Category</label>
                                <select class="form-select" id="subcat">
                                    <option value="0">Select Sub Category</option>
                                    <?php

                                    $subp_rs = Database::search("SELECT * FROM `sub_category`");
                                    $subp_num = $subp_rs->num_rows;

                                    for ($i = 0; $i < $subp_num; $i++) {
                                        $subp_data = $subp_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $subp_data["subcat_id"]; ?>"><?php echo $subp_data["subcat_name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                                <div class="mt-2">
                                    <button type="button" class="btn btn btn-dark btn-sm mt-2" data-mdb-toggle="modal" data-mdb-target="#subCModal">Add new Sub Category</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="brand">Select Product Brand</label>
                                <select class="form-select" id="brand">
                                    <option value="0">Select Brand</option>
                                    <?php

                                    $brand_rs = Database::search("SELECT * FROM `brand`");
                                    $brand_num = $brand_rs->num_rows;

                                    for ($i = 0; $i < $brand_num; $i++) {
                                        $brand_data = $brand_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $brand_data["brand_id"]; ?>"><?php echo $brand_data["brand_name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-dark btn-sm mt-2" data-mdb-toggle="modal" data-mdb-target="#brandModal">Add New Brand</button>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="model">Select Product Model</label>
                                <select class="form-select" id="model">
                                    <option value="0">Select Model</option>
                                    <?php

                                    $model_rs = Database::search("SELECT * FROM `model`");
                                    $model_num = $model_rs->num_rows;

                                    for ($i = 0; $i < $model_num; $i++) {
                                        $model_data = $model_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $model_data["model_id"]; ?>"><?php echo $model_data["model_name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-dark btn-sm mt-2" data-mdb-toggle="modal" data-mdb-target="#modelModal">Add New Model</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Add Product Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter product title">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productCondition" class="form-label">Select Product Condition</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="b" name="c" checked />
                                        <label class="form-check-label" for="b">Brand New</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="u" name="c" />
                                        <label class="form-check-label" for="u">Used</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="r" name="c" />
                                        <label class="form-check-label" for="r">Re-Condition</label>
                                    </div>
                                    <div class="row mt-2">
                                        <label class="form-label">Approved payment methods</label>
                                        <div class="col-6 col-md-3">
                                            <div class="pm pm1"></div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="pm pm2"></div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="pm pm3"></div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="pm pm5"></div>
                                        </div>
                                    </div>
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
                                    ?>

                                        <option value="<?php echo $clr_data["clr_id"]; ?>"><?php echo $clr_data["clr_name"]; ?></option>

                                    <?php
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
                                <label class="form-label" for="qty">Add Product Quantity</label>
                                <input type="number" class="form-control" value="0" min="0" id="qty" placeholder="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="cost">Cost Per Item (Rs.)</label>
                                <input type="number" class="form-control" id="cost" placeholder="0.00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="dwc">Delivery Cost Within Colombo (Rs.)</label>
                                <input type="number" class="form-control" id="dwc" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="doc">Delivery Cost out of Colombo (Rs.)</label>
                                <input type="number" class="form-control" id="doc" placeholder="0.00">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="desc">Product Description</label>
                            <textarea class="form-control" id="desc" rows="3" placeholder="Enter product description"></textarea>
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
                            <small class="text-danger">First image wiil be the preview image.</small>
                            <div class="d-flex flex-wrap">
                                <div class="p-2">
                                    <input type="file" class="form-control-file" id="file1" onchange="fileSelect(event,1)"><br>
                                    <img src="resources/upload-icon.png" class="img-fluid d-none d-md-block" style="width: 245px;" id="productImage1" />
                                </div>
                                <div class="p-2">
                                    <input type="file" class="form-control-file" id="file2" onchange="fileSelect(event,2)"><br>
                                    <img src="resources/upload-icon.png" class="img-fluid d-none d-md-block" style="width: 245px;" id="productImage2" />
                                </div>
                                <div class="p-2">
                                    <input type="file" class="form-control-file" id="file3" onchange="fileSelect(event,3)"><br>
                                    <img src="resources/upload-icon.png" class="img-fluid d-none d-md-block" style="width: 245px;" id="productImage3" />
                                </div>
                                <div class="p-2">
                                    <input type="file" class="form-control-file" id="file4" onchange="fileSelect(event,4)"><br>
                                    <img src="resources/upload-icon.png" class="img-fluid d-none d-md-block" style="width: 245px;" id="productImage4" />
                                </div>
                            </div>
                        </div>
                        <!--Test -------------------------------------------------------------------------------------------------- -->
                        <button class="btn btn-primary" onclick="addTest2Product();">Save Product</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>

        <!-- subCatModal -->
        <div class="modal fade" id="subCModal" tabindex="-1" aria-labelledby="subCModalLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subCModalLabel">Add New Sub Category</h5>
                        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="col-12 p-2 d-none" id="sCMmsgdiv">
                                <div class="alert alert-danger text-center h6" role="alert" id="sCMmsg"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="subCM" class="form-label">Select Category</label>
                                    <select class="form-select" id="subCM">
                                        <option value="0">Select Category</option>
                                        <?php

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        for ($i = 0; $i < $category_num; $i++) {
                                            $category_data = $category_rs->fetch_assoc();

                                        ?>

                                            <option value="<?php echo $category_data["cat_id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="newSubC" class="form-label">Add New Sub Category Name</label>
                                    <input type="text" class="form-control" id="newSubC" placeholder="Add new Sub Category">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Cansel</button>
                        <button type="button" class="btn btn-primary" onclick="addSubC();" data-mdb-ripple-init>Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- subCatModal -->

        <!-- brandModal -->
        <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="brandModalLabel">Add New Brand</h5>
                        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="col-12 p-2 d-none" id="bMmsgdiv">
                                <div class="alert alert-danger text-center h6" role="alert" id="bMmsg"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="brandM" class="form-label">Select Category</label>
                                    <select class="form-select" id="brandM">
                                        <option value="0">Select Category</option>
                                        <?php

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        for ($i = 0; $i < $category_num; $i++) {
                                            $category_data = $category_rs->fetch_assoc();

                                        ?>

                                            <option value="<?php echo $category_data["cat_id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="newBrand" class="form-label">Add New Brand Name</label>
                                    <input type="text" class="form-control" id="newBrand" placeholder="Add New Brand">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Cansel</button>
                        <button type="button" class="btn btn-primary" onclick="addBrand();" data-mdb-ripple-init>Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- brandModal -->

        <!-- modelModal -->
        <div class="modal fade" id="modelModal" tabindex="-1" aria-labelledby="modelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modelModalLabel">Add New Model</h5>
                        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="col-12 p-2 d-none" id="mMmsgdiv">
                                <div class="alert alert-danger text-center h6" role="alert" id="mMmsg"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="modelM" class="form-label">Select Category</label>
                                    <select class="form-select" id="modelM">
                                        <option value="0">Select Category</option>
                                        <?php

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        for ($i = 0; $i < $category_num; $i++) {
                                            $category_data = $category_rs->fetch_assoc();

                                        ?>

                                            <option value="<?php echo $category_data["cat_id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="modelbM" class="form-label">Select Brand</label>
                                    <select class="form-select" id="modelbM">
                                        <option value="0">Select Brand</option>
                                        <?php

                                        $brand_rs = Database::search("SELECT * FROM `brand`");
                                        $brand_num = $brand_rs->num_rows;

                                        for ($i = 0; $i < $brand_num; $i++) {
                                            $brand_data = $brand_rs->fetch_assoc();

                                        ?>

                                            <option value="<?php echo $brand_data["brand_id"]; ?>"><?php echo $brand_data["brand_name"]; ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="mt-3">
                                    <label for="newModel" class="form-label">Add New Model Name</label>
                                    <input type="text" class="form-control" id="newModel" placeholder="Add New Model">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="addModel();" data-mdb-ripple-init>Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modelModal -->

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