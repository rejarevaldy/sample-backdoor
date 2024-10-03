<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_jenis'] == "Yes") {
?>
<html>
<head>
<title>:: Data Jenis - POS Toko & Distributor</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA JENIS </h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="42" bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="264" bgcolor="#F5F5F5"><b>Nama Jenis </b></td>
    <td width="268" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
    <td width="77" align="right" bgcolor="#F5F5F5"><b>Qty Barang </b> </td>
  </tr>
  <?php
	  // Menampilkan data Jenis
	$mySql = "SELECT jenis.*, kategori.nm_kategori FROM jenis LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori ORDER BY jenis.kd_jenis ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_jenis'];
		
		// Menghitung jumlah barang per Jenis
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_jenis='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_jenis']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right"><?php echo $my2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
