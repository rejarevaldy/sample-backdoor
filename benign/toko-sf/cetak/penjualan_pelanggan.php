<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_pelanggan'] == "Yes") {

// Membaca data Bulan dan Tahun dari URL
$dataTahun 	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataCust	= isset($_GET['kodeCust']) ? $_GET['kodeCust'] : 'C001';

// Membuat SQL Filter data per Bulan & Tahun
if($dataCust and $dataTahun) {
	$filterData = "WHERE LEFT(penjualan.tgl_penjualan,4)='$dataTahun' AND penjualan.kd_pelanggan='$dataCust'"; 
	
	// Membaca nama Pelanggan
	$infoSql	= "SELECT * FROM pelanggan WHERE kd_pelanggan='$dataCust'";
	$infoQry	= mysql_query($infoSql, $koneksidb) or die ("Gagal info".mysql_error());
	$infoData	= mysql_fetch_array($infoQry);
	$infoCust	= $infoData['kd_pelanggan']." - ".$infoData['nm_pelanggan'];
}
else {
	$filterData = "";
	$infoCust 	= "";
}
?>
<html>
<head>
<title>:: Laporan Transaksi Penjualan per Pelanggan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN TRANSAKSI PENJUALAN PER PELANGGAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td><strong>Pelanggan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoCust; ?></td>
  </tr>
  <tr>
    <td width="110"><strong>Tahun</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="261"><?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="82" bgcolor="#F5F5F5"><strong>Tgl. Nota</strong></td>
    <td width="82" bgcolor="#F5F5F5"><strong>No. Nota </strong></td>
    <td width="96" bgcolor="#F5F5F5"><strong>Cara Bayar </strong></td>
    <td width="96" bgcolor="#F5F5F5"><strong>Status Bayar  </strong></td>
    <td width="258" bgcolor="#F5F5F5"><strong>Keterangan </strong></td>
    <td width="81" align="right" bgcolor="#F5F5F5"><strong>Jumlah Brg</strong></td>
    <td width="139" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp)</strong></td>
  </tr>
<?php
// Variabel data
$totalHarga	= 0;
$totalBarang= 0;
	
# Perintah untuk menampilkan Penjualan dengan Filter Periode
	$mySql = "SELECT penjualan.*, pelanggan.nm_pelanggan FROM penjualan  
				LEFT JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan 
	 			$filterData 
				ORDER BY penjualan.no_penjualan DESC";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
$nomor = 0;
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$noNota	= $myData['no_penjualan'];
	
	# Menghitung Total Tiap Transaksi
	$my2Sql = "SELECT SUM(harga_jual * jumlah) AS total_belanja, SUM(jumlah) As total_barang 
					  FROM penjualan_item WHERE no_penjualan='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	
	// Menjumlah Total Semua Transaksi yang ditampilkan
	$totalHarga	= $totalHarga + $my2Data['total_belanja'];
	$totalBarang	= $totalBarang + $my2Data['total_barang'];
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['cara_bayar']; ?></td>
    <td><?php echo $myData['status_bayar']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong>Rp. <?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
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
