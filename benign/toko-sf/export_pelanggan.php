<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_export_pelanggan'] == "Yes") {

# TOMBOL EXPORT DIKLIK
if(isset($_POST['btnExport'])){
	// menjalankan skrip Export
	echo "<script>";
	echo "window.open('export/export_pelanggan_xls.php')";
	echo "</script>";
}

?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#CCCCCC"><strong>EXPORT DATA PELANGGAN </strong></td>
    </tr>
	<tr>
      <td width="18%"><strong>Export ke Excel (.Xls) </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="81%"><input type="submit" name="btnExport" value=" EXPORT FILE " style="cursor:pointer;" /></td>
	</tr>
</table>
</form>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
