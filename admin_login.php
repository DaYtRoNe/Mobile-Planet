<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Mobile Planet | Admin Login</title>
    <link rel="icon" href="resources/logo.svg">
    <link rel="stylesheet" href="mdb.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-image: linear-gradient(to right, #243949 0%, #517fa4 100%);">

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


            <!-----------------------Sign In Box-------------------------->
            <div class="col-md-6 right-box" id="Adsigninbox">
                <div class="row justify-content-center">

                    <div class=" header-text mb-4">
                        <h1 class=" text-center text-black text-decoration-underline">Admin Log In</h1>
                        <p>Manage Application Here.</p>
                    </div>

                    <div class="col-12 d-none" id="ASImsgdiv">
                        <div class="alert alert-danger" role="alert" id="ASImsg"></div>
                    </div>

                    <div class=" col-12 input-group mb-3">
                        <label class=" col-12 form-label">Email Address</label>
                        <input type="text" class=" form-control form-control-lg bg-light fs-6 rounded-3" id="ASIemail" placeholder="Amarabandu@gmail.com">
                    </div>

                    <div class=" col-12 input-group mb-1">
                        <label class=" col-12 form-label">Password</label>
                        <input type="password" class=" form-control form-control-lg bg-light fs-6 rounded-3" id="ASIpassword" placeholder="**********">
                        <button class="btn bg-secondary text-white" type="button" id="ASIpasswordb" onclick="AshowPassword();"><i class="bi bi-eye"></i></button>
                    </div>

                    <div class="input-group mb-5 d-flex justify-content-between">
                        <div class="col-12 d-grid pe-1">
                            <button class="btn btn-lg btn-primary w-100 py-3 fs-6 rounded-5 fw-bold" onclick="adminSignIn();">Log In</button>
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