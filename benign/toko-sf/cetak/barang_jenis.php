<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_jenis'] == "Yes") {

# Variabel SQL
$filterSQL	= "";

# Temporary Variabel form
$kodeJenis	= isset($_GET['kodeJenis']) ? $_GET['kodeJenis'] : '';

if($_GET) {
	# PILIH KATEGORI
	if ($kodeJenis =="Semua") {
		$filterSQL = "";
		$namaKategori= "-";
	}
	else {
		// Membuat filter
		$filterSQL = " WHERE barang.kd_jenis = '$kodeJenis'";
		
		// Mendapatkan informasi
		$infoSql = "SELECT jenis.*, kategori.nm_kategori FROM jenis 
					LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
					WHERE jenis.kd_jenis ='$kodeJenis'";
		$infoQry = mysql_query($infoSql, $koneksidb);
		$infoData= mysql_fetch_array($infoQry);
		
		// Membaca nama
		$namaKategori	= $infoData['nm_kategori'];
		$namaJenis		= $infoData['nm_jenis'];
	}
} // End GET
else {
	$kategoriSQL= "";
}
?>
<html>
<head>
<title> :: Laporan Data Barang per Jenis</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA BARANG - PER JENIS</h2>
<table width="400" border="0"  class="table-list">
<tr>
  <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
</tr>
<tr>
  <td width="109"><b>Nama Kategori </b></td>
  <td width="15"><b>:</b></td>
  <td width="262"><?php echo $namaKategori; ?></td>
</tr>
<tr>
  <td><strong>Jenis</strong> </td>
  <td><b>:</b></td>
  <td><?php echo $namaJenis; ?></td>
</tr>
</table>
  
<table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="20" rowspan="2" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="40" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="70" rowspan="2" bgcolor="#F5F5F5"><strong> Barcode </strong></td>
    <td width="285" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="130" rowspan="2" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="31" rowspan="2" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="48" rowspan="2" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
    <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA MODAL </strong></td>
    <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA JUAL </strong></td>
  </tr>
  <tr>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 1(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 2(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 3(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 4(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 1(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 2(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 3(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 4(Rp)</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT barang.*, jenis.nm_jenis, merek.nm_merek FROM barang 
				LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek 
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
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo $myData['stok']; ?> </td>
    <td><?php echo $myData['satuan']; ?> </td>
    <td align="right"><?php echo format_angka($myData['harga_modal_1']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal_2']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal_3']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal_4']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_1']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_2']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_3']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_4']); ?></td>
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
