<?php
session_start();
require "connection.php";

if (isset($_GET["id"])) {
  $pid = $_GET["id"];

  $user = $_SESSION["u"];

  // $product_rs = Database::search("SELECT product.id,product.price,product.qty,product.description,
  //   product.title,product.datetime_added,product.delivery_fee_colombo,product.dilivery_fee_other,condition.condition_name,
  //   product.sub_category_subcat_id,product.model_has_brand_id,product.color_clr_id,product.status_status_id,color.clr_name,
  //   product.condition_condition_id,product.users_email,sub_category.subcat_name,status.status_name,sub_category.subcat_name,
  //   model.model_name AS mname,brand.brand_name AS bname FROM `product` INNER JOIN `model_has_brand` ON 
  //   model_has_brand.id=product.model_has_brand_id INNER JOIN `brand` ON 
  //   brand.brand_id=model_has_brand.brand_brand_id INNER JOIN `model` ON 
  //   model.model_id=model_has_brand.model_model_id INNER JOIN `sub_category` ON 
  //   product.sub_category_subcat_id = sub_category.subcat_id INNER JOIN `status` ON 
  //   product.status_status_id = status.status_id INNER JOIN `color` ON 
  //   product.color_clr_id = color.clr_id INNER JOIN `condition` ON 
  //   product.condition_condition_id = condition.condition_id 
  //   WHERE product.id='" . $pid . "'");

  $product_rs = Database::search("SELECT * FROM `product` 
  INNER JOIN `sub_category` ON product.sub_category_subcat_id = sub_category.subcat_id 
  INNER JOIN `color` ON product.color_clr_id = color.clr_id 
  INNER JOIN `status` ON product.status_status_id = status.status_id 
  INNER JOIN `condition` ON product.condition_condition_id = condition.condition_id 
  INNER JOIN `model` ON product.model_model_id = model.model_id 
  INNER JOIN `brand`  ON model.brand_brand_id = brand.brand_id 
  WHERE product.id='" . $pid . "'");

  $product_num = $product_rs->num_rows;
  if ($product_num == 1) {
    $product_data = $product_rs->fetch_assoc();

?>

    <!DOCTYPE html>
    <html>

    <head>

      <meta charset="utf-8">
      <title>Mobile Planet | <?php echo $product_data["title"]; ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="style.css" />

      <link rel="icon" href="resources/logo.svg" />

    </head>


    <body>

      <?php require "header.php"; ?>
      <?php require "popup.php"; ?>

      <div class="mt-6 py-5">
        <div class="ms-4 col-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $product_data["title"]; ?></li>
            </ol>
          </nav>
        </div>
        <div class="container">
          <div class="row gx-5">
            <aside class="col-lg-6">

              <?php

              $pimg_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
              $pimg_num = $pimg_rs->num_rows;

              ?>

              <div class="border rounded-4 mb-3 d-flex justify-content-center">
                <?php
                if ($pimg_num != 0) {
                  $pimg_data = $pimg_rs->fetch_assoc();
                  $first_img_path = $pimg_data["img_path"];
                ?>
                  <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="<?php echo $first_img_path; ?>" id="product-image" />
                <?php
                } else {
                  $first_img_path = "resources/empty.svg";
                ?>
                  <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="<?php echo $first_img_path; ?>" id="product-image" />
                <?php
                }
                ?>
              </div>

              <div class="d-flex justify-content-center mb-3">

                <?php

                $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
                $img_num = $img_rs->num_rows;
                $img_list = array();

                if ($img_num != 0) {
                  for ($x = 0; $x < $img_num; $x++) {
                    $img_data = $img_rs->fetch_assoc();
                    $img_path = $img_data["img_path"];
                ?>

                    <img width="60" height="60" class="border mx-1 rounded-2 img-thumbnail thumbnail" src="<?php echo $img_path; ?>" onmouseover="changeImage('<?php echo $img_path; ?>')" />

                  <?php

                  }
                } else {
                  ?>
                  <img width="60" height="60" class="border mx-1 rounded-2 img-thumbnail thumbnail" src="resources/empty.svg" onmouseover="changeImage('resources/empty.svg')" />
                  <img width="60" height="60" class="border mx-1 rounded-2 img-thumbnail thumbnail" src="resources/empty.svg" onmouseover="changeImage('resources/empty.svg')" />
                <?php
                }

                ?>

              </div>

            </aside>
            <main class="col-lg-6">
              <div class="ps-lg-3 p-3">
                <h2 class="title text-dark"><?php echo $product_data["title"]; ?></h2>
                <div class="d-flex flex-row my-2">
                  <div class="text-warning mb-1 me-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="ms-1">4.5</span>
                  </div>
                  <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154 orders</span>
                  <span class="text-success ms-2"><?php echo $product_data["status_name"]; ?></span>
                </div>

                <?php

                $price = $product_data["price"];
                $add = ($price / 100) * 10;
                $new_price = $price + $add;
                $diff = $new_price - $price;
                $percent = ($diff / $price) * 100;

                ?>

                <div class="product-price">
                  <p class="fw-bold h4">Old Price: <span class="text-danger text-decoration-line-through">Rs. <?php echo $new_price; ?>.00</span></p>
                  <p class="fw-bold h4">New Price: <span class="text-primary">Rs .<?php echo $price; ?>.00 <span class="text-success fw-bolder h3"> (<?php echo $percent; ?>%)</span></span></p>
                </div>

                <div class="mb-2">
                  <span class="text-black-50 h4">Save Rs. <?php echo $diff; ?>.00</span>
                </div>

                <div class="row">
                  <dt class="col-3">Type:</dt>
                  <dd class="col-9"><?php echo $product_data["subcat_name"]; ?></dd>

                  <dt class="col-3">Model:</dt>
                  <dd class="col-9"><?php echo $product_data["model_name"]; ?></dd>

                  <dt class="col-3">Color</dt>
                  <dd class="col-9"><?php echo $product_data["clr_name"]; ?></dd>

                  <dt class="col-3">Condition</dt>
                  <dd class="col-9"><?php echo $product_data["condition_name"]; ?></dd>

                  <dt class="col-3">Brand</dt>
                  <dd class="col-9"><?php echo $product_data["brand_name"]; ?></dd>

                  <dt class="col-3">Available</dt>
                  <?php

                  if ($product_data["qty"] == 0) {
                  ?>
                    <dd class="col-9 text-decoration-line-through text-secondary">Out of Stock</dd>
                  <?php
                  } else if ($product_data["qty"] > 0) {
                  ?>
                    <dd class="col-9"><?php echo $product_data["qty"]; ?></dd>
                  <?php
                  }

                  ?>
                </div>

                <hr />

                <?php
                $user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $product_data["users_email"] . "'");
                $user_data = $user_rs->fetch_assoc();
                ?>

                <div class="row mb-4">
                  <div class="col-md-4 col-6 mb-3">
                    <label class="mb-2 d-block">Quantity</label>
                    <div class="input-group mb-3" style="width: 170px;">
                      <button class="btn btn-white border border-secondary px-3" type="button" onclick='qty_dec();'>
                        <i class="fas fa-minus"></i>
                      </button>
                      <input type="text" class="form-control text-center border border-secondary" style="outline: none;" pattern="[1-9]" value="1" onkeyup='check_value(<?php echo $product_data["qty"]; ?>);' id="qty_input"  disabled />
                      <button class="btn btn-white border border-secondary px-3" type="button" onclick='qty_inc(<?php echo $product_data["qty"]; ?>);'>
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="row mb-4 bg-body-secondary rounded-3">
                  <div class="col-3 col-lg-2 d-flex border-end border-2 border-danger justify-content-center">
                    <img src="resources/pricetag.png" />
                  </div>
                  <div class="col-9 col-lg-10">
                    <span class="fs-5 text-danger fw-bold">
                      Stand a chance to get 5% discount by using VISA or MASTER
                    </span>
                  </div>
                </div>
                <?php

                  if ($product_data["qty"] == 0) {
                  ?>
                    <button class="btn btn-warning shadow-0" type="submit" disabled>Pay Now</button>
                  <?php
                  } else if ($product_data["qty"] > 0) {
                  ?>
                    <button class="btn btn-warning shadow-0" type="submit" id="payhere-payment" onclick="paynow(<?php echo $pid; ?>);">Pay Now</button>
                  <?php
                  }

                  ?>
                
                <a href="#" class="btn btn-primary shadow-0" onclick="addtocart(<?php echo $product_data['id']; ?>);"> <i class="me-1 fa fa-shopping-basket"></i> Add to cart </a>
                <a href="<?php echo "addWatchlist.php?id=" . ($product_data["id"]); ?>" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i class="me-1 fa fa-heart fa-lg"></i> Save </a>
              </div>
            </main>
          </div>
        </div>
      </div>

      <section class="bg-light border-top py-4">
        <div class="container">
          <div class="row gx-4">
            <div class="col-lg-8 mb-4">
              <div class="border rounded-2 px-3 py-2 bg-white">

                <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill shadow bg-secondary-subtle text-black border border-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="changeButtonColor(this)">Description</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill shadow bg-white text-primary border border-4" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false" onclick="changeButtonColor(this)">Warrenty</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill shadow bg-white text-primary border border-4" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" onclick="changeButtonColor(this)">Return Policy</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill shadow bg-white text-primary border border-4" id="pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#pills-disabled" type="button" role="tab" aria-controls="pills-disabled" aria-selected="false" onclick="changeButtonColor(this)">Feedbacks</button>
                  </li>
                </ul>
                <div class="tab-content bg-secondary-subtle p-2 rounded-3" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <p><?php echo $product_data['description']; ?></p>
                  </div>
                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <p>6 Months Warrenty</p>
                  </div>
                  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">1 Months Return Policy</div>
                  <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">
                    <div class="row border border-1 border-dark rounded me-0">

                      <div class="col-10 mt-1 mb-1 ms-0">John Doe</div>
                      <div class="col-2 mt-1 mb-1 me-0">
                        <span class="badge bg-success">Positive</span>
                      </div>

                      <div class="col-12">
                        <b>
                          Perfect
                        </b>
                      </div>
                      <div class="offset-6 col-6 text-end">
                        <label class="form-label fs-6 text-black-50">2023.09.13</label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-lg-4">
              <div class="px-0 rounded-4 shadow-0">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Similar products</h5>

                    <?php

                    $product_rs = Database::search("SELECT * FROM `product` WHERE `sub_category_subcat_id`='" . $product_data['sub_category_subcat_id'] . "' AND `status_status_id`='1' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0");

                    $product_num = $product_rs->num_rows;

                    for ($x = 0; $x < $product_num; $x++) {
                      $product_data = $product_rs->fetch_assoc();

                    ?>

                      <div class="d-flex mb-3 p-1 bg-white rounded-3 border">
                        <a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>" class="me-3">

                          <?php

                          $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data['id'] . "'");
                          $img_data = $img_rs->fetch_assoc();

                          ?>

                          <img src="<?php echo $img_data["img_path"]; ?>" style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                        </a>
                        <div class="info">
                          <a href="#" class="nav-link mb-1">
                            <?php echo $product_data["title"]; ?> </br>
                            Available : <?php echo $product_data["qty"]; ?>
                          </a>
                          <strong class="text-dark">RS. <?php echo $product_data["price"]; ?>.00</strong>
                        </div>
                      </div>

                    <?php
                    }
                    ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php require "footer.php"; ?>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
      <script src="script.js"></script>
      <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
      
    </body>

    </html>

  <?php

  } else {
  ?> <script>
      alert("Something went wrong");
    </script> <?php
            }
          }


              ?>