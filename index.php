<?php

session_start();

require "connection.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Mobile Planet | Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="resources/logo.svg" />
</head>

<?php
if (isset($_SESSION["u"])) {
?>

  <body class="vh-100">
  <?php
} else {
  ?>

    <body class="vh-100" onload="popUp();">
    <?php
  }
    ?>

    <?php
    require "header.php";
    // require "popup.php";
    ?>

    <div class="container-fluid mt-6">
      <div class="row">
        <div class="offset-lg-1 col-4 col-lg-1 logo" style="height: 65px;"></div>
        <div class="offset-lg-1 col-lg-6 col-md-12 col-12">
          <div class="mb-3 mt-3 float-center">
            <div class="row">
              <div class="col-9">
                <input type="text" class="form-control rounded-4" id="kw" placeholder="Search..." aria-label="Text input with dropdown button" onkeyup="basicSearch(0);">
              </div>
              <div class="col-3">
                <select class="form-select rounded-4" id="c" style="max-width: 155px;">
                  <option value="0">All Categories</option>
                  <?php
                  $category_rs = Database::search("SELECT * FROM `category`");
                  $category_num = $category_rs->num_rows;

                  for ($i = 0; $i < $category_num; $i++) {
                    $category_data = $category_rs->fetch_assoc();
                  ?>
                    <option value="<?php echo $category_data["cat_id"] ?>">
                      <?php echo $category_data["cat_name"] ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="offset-lg-1 col-lg-2 mt-lg-3 d-flex d-lg-block justify-content-center">
          <a href="advancedSearch.php" class="btn btn-outline-primary rounded-4">Advanced Search</a>
        </div>
      </div>
    </div>

    <hr />

    <!-- Carousel -->
    <div class="container my-5" id="basicSearchResult">
      <div class="row">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-mdb-ride="carousel">
          <div class="carousel-inner rounded-5">
            <div class="carousel-item active">
              <img src="resources/slider_Images/samsung.png" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Embark on a stellar shopping journey at ‘Mobile Planet.</h5>
                <p>Explore the universe of tech wonders—where every purchase ignites a cosmic spark! 🌠🛒📱</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="resources/slider_Images/cup_camera_phone_145919_1280x720.jpg" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Capture life’s moments with precision</h5>
                <p>Enjoy 15% off on our latest smartphones. Shop now and elevate your tech game!</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="resources/slider_Images/hand_phone_photo_202405_1280x720.jpg" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Unlock breathtaking views with our cutting-edge smartphone cameras</h5>
                <p>Explore the world through your lens and discover the magic of photography.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr />

      <!-- Products -->
      <?php
      $c_rs = Database::search("SELECT * FROM `category`");
      $c_num = $c_rs->num_rows;

      for ($y = 0; $y < $c_num; $y++) {
        $c_data = $c_rs->fetch_assoc();
        $cat = $c_data["cat_id"];
      ?>
        <div class="col-12 mt-3 mb-3 bg-warning-subtle rounded-3 px-3">
          <label class="text-decoration-none text-black fs-3 fw-bold">
            <?php echo $c_data["cat_name"]; ?>
          </label>&nbsp;&nbsp;
          <a href="#" class="text-decoration-none text-black fs-6" onclick="seeAll(0,<?php echo $c_data['cat_id']; ?>);">See All &nbsp;&rarr;</a>
        </div>

        <div class="row">
          <?php
          $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `sub_category` ON product.sub_category_subcat_id = sub_category.subcat_id 
                                        INNER JOIN `category` ON sub_category.category_cat_id = category.cat_id INNER JOIN `status` ON product.status_status_id = status.status_id 
                                        INNER JOIN `condition` ON product.condition_condition_id = condition.condition_id 
                                        WHERE `status_id`='1' AND `cat_id` = '" . $c_data['cat_id'] . "' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0");

          $product_num = $product_rs->num_rows;

          for ($x = 0; $x < $product_num; $x++) {
            $product_data = $product_rs->fetch_assoc();
          ?>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card px-4 border shadow mb-4 mb-lg-0">
                <div class="px-2" style="height: 50px;">
                  <div class="d-flex justify-content-between">
                    <?php
                    if ($product_data["condition_condition_id"] == 1) {
                    ?>
                      <h6><span class="badge bg-success pt-1 mt-3 ms-2 text-white">New</span></h6>
                    <?php
                    } else if ($product_data["condition_condition_id"] == 2) {
                    ?>
                      <h6><span class="badge bg-warning pt-1 mt-3 ms-2 text-dark">Used</span></h6>
                    <?php
                    } else {
                    ?>
                      <h6><span class="badge bg-danger pt-1 mt-3 ms-2 text-light">Recondition</span></h6>
                    <?php
                    }
                    ?>
                    <a href="#"><i class="fas fa-heart text-danger fa-lg float-end pt-2 m-2" onclick="addWatchlist(<?php echo $product_data['id']; ?>);"></i></a>
                  </div>
                </div>
                <a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>" class="">
                  <?php
                  $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["id"] . "'");
                  $img_data = $img_rs->fetch_assoc();
                  ?>
                  <img src="<?php echo $img_data["img_path"] ?>" class="card-img-top rounded-2" />
                </a>
                <div class="card-body d-flex flex-column pt-3 border-top">
                  <a href="#" class="nav-link"><?php echo $product_data["title"]; ?></a>
                  <div class="price-wrap mb-2">
                    <?php
                    $price = $product_data["price"];
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
                      <a href="#" class="btn btn-outline-primary w-100 rounded-3" onclick="homeaddtocart(<?php echo $product_data['id']; ?>);">Add to cart</a>
                    </div>
                    <div class="pt-2 px-0 pb-0 mt-auto">
                      <a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>" class="btn btn-outline-success w-100 rounded-3">Buy now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      <?php
      }
      ?>
    </div>
    <!-- Products -->

    
    <section class="mt-5" style="background-color: #f5f5f5;">
      <div class="container text-dark pt-3">
        <header class="pt-4 pb-3">
          <h3 class="fw-bold text-decoration-underline">Why choose us</h3>
        </header>

        <div class="row mb-4">
          <div class="col-lg-4 col-md-6">
            <figure class="d-flex align-items-center mb-4">
              <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                <i class="fas fa-camera-retro fa-2x fa-fw text-primary floating"></i>
              </span>
              <figcaption class="info">
                <h5 class="title fw-bold">Reasonable prices</h5>
                <p>Unlock unbeatable deals without compromising your wallet, because saving money should never mean sacrificing quality.</p>
              </figcaption>
            </figure>
            
          </div>
          
          <div class="col-lg-4 col-md-6">
            <figure class="d-flex align-items-center mb-4">
              <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                <i class="fas fa-star fa-2x fa-fw text-primary floating"></i>
              </span>
              <figcaption class="info">
                <h5 class="title fw-bold">Best quality</h5>
                <p> Elevate your experience with products crafted for excellence. We believe in quality that speaks louder than words.</p>
              </figcaption>
            </figure>
            
          </div>
         
          <div class="col-lg-4 col-md-6">
            <figure class="d-flex align-items-center mb-4">
              <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                <i class="fas fa-plane fa-2x fa-fw text-primary floating"></i>
              </span>
              <figcaption class="info">
                <h5 class="title fw-bold">Islandwide delivery</h5>
                <p>From city lights to coastal retreats, we bring the joy of shopping to your doorstep, no matter where you are on this beautiful country.</p>
              </figcaption>
            </figure>
            
          </div>
          
          <div class="col-lg-4 col-md-6">
            <figure class="d-flex align-items-center mb-4">
              <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                <i class="fas fa-users fa-2x fa-fw text-primary floating"></i>
              </span>
              <figcaption class="info">
                <h5 class="title fw-bold">Customer satisfaction</h5>
                <p> Your smile is our success meter. We're not just delivering products; we're delivering happiness tailored to your satisfaction.</p>
              </figcaption>
            </figure>
           
          </div>
         
          <div class="col-lg-4 col-md-6">
            <figure class="d-flex align-items-center mb-4">
              <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                <i class="fas fa-thumbs-up fa-2x fa-fw text-primary floating"></i>
              </span>
              <figcaption class="info">
                <h5 class="title fw-bold">Happy customers</h5>
                <p>Join a community of delighted shoppers who have experienced the seamless blend of top-notch service and delightful products.</p>
              </figcaption>
            </figure>
            
          </div>
          
          <div class="col-lg-4 col-md-6">
            <figure class="d-flex align-items-center mb-4">
              <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                <i class="fas fa-box fa-2x fa-fw text-primary floating"></i>
              </span>
              <figcaption class="info">
                <h5 class="title fw-bold">Thousand items</h5>
                <p> Explore a universe of choices. With a diverse catalog of a thousand items, there's something for every taste and need.</p>
              </figcaption>
            </figure>
            
          </div>
          
        </div>
      </div>
      
    </section>

    <?php require "footer.php"; ?>

    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
    <script src="script.js"></script>
    </body>

</html>