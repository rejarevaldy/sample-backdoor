<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_minimal'] == "Yes") {

# Variabel SQL
$filterSQL	= "";

# Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : '';

if($_GET) {
	# PILIH KATEGORI
	if ($kodeKategori =="Semua") {
		$filterSQL = "";
		$namaKategori= "-";
	}
	else {
		$filterSQL = " AND jenis.kd_kategori='$kodeKategori'";
		
		// Mendapatkan informasi
		$infoSql = "SELECT * FROM kategori WHERE kd_kategori='$kodeKategori'";
		$infoQry = mysql_query($infoSql, $koneksidb);
		$infoData= mysql_fetch_array($infoQry);
		$namaKategori= $infoData['nm_kategori'];
	}
} // End GET
else {
	$filterSQL	= "";
}
?>
<html>
<head>
<title> :: Laporan Data Barang Stok Minimal</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA BARANG STOK MINIMAL</h2>
<table width="400" border="0"  class="table-list">
<tr>
  <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
</tr>
<tr>
  <td width="109"><b>Nama Kategori </b></td>
  <td width="15"><b>:</b></td>
  <td width="262"><?php echo $namaKategori; ?></td>
</tr>
</table>
  
<table class="table-list" width="958" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" rowspan="2" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="44" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="69" rowspan="2" bgcolor="#F5F5F5"><strong> Barcode </strong></td>
    <td width="329" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="129" rowspan="2" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>INFO STOK</strong></td>
    <td width="50" rowspan="2" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
  </tr>
  <tr>
    <td width="50" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="71" align="right" bgcolor="#F5F5F5"><strong>Opname</strong></td>
    <td width="71" align="right" bgcolor="#F5F5F5"><strong>Min</strong></td>
    <td width="72" align="right" bgcolor="#F5F5F5"><strong>Max</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT barang.*, jenis.nm_jenis FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
				WHERE barang.stok <= barang.stok_minimal
				$filterSQL 
				ORDER BY barang.kd_barang ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?> </td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['barcode']; ?> </td>
    <td><?php echo $myData['nm_barang']; ?> </td>
    <td><?php echo $myData['nm_jenis']; ?> </td>
    <td align="right"><?php echo format_angka($myData['stok']); ?></td>
    <td align="right"><?php echo format_angka($myData['stok_opname']); ?></td>
    <td align="right"><?php echo format_angka($myData['stok_minimal']); ?></td>
    <td align="right"><?php echo format_angka($myData['stok_maksimal']); ?></td>
    <td><?php echo $myData['satuan']; ?> </td>
  </tr>
  <?php } ?>
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
