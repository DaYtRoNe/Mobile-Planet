<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="mdb.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" integrity="sha512-IBChgPGHGSCtpeErdLt/GOgOY7Ih+Ih4NmKwAqja9YfuA7ct9QRuKP5WePjw9I4jEv1uYH+xt/Vz6QHNHulA5A==" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top bg-black navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><img id="MDB-logo" src="resources/logo.svg" alt="MDB Logo" draggable="false" height="30" /></a>
            <a class="text-light text-decoration-none h4" href="adminDashboard.php">Mobile Planet Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto align-items-start">
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="manageUsers.php">Customer Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="manageProducts.php">Product Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="manageOrders.php">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="addProduct.php">Add products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="adminReport.php">Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="#!" onclick="signOut();">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB5-Pro-Advanced_3.8.1/js/mdb.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="script.js"></script>
</body>

</html>