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
	$mySql = "SELECT pembayaran_beli.*, user.nm_user FROM pembayaran_beli 
				LEFT JOIN user ON pembayaran_beli.kd_user = user.kd_user 
				WHERE pembayaran_beli.no_pembayaran_beli='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	
	// membaca Nomor Penerimaan
	$noPenerimaan	= $myData['no_pembelian'];
	
	// Perintah untuk menampilkan data dari tabel Penerimaan
	$my2Sql = "SELECT pembelian.*, supplier.nm_supplier, user.nm_user FROM pembelian 
				LEFT JOIN supplier ON pembelian.kd_supplier=supplier.kd_supplier 
				LEFT JOIN user ON pembelian.kd_user=user.kd_user 
				WHERE pembelian.no_pembelian='$noPenerimaan'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
	$my2Data = mysql_fetch_array($my2Qry);
	
	// Jika status bayarnya masih Hutang
	if($my2Data['status_bayar']=="Hutang") {
		// Refresh
		echo "<b>BELUM DILAKUKAN PEMBAYARAN </b>";
		echo "<meta http-equiv='refresh' content='2; url=?open=Pembelian-Tampil'>";
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
    <td><b>No. Pembelian </b></td>
    <td><b>:</b></td>
    <td valign="top"><strong><?php echo $my2Data['no_pembelian']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembelian </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($my2Data['tgl_pembelian']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $my2Data['nm_supplier']; ?></td>
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
    <td width="378" valign="top"><strong><?php echo $myData['no_pembayaran_beli']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembayaran </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_pembayaran_beli']); ?></td>
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
//  Skrip menampilkan daftar barang 
$detilSql ="SELECT pembelian_item.*, barang.nm_barang, jenis.nm_jenis FROM pembelian_item 
		 LEFT JOIN barang ON pembelian_item.kd_barang=barang.kd_barang 
		 LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
		 WHERE pembelian_item.no_pembelian='$noPenerimaan' ORDER BY pembelian_item.kd_barang";
$detilQry = mysql_query($detilSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0; 
while($detilData = mysql_fetch_array($detilQry)) {
	$qtyItem		= $qtyItem + $detilData['jumlah'];
	$subTotal		= $detilData['harga_beli'] * $detilData['jumlah']; // harga beli dari tabel pembelian_item (harga terbaru dari supplier)
	$totalBelanja	= $totalBelanja + $subTotal;
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $detilData['kd_barang']; ?></td>
    <td><?php echo $detilData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($detilData['harga_beli']); ?></td>
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
