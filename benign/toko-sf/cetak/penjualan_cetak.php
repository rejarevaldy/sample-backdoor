<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_penjualan'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel penjualan
	$mySql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan
				LEFT JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan 
				LEFT JOIN user ON penjualan.kd_user=user.kd_user 
				WHERE penjualan.no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);

	// Menthitung Total Bayar pada Tabel Pembayaran (ada data jika Cara Bayar-nya Kredit)
	$my2Sql	= "SELECT SUM(total_bayar) As total_bayar FROM pembayaran_jual WHERE no_penjualan='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
	$my2Data = mysql_fetch_array($my2Qry);
	
	// Total Terbayar (total DP + Total Bayar angsur/Kredit)
	$totalTerbayar	= $myData['uang_bayar'] + $my2Data['total_bayar']; 
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Penjualan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> PENJUALAN </h2>
<table width="500" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="153"><b>No. Nota </b></td>
    <td width="10"><b>:</b></td>
    <td width="309" valign="top"><strong><?php echo $myData['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Nota </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><b> Pelanggan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td class="table-list"><strong>Cara Bayar </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['cara_bayar']; ?></td>
  </tr>
  <tr>
    <td class="table-list"><strong>Status </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['status_bayar']; ?></td>
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

<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="8"><strong>DAFTAR BARANG </strong></td>
  </tr>
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="56" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="380" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="100" align="right" bgcolor="#F5F5F5"><b> Harga (Rp) </b></td>
    <td width="55" align="right" bgcolor="#F5F5F5"><b> Jumlah </b></td>
    <td width="100" align="right" bgcolor="#F5F5F5"><strong>Sub Total(Rp) </strong></td>
    <td width="100" align="right" bgcolor="#F5F5F5"><strong>PPN (Rp)</strong></td>
    <td width="100" align="right" bgcolor="#F5F5F5"><strong>Total PPN (Rp)</strong></td>
  </tr>
  <?php
  	// Buat variabel
	$jumlahBayar	= 0;
	$totalBayar		= 0;
	
	// SQL menampilkan item barang yang dijual
	$detilSql ="SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
			  LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
			  WHERE penjualan_item.no_penjualan='$noNota'
			  ORDER BY penjualan_item.kd_barang";
	$detilQry = mysql_query($detilSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  
	while($detilData = mysql_fetch_array($detilQry)) {
		$nomor++;
	  $ppn 			    = $detilData['harga_jual'] * ($detilData['ppn'] / 100);
		$jumlahBayar 	= $detilData['jumlah'] * ($detilData['harga_jual'] + $ppn);
		$totalBayar		= $totalBayar + $jumlahBayar;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $detilData['kd_barang']; ?></td>
    <td><?php echo $detilData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($detilData['harga_jual']); ?></td>
    <td align="right"><?php echo $detilData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($jumlahBayar); ?></td>
    <td align="right"><?php echo format_angka($ppn) ?></td>
    <td align="right"><?php echo format_angka($ppn * $detilData['jumlah']) ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><b> TOTAL BELANJA (Rp)  : </b></td>
    <td align="left" colspan="3" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBayar); ?></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><b> GRAND TOTAL (Rp)  : </b></td>
    <td align="left" colspan="3" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBayar); ?></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><strong>TOTAL DIBAYAR (Rp) :</strong> </td>
    <td align="left" colspan="3" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalTerbayar); ?></strong></td>
  </tr>
  <?php 
  if($myData['cara_bayar']=="Kredit") {
		// Menghitung Total Hutang ( Total Belanja - Total Terbayar Kredit yang sudah dilakukan )
	  $totalHutang	= $totalBayar - $totalTerbayar;
  ?>  
  <tr>
    <td colspan="5" align="right"><strong>TOTAL HUTANG (Rp):</strong> </td>
    <td align="left" colspan="3" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHutang); ?></strong></td>
  </tr>
  <?php } ?>
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
