<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_pembelian'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel pembelian
	$mySql = "SELECT pembelian.*,  supplier.nm_supplier FROM pembelian 
			  LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			  WHERE pembelian.no_pembelian='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Pembelian </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> PEMBELIAN </h2>
<table width="450" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="154"><b>No. Pembelian </b></td>
    <td width="10"><b>:</b></td>
    <td width="258" valign="top"><strong><?php echo $myData['no_pembelian']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembelian </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<p><strong>DAFTAR ITEM BARANG </strong></p>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="78" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="319" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="91" align="right" bgcolor="#F5F5F5"><b> Level Modal</b></td>
    <td width="91" align="right" bgcolor="#F5F5F5"><b> PPN/PPH (Rp) </b></td>
    <td width="91" align="right" bgcolor="#F5F5F5"><b> Harga (Rp) </b></td>
    <td width="55" align="right" bgcolor="#F5F5F5"><b> Jumlah </b></td>
    <td width="96" align="right" bgcolor="#F5F5F5"><strong>Subtotal(Rp) </strong></td>
  </tr>
  <?php
  	// Buat variabel
	$subTotalHarga	= 0;
	$grandTotalHarga	= 0;
	
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT pembelian_item.*, barang.nm_barang FROM pembelian_item
			  LEFT JOIN barang ON pembelian_item.kd_barang=barang.kd_barang 
			  WHERE pembelian_item.no_pembelian='$noNota'
			  ORDER BY pembelian_item.kd_barang";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	  $ppn 			    = $myData['harga_beli'] * ($myData['ppn'] / 100);
    $subTotalHarga 	= $myData['jumlah'] * ($myData['harga_beli'] + $ppn);
		$grandTotalHarga	= $grandTotalHarga + $subTotalHarga;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td>Modal <?php echo $myData['jual']; ?></td>
    <td align="right"><?php echo format_angka($ppn); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalHarga); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right"><b> Grand Total (Rp)  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($grandTotalHarga); ?></strong></td>
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
