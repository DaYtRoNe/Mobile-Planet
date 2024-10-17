
<?php

session_start();

require("connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mobile Planet | Help & Contact</title>
    <link rel="icon" href="resources/logo/lotus.webp">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resources/logo.svg" />
</head>

<body class=" bg-secondary-subtle" onload="reload();">

    <?php require("header.php"); ?>

    <div class="container text-center mb-5 mt-6">
        <h2 class="text-center text-decoration-underline">If you got any questions please do not hesitate to send us a message!</h2>
    </div>
    <hr>

    
        <div class="container">
            <div class="row block-9 justify-content-center mb-5 card rounded-6">
                <div class="">
                    <div class="card-header">
                        <h2 class="text-center">Send message to the Admin</h2>
                    </div>
                    <div class="card-body">
                        <form id="contactForm" action="https://api.web3forms.com/submit" method="POST">
                            <input type="hidden" name="access_key" value="da911a5e-0e29-44af-a631-9cf28777db8a" />
                            <div class="form-group mb-3">
                                <input type="text" name="name" class="form-control rounded-6" placeholder="Your Name" required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" name="email" class="form-control rounded-6" placeholder="Your Email" required>
                            </div>
                            <div class="form-group mb-4">
                                <textarea name="message" id="" cols="30" rows="7" class="form-control rounded-6" placeholder="Message" required></textarea>
                            </div>
                            <div class="form-group text-end">
                                <input type="hidden" name="redirect" value="https://web3forms.com/success">
                                <a href="index.php" class="btn btn-success fw-bold rounded-6 py-2"> Home</a>
                                <button type="submit" class="btn btn-primary fw-bold rounded-6 py-2"> Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php require("footer.php"); ?>

    <script src="script.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
</body>

</html>