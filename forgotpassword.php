<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobile Planet | ForgotPassword</title>
    <link rel="icon" href="resources/m-removebg-preview.svg">
    <link rel="stylesheet" href="mdb.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">

    <div class="container d-flex justify-content-center align-items-center FPvh">
        <div class="row border bg rounded-5 p-3 bg-white shadow box-area">

            <!-----------------------left box-------------------------->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box nlb">
                <div class="mb-2 lbi">
                    <img src="resources/left-box.png" class="img-fluid" />
                </div>
                <h2 class="text-light lbh3">Mobile Planet</h2><br>
                <p class=" text-white text-wrap text-center lbp"><span class=" fw-bolder">Best </span>Mobile phones with the <span class=" fw-bolder">Best </span>customer service.</p>
            </div>

            <div class="col-md-6 rounded-4 justify-content-center align-items-center flex-column left-box smdlb">
                <h2 class="text-light lbh3">Mobile Planet</h2><br>
                <p class=" text-white text-wrap text-center lbp"><span class=" fw-bolder">Best </span>Mobile phones with the <span class=" fw-bolder">Best </span>customer service.</p>
            </div>

            <!-----------------------left box end-------------------------->


            <!-----------------------right box-------------------------->

            <!-----------------------forgot password-------------------------->
            <div class="col-md-6 right-box" id="forgotpasswordbox">
                <div class="row justify-content-center">

                    <div class=" header-text mb-4">
                        <h2 class=" text-center mt-3">Forgot Password?</h2>
                        <p class=" text-secondary text-center mt-2">Enter your email to reset password.</p>
                    </div>

                    <div class="col-12 d-none" id="FPmsgdiv">
                        <div class="alert alert-danger" role="alert" id="FPmsg"></div>
                    </div>

                    <div class=" col-12 input-group mt-3 mb-3">
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" id="forgotpwemail" placeholder="Email Address">
                    </div>

                    <div class="input-group mb-5 d-flex justify-content-between mt-5">
                        <div class="col-6 d-grid pe-1">
                            <button class="btn btn-lg btn-primary w-100 fs-5 rounded-5" onclick="forgotPassword();">Submit</button>
                        </div>

                        <div class="col-6 d-grid pe-1">
                            <a href="index.php" class="btn btn-lg btn-secondary w-100 fs-5 rounded-5">Cansel</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-----------------------forgot pasword end-------------------------->

            <!-----------------------submit new password-------------------------->
            <div class="col-md-6 right-box d-none" id="newpasswordbox">
                <div class="row justify-content-center">

                    <div class=" header-text">
                        <h2 class=" text-center">Forgot Password?</h2>
                        <p class=" text-secondary text-center">Enter your new password here.</p>
                    </div>

                    <div class="col-12 d-none" id="SNPmsgdiv">
                        <div class="alert alert-danger" role="alert" id="SNPmsg"></div>
                    </div>

                    <div class=" col-12 input-group mb-2 mt-2">
                        <input type="password" class=" form-control form-control-lg bg-light fs-6" id="np" placeholder="Enter new password">
                        <button class="btn bg-secondary text-white" type="button" id="npb" onclick="showPassword1();"><i class="bi bi-eye"></i></button>
                    </div>

                    <div class=" col-12 input-group mb-2 mt-3">
                        <input type="password" class=" form-control form-control-lg bg-light fs-6" id="rnp" placeholder="Re enter new password">
                        <button class="btn bg-secondary text-white" type="button" id="rnpb" onclick="showPassword2();"><i class="bi bi-eye"></i></button>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" id="vc" placeholder="Verification code">
                    </div>

                    <div class="input-group mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rememberMe" value="1" id="rememberme">
                            <input type="hidden" name="rememberMe" value="0">
                            <label class="form-check-label" for="rememberme">I Agree <a href="#">Terms and conditions.</a></label>
                        </div>
                    </div>

                    <div class="input-group d-flex mt-3">
                        <div class="col-6 d-grid pe-1">
                            <button class="btn btn-lg btn-primary w-100 fs-5 rounded-5" onclick="resetPassword();">Submit</button>
                        </div>

                        <div class="col-6 d-grid pe-1">
                            <a href="index.php" class="btn btn-lg btn-secondary w-100 fs-5 rounded-5">Cansel</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-----------------------submit new password end-------------------------->



        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="script.js"></script>
    <script src="bootstrap.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>

</html>