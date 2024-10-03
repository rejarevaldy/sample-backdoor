<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_returjual'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel returjual
	$mySql = "SELECT returjual.*, user.nm_user, pelanggan.nm_pelanggan FROM returjual 
			  LEFT JOIN user ON returjual.kd_user = user.kd_user
			  LEFT JOIN pelanggan ON returjual.kd_pelanggan = pelanggan.kd_pelanggan
			  WHERE returjual.no_returjual='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah 1: ".mysql_error());
	$myData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Retur Penjualan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> RETUR PENJUALAN</h2>
<table width="600" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="139"><b>No. Retur </b></td>
    <td width="5"><b>:</b></td>
    <td width="378" valign="top"><strong><?php echo $myData['no_returjual']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Retur </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_returjual']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Kasir</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_user']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="5" bgcolor="#CCCCCC"><strong>DAFTAR BARANG </strong></td>
  </tr>
  <tr>
    <td width="29" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="68" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="281" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="241" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="55" align="right" bgcolor="#F5F5F5"><b> Jumlah </b></td>
  </tr>
  <?php
  	// Buat variabel
	$totalBrg	= 0;
	
	// SQL menampilkan item barang yang di Kembalikan
	$mySql ="SELECT returjual_item.*, barang.nm_barang 
			 FROM returjual_item 
			 LEFT JOIN barang ON returjual_item.kd_barang=barang.kd_barang 
			 WHERE returjual_item.no_returjual='$noNota'
			 ORDER BY returjual_item.no_returjual DESC ";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp ".mysql_error());
	$nomor = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$totalBrg	= $totalBrg + $myData['jumlah'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right"><b> Grand Total : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBrg); ?></strong></td>
  </tr>
</table>
<br/>
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
