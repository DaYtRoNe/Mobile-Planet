<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Mobile Planet | Sign In/Up</title>
    <link rel="icon" href="resources/logo.svg">
    <link rel="stylesheet" href="mdb.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">

    <?php
    $email = "";
    $password = "";

    if (isset($_COOKIE["email"])) {
        $email = $_COOKIE["email"];
    }

    if (isset($_COOKIE["password"])) {
        $password = $_COOKIE["password"];
    } ?>

    <div class="container d-flex justify-content-center align-items-center indvh">
        <div class="row border rounded-5 p-3 bg-white shadow box-area mb-4 mt-3">

            <!-----------------------left box-------------------------->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column rounded-5 left-box nlb">
                <a href="index.php">
                    <div class="mb-2 lbi">
                        <img src="resources/left-box.png" class="img-fluid" />
                    </div>
                </a>
                <a href="index.php" class="text-light h2 text-decoration-none lbh3">Mobile Planet</a><br>
                <p class=" text-white text-wrap text-center lbp"><span class=" fw-bolder">Best </span>Mobile phones with the <span class=" fw-bolder">Best </span>customer service.</p>
            </div>

            <div class="col-md-6 rounded-4 justify-content-center align-items-center flex-column left-box smdlb">
                <a href="index.php" class="text-light h2 text-decoration-none lbh3">Mobile Planet</a><br>
                <p class=" text-white text-wrap text-center lbp"><span class=" fw-bolder">Best </span>Mobile phones with the <span class=" fw-bolder">Best </span>customer service.</p>
            </div>

            <!-----------------------right box-------------------------->


            <!-----------------------Sign Up box-------------------------->
            <div class="col-md-6 right-box d-none" id="signupbox">
                <div class="row justify-content-center">

                    <div class=" header-text mb-4">
                        <h2 class=" text-center">Hello, Welcome to the <span class=" fw-bold text-decoration-underline">Mobile Planet</span></h2><br>
                        <p>Be a customer at the best Mobile Phone Shop.</p>
                    </div>

                    <div class="col-12 d-none" id="SUmsgdiv">
                        <div class="alert alert-danger" role="alert" id="SUmsg"></div>
                    </div>

                    <div class="col-12 col-md-6 input-group mb-2">
                        <label class=" col-12 form-label">First Name</label>
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" placeholder="Amarabandu" id="fname">
                    </div>

                    <div class=" col-12 input-group mb-2">
                        <label class=" col-12 form-label">Last Name</label>
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" placeholder="Rupasinghe" id="lname">
                    </div>

                    <div class=" col-12 input-group mb-2">
                        <label class=" col-12 form-label">Email Address</label>
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" placeholder="Amarabandu@gmail.com" id="email">
                    </div>

                    <div class=" col-12 input-group mb-2">
                        <label class=" col-12 form-label">Password</label>
                        <input type="password" class=" form-control form-control-lg bg-light fs-6 rounded-3" placeholder="**********" id="password">
                    </div>

                    <div class=" col-12 input-group mb-2">
                        <label class=" col-12 form-label">Mobile</label>
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" placeholder="0771234567" id="mobile">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Gender</label>
                        <select class="form-control" id="gender">
                            <option value="0">Select your Gender</option>
                            <?php

                            require "connection.php";

                            $rs = Database::search("SELECT * FROM `gender`");
                            $n = $rs->num_rows;

                            for ($i = 0; $i < $n; $i++) {
                                $d = $rs->fetch_assoc();

                            ?>

                                <option value="<?php echo $d["id"] ?>"><?php echo $d["gender_name"] ?></option>

                            <?php

                            }

                            ?>
                        </select>

                        <div class="input-group mb-5 d-flex mt-2 align-items-center">
                            <div class="col-12 d-grid pe-1">
                                <button class="btn btn-primary rounded-5 py-3 fw-bold" onclick="signUp();">Create Account</button>
                            </div>

                            <div class="row mt-3">
                                <small>Already have an account? <span class="signup" onclick="ChangeView();">Sign In here</span></small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-----------------------Sign Up Box end-------------------------->


            <!-----------------------Sign In Box-------------------------->
            <div class="col-md-6 right-box" id="signinbox">
                <div class="row justify-content-center">

                    <div class=" header-text mb-4">
                        <h2 class=" text-center">Hello, Again</h2>
                        <p>We are happy to have you back.</p>
                    </div>

                    <div class="col-12 d-none" id="SImsgdiv">
                        <div class="alert alert-danger" role="alert" id="SImsg"></div>
                    </div>

                    <?php


                    ?>

                    <div class=" col-12 input-group mb-3">
                        <label class=" col-12 form-label">Email Address</label>
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" value="<?php echo $email ?>" id="SIemail" placeholder="Amarabandu@gmail.com">
                    </div>

                    <div class=" col-12 input-group mb-1">
                        <label class=" col-12 form-label">Password</label>
                        <input type="password" class=" form-control form-control-lg bg-light fs-6 rounded-3" id="SIpassword" placeholder="**********" value="<?php echo $password ?>">
                        <button class="btn bg-secondary text-white" type="button" id="SIpasswordb" onclick="showPassword();"><i class="bi bi-eye"></i></button>
                    </div>

                    <div class="input-group mb-5 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rememberMe" value="" id="rememberme">
                            <label class="form-check-label text-secondary" for="rememberme">Remember Me</label>
                        </div>

                        <div class="text-end">
                            <a href="forgotpassword.php" class=" text-primary"><small>Forgot Password?</small></a>
                        </div>
                    </div>

                    <div class="input-group mb-5 d-flex justify-content-between">
                        <div class="col-12 d-grid pe-1">
                            <button class="btn btn-lg btn-primary w-100 py-3 fs-6 rounded-5 fw-bold" onclick="signIn();">Sign In</button>
                        </div>

                        <div class="row mt-3">
                            <small>don't have an account? <span class="signup" onclick="ChangeView();">Sign Up here</span></small>
                        </div>
                    </div>

                </div>
            </div>

            <!-----------------------Sign In Box end-------------------------->

        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>
    <!--footer -->

    <script src="script.js"></script>
    <script src="bootstrap.js"></script>

</body>

</html>