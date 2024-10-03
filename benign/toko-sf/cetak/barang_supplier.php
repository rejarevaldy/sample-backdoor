<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_supplier'] == "Yes") {

// Variabel SQL
$filterSQL	= "";

// Membaca variabel URL(alamat browser) untuk filter SQL
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$kodeSupplier	= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua';

# ==============
# PENCARIAN DATA BERDASARKAN FILTER DATA
if(trim($kodeKategori) =="Semua") {
	// Semua Kategori
	if(trim($kodeSupplier) =="Semua") {
		// Semua Kategori & Semua Supplier
		$filterSQL = "";
	}
	else {
		// Semua Kategori & Supplier Terpilih
		$filterSQL = "WHERE barang.kd_supplier='$kodeSupplier'";
	}
}
else {
	// Kategori terpilih
	if(trim($kodeSupplier) =="Semua") {
		// Kategori terpilih dan Semua Supplier
		$filterSQL = "WHERE jenis.kd_kategori ='$kodeKategori'";
	}
	else {
		// Kategori terpilih dan Supplier terpilih
		$filterSQL = "WHERE jenis.kd_kategori ='$kodeKategori' AND barang.kd_supplier='$kodeSupplier'";
	}
}

# ==============
# INFORMASI NAMA KATEGORI
if ($kodeKategori =="Semua") {
	$namaKategori= "Semua";
}
else {
	// Mendapatkan informasi nama Supplier
	$infoSql 	= "SELECT nm_kategori FROM kategori WHERE kd_kategori='$kodeKategori'";
	$infoQry 	= mysql_query($infoSql, $koneksidb);
	$infoData	= mysql_fetch_array($infoQry);
	$namaKategori	= $infoData['nm_kategori'];
}

# ==============
# INFORMASI NAMA SUPPLIER
if ($kodeSupplier =="Semua") {
	$namaSupplier= "Semua";
}
else {
	// Mendapatkan informasi nama Supplier
	$infoSql = "SELECT nm_supplier FROM supplier WHERE kd_supplier='$kodeSupplier'";
	$infoQry = mysql_query($infoSql, $koneksidb);
	$infoData= mysql_fetch_array($infoQry);
	$namaSupplier= $infoData['nm_supplier'];
}
?>
<html>
<head>
<title>:: Data Barang per Supplier - Inventory Toko</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN  DATA BARANG PER SUPPLIER </h2>
<table width="500" border="0"  class="table-list">
<tr>
  <td colspan="3" bgcolor="#CCCCCC"><strong>BERDASARKAN </strong></td>
</tr>
<tr>
  <td><b>Nama Kategori </b></td>
  <td><b>:</b></td>
  <td><?php echo $namaKategori; ?></td>
</tr>
<tr>
  <td width="132"><b>Nama Supplier </b></td>
  <td width="5"><b>:</b></td>
  <td width="349"><?php echo $namaSupplier; ?></td>
</tr>
</table>
  
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="56" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="98" bgcolor="#F5F5F5"><strong>Barcode</strong></td>
    <td width="322" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="145" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
    <td width="116" align="right" bgcolor="#F5F5F5"><strong>Harga Jual(Rp)</strong></td>
    <td width="49" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="50" align="right" bgcolor="#F5F5F5"><strong>Opname</strong></td>
  </tr>
  <?php
	// Skrip menampilkan Data barang per Supplier, informasi dilengkapi Nama Kategori
	$mySql 	= "SELECT barang.*, kategori.nm_kategori FROM barang 
					LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis 
					LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori 
					$filterSQL
					ORDER BY barang.kd_barang ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['barcode']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['stok']; ?></td>
    <td align="right"><?php echo $myData['stok_opname']; ?></td>
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
