<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_bulan'] == "Yes") {

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Membuat SQL Filter data per Bulan & Tahun
if($dataBulan and $dataTahun) {
	$filterData = "WHERE LEFT(tgl_penjualan,4)='$dataTahun' AND MID(tgl_penjualan,6,2)='$dataBulan'";
}
else {
	$filterData = "";
}
?>
<html>
<head>
<title>:: Laporan Transaksi Penjualan per Bulan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN TRANSAKSI PENJUALAN PER BULAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="130"><strong>Periode Transaksi </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="241"><?php echo $listBulan[$dataBulan]; ?>, <?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Tgl. Nota</strong></td>
    <td width="83" bgcolor="#F5F5F5"><strong>No. Nota </strong></td>
    <td width="229" bgcolor="#F5F5F5"><strong>Pelanggan </strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>Cara Bayar </strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>Status Bayar </strong></td>
    <td width="86" align="right" bgcolor="#F5F5F5"><strong>Jumlah Brg</strong></td>
    <td width="136" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp)</strong></td>
  </tr>
<?php
// Variabel data
$totalHarga	= 0;
$totalBarang	= 0;
	
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
    <td><?php echo $myData['kd_pelanggan']."/ ".$myData['nm_pelanggan']; ?></td>
    <td><?php echo $myData['cara_bayar']; ?></td>
    <td><?php echo $myData['status_bayar']; ?></td>
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
