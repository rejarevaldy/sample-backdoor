<?php
# Konek ke Web Server Lokal
$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "pos_distributor22db"; // nama database, disesuaikan dengan database di MySQL

# Konek ke Web Server Lokal
$koneksidb	= mysql_connect($myHost, $myUser, $myPass) or die ("Koneksi gagal !");

# Memilih database pd MySQL Server
mysql_select_db($myDbs) or die ("Database <b>$myDbs </b> tidak tersedia !");
?>