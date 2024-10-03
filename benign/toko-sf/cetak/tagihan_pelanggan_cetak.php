<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel penjualan
	$mySql = "SELECT penjualan.*, user.nm_user, pelanggan.nm_pelanggan FROM penjualan 
			  LEFT JOIN user ON penjualan.kd_user=user.kd_user
			  LEFT JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan
			  WHERE penjualan.no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);

	// Menghitung Total Penjualan (belanja) setiap nomor transaksi
	$hitungSql = "SELECT SUM(jumlah) AS total_barang,  
					  SUM((harga_jual - (harga_jual * diskon / 100)) * jumlah) AS total_harga  
			   FROM penjualan_item WHERE no_penjualan='$noNota'";
	$hitungQry = mysql_query($hitungSql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
	$hitungData = mysql_fetch_array($hitungQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Tagihan pada Pelanggan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> Pembayaran Tagihan pada Pelanggan</h2>
<table width="500" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="188"><b>No. Transaksi </b></td>
    <td width="10"><b>:</b></td>
    <td width="274"><strong><?php echo $myData['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Transaksi </b></td>
    <td><b>:</b></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td><?php echo $myData['kd_pelanggan']."/".$myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Jumlah Barang </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo format_angka($hitungData['total_barang']); ?></td>
  </tr>
  <tr>
    <td><strong>Total Harga (Rp) </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo format_angka($hitungData['total_harga']); ?></td>
  </tr>
  <tr>
    <td><b>Jenis Bayar</b></td>
    <td><b>:</b></td>
    <td><?php echo $myData['cara_bayar']; ?></td>
  </tr>
  <tr>
    <td><strong>Tgl. Tempo </strong></td>
    <td><b>:</b></td>
    <td><?php echo IndonesiaTgl($myData['tgl_jatuh_tempo']); ?></td>
  </tr>
  <tr>
    <td><b>Status Bayar</b></td>
    <td><b>:</b></td>
    <td><?php echo $myData['status_bayar']; ?></td>
  </tr>
  <tr>
    <td><strong>Kasir</strong></td>
    <td><b>:</b></td>
    <td><?php echo $myData['nm_user']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="4" bgcolor="#CCCCCC"><strong> TRANSAKSI BAYAR TAGIHAN </strong></td>
  </tr>
  <tr>
    <td width="23" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="82" bgcolor="#F5F5F5"><strong>Tgl. Bayar  </strong></td>
    <td width="348" bgcolor="#F5F5F5"><b>Keterangan</b></td>
    <td width="126" align="right" bgcolor="#F5F5F5"><b> Pembayaran (Rp) </b></td>
  </tr>
  <tr>
    <td align="center">1</td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td>DP (Down Payment)</td>
    <td align="right"><strong><?php echo format_angka($myData['uang_bayar']); ?></strong></td>
  </tr>
  <?php
  	// variabel
	$sisaHutang	= 0;
	$totalBayar  = $myData['uang_bayar']; 
	
	// Menampilkan data
	$my2Sql ="SELECT * FROM pembayaran WHERE no_penjualan='$noNota' ORDER BY tgl_pembayaran ASC";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 1;   
	while($my2Data = mysql_fetch_array($my2Qry)) {
		$nomor++;		
		$totalBayar	= $totalBayar + $my2Data['uang_bayar'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($my2Data['tgl_pembayaran']); ?></td>
    <td><?php echo $my2Data['keterangan']; ?></td>
    <td align="right"><strong><?php echo format_angka($my2Data['uang_bayar']); ?></strong></td>
  </tr>
<?php } 

$sisaHutang	= $hitungData['total_harga'] - $totalBayar;
?>
  <tr>
    <td colspan="3" align="right"><b> TOTAL PEMBAYARAN (Rp)  : </b></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBayar); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><strong>SISA HUTANG (Rp) :</strong> </td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($sisaHutang); ?></strong></td>
  </tr>
</table>
<br/>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>