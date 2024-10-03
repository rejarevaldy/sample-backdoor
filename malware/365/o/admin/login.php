<?php
session_start(); 
require 'config.php';

if(isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

function clear($param) {
    if(!preg_match("/^[A-Za-z0-9]+$/", $param)) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }

    return $param;
}

if(isset($_POST['submit'])) {
    $key = clear($_POST['key']);    

    if($key !== $config['key']) {
        header('Location: login.php');
        exit();
    }


    $_SESSION['login'] = $key;
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Panel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <style type="text/css">
            .row {
                height: 100vh;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-lg-4 col-md-4 col-xs-12 mx-auto">
                    <div class="card">
                        <div class="card-header text-center">Login to Panel</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="key" name="key" placeholder="Private Key" autocomplete="off" spellcheck="false" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>