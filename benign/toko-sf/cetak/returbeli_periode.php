<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returbeli_bulan'] == "Yes") {

# MEMBACA PERIODE TANGGAL DARI BROWSER
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

// Membuat SQL Filter data
$filterSQL = " WHERE ( tgl_returbeli BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
?>
<html>
<head>
<title>:: Laporan Data Retur Beli per Periode - POS Toko Distributor</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA RETUR PEMBELIAN PER PERIODE</h2>
<table width="500"RETURborder="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Tgl. Retur </strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>No. Retur </strong></td>
    <td width="296" bgcolor="#F5F5F5"><strong>Supplier</strong></td>
    <td width="279" bgcolor="#F5F5F5"><strong>Keterangan </strong></td>
    <td width="96" align="right" bgcolor="#F5F5F5"><strong>Jumlah Brg </strong></td>
  </tr>
<?php
// Skrip untuk menampilkan data Retur Pembelian dengan Filter Periode
$mySql = "SELECT returbeli.*, supplier.nm_supplier FROM returbeli 
			LEFT JOIN supplier ON returbeli.kd_supplier = supplier.kd_supplier 
			$filterSQL ORDER BY no_returbeli DESC";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
$nomor = 0; $totalRetur = 0;
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$noNota	= $myData['no_returbeli'];
	
	# Menghitung Total Barang
	$my2Sql = "SELECT SUM(jumlah) As total_barang FROM returbeli_item WHERE no_returbeli='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	$totalRetur = $totalRetur + $my2Data['total_barang'];
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_returbeli']); ?></td>
    <td><?php echo $myData['no_returbeli']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="5" align="right"><strong>GRAND TOTAL  : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalRetur); ?></strong></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
