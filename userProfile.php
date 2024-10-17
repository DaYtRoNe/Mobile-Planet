<?php
session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $email = $_SESSION["u"]["email"];
?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Mobile Planet | User Profile</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="mdb.min.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

        <link rel="icon" href="resources/logo.svg" />

    </head>

    <body class="bg-dark">

        <?php require "header.php"; ?>

        <div class="container-fluid mt-6 bg-body">
            <div class="row">

                <?php



                $details_rs = Database::search("SELECT * FROM `users` INNER JOIN `gender` ON users.gender_id=gender.id WHERE `email`='" . $email . "'");

                $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $email . "'");

                $address_rs = Database::search("SELECT * FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id=city.city_id INNER JOIN `district` 
                ON city.district_district_id=district.district_id INNER JOIN `province` ON district.province_province_id=province.province_id WHERE `users_email`='" . $email . "'");

                $details_data = $details_rs->fetch_assoc();
                $image_data = $image_rs->fetch_assoc();
                $address_data = $address_rs->fetch_assoc();

                ?>

                <div class="col-12 bg-primary upl">
                    <div class="row">

                        <div class="col-12 bg-body mt-4 mb-4 setback">
                            <div class="row g-2">

                                <div class="col-md-3 border-start border-end text-light">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5 justify-content-center upvh">

                                        <?php

                                        if (empty($image_data["path"])) {
                                        ?>
                                            <img src="resources/user_pic.jpeg" class="rounded mt-5" style="width:200px;" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $image_data["path"]; ?>" class="rounded mt-5" style="width:200px;" />
                                        <?php
                                        }

                                        ?>
                                        <br />

                                        <span class="fw-bold h3"><?php echo $details_data["fname"] . " " . $details_data["lname"] ?></span>
                                        <span class="fw-bold text-warning h5"><?php echo $details_data["email"] ?></span>

                                        <input type="file" class="d-none" id="profileImage" />
                                        <label for="profileImage" class="btn btn-primary mt-5">Update Profile Image</label>

                                    </div>
                                </div>

                                <div class="col-md-5 border-end text-light fw-bold">
                                    <div class="p-3 py-5">

                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <h2 class="fw-bold">Profile Settings</h2>
                                        </div>

                                        <div class="row mt-4">

                                            <div class="col-6">
                                                <label class="form-label  text-white">First Name</label>
                                                <input type="text" id="fname" class="form-control bg-transparent text-light dd mb-2" value="<?php echo $details_data["fname"]; ?>" />
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label text-white">Last Name</label>
                                                <input type="text" id="lname" class="form-control bg-transparent text-light dd" value="<?php echo $details_data["lname"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label text-white">Mobile Number</label>
                                                <input type="text" id="mobile" class="form-control bg-transparent text-light dd" value="<?php echo $details_data["mobile"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label text-white">Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="pw" value="<?php echo $details_data["password"]; ?>" class="form-control bg-transparent text-light dd" aria-describedby="pwb">
                                                    <span class="input-group-text bg-transparent text-light dd" id="pwb" onclick="showPassword3();"><i class="bi bi-eye-fill"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label text-white">Email</label>
                                                <input type="text" id="email" class="form-control bg-transparent text-light dd" value="<?php echo $details_data["email"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label text-white">Registered Date</label>
                                                <input type="text" class="form-control bg-transparent text-light dd" readonly value="<?php echo $details_data["joined_date"]; ?>" />
                                            </div>

                                            <?php
                                            if (empty($address_data["line1"])) {
                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label text-white">Address Line 01</label>
                                                    <input type="text" id="line1" class="form-control bg-transparent text-light dd" placeholder="Enter Address Line 01" />
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label text-white">Address Line 01</label>
                                                    <input type="text" id="line1" class="form-control bg-transparent text-light dd" value="<?php echo $address_data["line1"]; ?>" />
                                                </div>
                                            <?php
                                            }

                                            if (empty($address_data["line2"])) {
                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label text-white">Address Line 02</label>
                                                    <input type="text" id="line2" class="form-control bg-transparent text-light dd" placeholder="Enter Address Line 02" />
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label text-white">Address Line 02</label>
                                                    <input type="text" id="line2" class="form-control bg-transparent text-light dd" value="<?php echo $address_data["line2"]; ?>" />
                                                </div>
                                            <?php
                                            }

                                            $province_rs = Database::search("SELECT * FROM `province`");
                                            $district_rs = Database::search("SELECT * FROM `district`");
                                            $city_rs = Database::search("SELECT * FROM `city`");

                                            $province_num = $province_rs->num_rows;
                                            $district_num = $district_rs->num_rows;
                                            $city_num = $city_rs->num_rows;

                                            ?>

                                            <div class="col-6">
                                                <label class="form-label text-white">Province</label>
                                                <select class="form-select bg-transparent text-light dd" id="province">
                                                    <option class="bg-secondary" value="0">Select Province</option>
                                                    <?php

                                                    for ($i = 0; $i < $province_num; $i++) {
                                                        $province_data = $province_rs->fetch_assoc();
                                                    ?>

                                                        <option class="dd" value="<?php echo $province_data["province_id"] ?>" <?php
                                                                                                                                if (!empty($address_data["province_province_id"])) {
                                                                                                                                    if ($province_data["province_id"] == $address_data["province_province_id"]) {
                                                                                                                                ?> selected <?php
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                            ?>>
                                                            <?php echo $province_data["province_name"]; ?>
                                                        </option>

                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label text-white">District</label>
                                                <select class="form-select bg-transparent text-light dd" id="district">
                                                    <option class="bg-secondary" value="0">Select District</option>
                                                    <?php

                                                    for ($i = 0; $i < $district_num; $i++) {
                                                        $district_data = $district_rs->fetch_assoc();
                                                    ?>
                                                        <option class="dd" value="<?php echo $district_data["district_id"]; ?>" <?php
                                                                                                                                if (!empty($address_data["district_district_id"])) {
                                                                                                                                    if ($district_data["district_id"] == $address_data["district_district_id"]) {
                                                                                                                                ?> selected <?php
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                            ?>>
                                                            <?php echo $district_data["district_name"] ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label text-white">City</label>
                                                <select class="form-select bg-transparent text-light dd" id="city">
                                                    <option class="bg-secondary" value="0">Select City</option>
                                                    <?php

                                                    for ($i = 0; $i < $city_num; $i++) {
                                                        $city_data = $city_rs->fetch_assoc();
                                                    ?>
                                                        <option class="dd" value="<?php echo $city_data["city_id"]; ?>" <?php
                                                                                                                        if (!empty($address_data["city_id"])) {
                                                                                                                            if ($city_data["city_id"] == $address_data["city_city_id"]) {
                                                                                                                        ?>selected<?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                                    ?>><?php echo $city_data["city_name"] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <?php

                                            if (empty($address_data["postal_code"])) {
                                            ?>
                                                <div class="col-6">
                                                    <label class="form-label text-white">Postal Code</label>
                                                    <input type="text" id="pc" class="form-control bg-transparent text-light dd" placeholder="Enter Your Postal Code" />
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-6">
                                                    <label class="form-label text-white">Postal Code</label>
                                                    <input type="text" id="pc" class="form-control bg-transparent text-light dd" value="<?php echo $address_data["postal_code"]; ?>" />
                                                </div>
                                            <?php
                                            }

                                            ?>

                                            <div class="col-12">
                                                <label class="form-label text-white">Gender</label>
                                                <input type="text" class="form-control bg-transparent text-light dd" readonly value="<?php echo $details_data["gender_name"]; ?>" />
                                            </div>

                                            <div class="col-12 d-grid mt-2">
                                                <button class="btn btn-purple fs-5" onclick="updateProfile();">Update My Profile</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4 text-center border-end">
                                    <div class="row">

                                        <span class="fw-bold text-white mt-5 h2">Display Ads</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>



                <?php

                require "footer.php";

                ?>



            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:signIn.php");
}

?>