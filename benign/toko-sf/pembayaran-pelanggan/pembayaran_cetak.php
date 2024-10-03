<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_bayar_pembelian'] == "Yes") {

# ====================================================
if(isset($_GET['Kode'])) {
	# Baca variabel URL
	$Kode = $_GET['Kode'];
	
	// Perintah untuk menampilkan data dari tabel Pembayaran
	$mySql = "SELECT pembayaran_jual.*, user.nm_user FROM pembayaran_jual 
				LEFT JOIN user ON pembayaran_jual.kd_user = user.kd_user 
				WHERE pembayaran_jual.no_pembayaran_jual='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	
	// membaca Nomor Penjualan
	$noPenjualan	= $myData['no_penjualan'];
	
	// Perintah untuk menampilkan data dari tabel Penjualan
	$my2Sql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan 
				LEFT JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan 
				LEFT JOIN user ON penjualan.kd_user=user.kd_user 
				WHERE penjualan.no_penjualan='$noPenjualan'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
	$my2Data = mysql_fetch_array($my2Qry);
	
	// Jika status bayarnya masih Hutang
	if($my2Data['status_bayar']=="Hutang") {
		// Refresh
		echo "<b>BELUM DILAKUKAN PEMBAYARAN </b>";
		echo "<meta http-equiv='refresh' content='2; url=?open=Penjualan-Tampil'>";
		exit;
	}
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	$Kode	= "";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Pembayaran - Aplikasi POS Distributor</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Courier New, Courier, monospace;
}
body {
	margin-top: 1px;
}
.table-list {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 5px 0px;
	background:#fff;	
}
.table-list td {
	color: #333;
	font-size:12px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 2px 3px;
	border-bottom:1px #CCCCCC solid;
}

-->
</style>
</head>
<body>
<h2> PEMBAYARAN</h2>
<table width="800" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td bgcolor="#F5F5F5"><strong>PEMBELIAN</strong></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td><b>No. Penjualan </b></td>
    <td><b>:</b></td>
    <td valign="top"><strong><?php echo $my2Data['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Penjualan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($my2Data['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $my2Data['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $my2Data['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Operator</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $my2Data['nm_user']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>PEMBAYARAN</strong></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="139"><b>No. Pembayaran </b></td>
    <td width="5"><b>:</b></td>
    <td width="378" valign="top"><strong><?php echo $myData['no_pembayaran_jual']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembayaran </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_pembayaran_jual']); ?></td>
  </tr>
  <tr>
    <td><strong>Total Bayar (Rp) </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo format_angka($myData['total_bayar']); ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Operator</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_user']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="76" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="466" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="117" align="right" bgcolor="#F5F5F5"><strong>Harga (Rp)</strong> </td>
    <td width="57" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
    <td width="125" align="right" bgcolor="#F5F5F5"><strong>SubTotal(Rp) </strong></td>
  </tr>
  <?php
//  tabel menu 
$detilSql ="SELECT penjualan_item.*, barang.nm_barang, jenis.nm_jenis FROM penjualan_item 
		 LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
		 LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
		 WHERE penjualan_item.no_penjualan='$noPenjualan' ORDER BY penjualan_item.kd_barang";
$detilQry = mysql_query($detilSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0; 
while($detilData = mysql_fetch_array($detilQry)) {
	$qtyItem		= $qtyItem + $detilData['jumlah'];
	$subTotal		= $detilData['harga_jual'] * $detilData['jumlah']; // harga beli dari tabel penjualan_item (harga terbaru dari pelanggan)
	$totalBelanja	= $totalBelanja + $subTotal;
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $detilData['kd_barang']; ?></td>
    <td><?php echo $detilData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($detilData['harga_jual']); ?></td>
    <td align="right"><?php echo $detilData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="4" align="right"><b> GRAND TOTAL  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo $qtyItem; ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong>
      <input name="txtTotalBayar" type="hidden" id="txtTotalBayar" value="<?php echo $totalBelanja; ?>" />
      Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
  </tr>
</table>
<br/>
<img src="../images/btn_print.png" width="20"  onClick="javascript:window.print()" />
</body>
</html>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
