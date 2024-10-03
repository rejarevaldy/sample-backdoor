<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TRANSAKSI RETUR - PROGRAM TOKO ELEKTRONIK</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css" />
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
<script type="text/javascript" src="../plugins/js.popupWindow.js"></script>
</head>
<body>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../images/logo.png" width="499" height="80"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="?open=Returbeli-Baru" target="_self">Retur Pembelian Baru</a> | <a href="?open=Returbeli-Tampil" target="_self">Tampil Retur Pembelian</a> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){				
		case 'Returbeli-Baru' :
			if(!file_exists ("returbeli_baru.php")) die ("Empty Main Page!"); 
			include "returbeli_baru.php";	break;
		case 'Returbeli-Tampil' : 
			if(!file_exists ("returbeli_tampil.php")) die ("Empty Main Page!"); 
			include "returbeli_tampil.php";	break;
		case 'Returbeli-Hapus' : 
			if(!file_exists ("returbeli_hapus.php")) die ("Empty Main Page!"); 
			include "returbeli_hapus.php";	break;
	}
}
else {
	include "returbeli_baru.php";
}
?>
</body>
</html>
