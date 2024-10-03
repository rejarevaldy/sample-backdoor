<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang'] == "Yes") {
?>
<html>
<head>
<title> ::  Data Barang - INVENTORY TOKO</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA BARANG </h2>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="87" bgcolor="#CCCCCC"><strong>Barcode</strong></td>
    <td width="322" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
    <td width="136" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
    <td width="104" align="right" bgcolor="#CCCCCC"><strong>Harga Jual(Rp)</strong></td>
    <td width="60" align="center" bgcolor="#CCCCCC"><strong>Stok</strong></td>
    <td width="60" align="center" bgcolor="#CCCCCC"><strong>Stok Op</strong></td>
  </tr>
  <?php
	# MENJALANKAN QUERY
	$mySql 	= "SELECT barang.*, kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
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
    <td align="center"><?php echo $myData['stok']; ?></td>
    <td align="center"><?php echo $myData['stok_opname']; ?></td>
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
