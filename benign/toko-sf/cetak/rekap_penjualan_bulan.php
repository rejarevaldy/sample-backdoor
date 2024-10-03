<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returjual_bulan'] == "Yes") {

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Sub SQL untuk filter data berdasarkan Bulan & Tahun
if($dataBulan and $dataTahun) {
	$filterSQL = "AND LEFT(p.tgl_penjualan,4)='$dataTahun' AND MID(p.tgl_penjualan,6,2)='$dataBulan'";
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Rekap Penjualan Barang per Bulan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN REKAP PENJUALAN BARANG PER BULAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="129"><strong> Bulan Transaksi </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="242"><?php echo $listBulan[$dataBulan]; ?>, <?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="59" bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="444" bgcolor="#F5F5F5"><b>Nama Barang </b></td>
    <td width="162" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="84" align="right" bgcolor="#F5F5F5"><b>Qty Terjual </b></td>
  </tr>
  <?php
	// variabel
	$jumlahJual = 0;
	$jumlahBelanja = 0;
	
	// Menampilkan daftar data penjualan
	$mySql = "SELECT barang.*, merek.nm_merek FROM barang LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				ORDER BY barang.kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_barang'];
		
		$my2Sql = "SELECT SUM(jumlah) As total_barang, SUM(harga_jual  * jumlah) As total_belanja 
				  FROM penjualan As p, penjualan_item As pi
				  WHERE p.no_penjualan = pi.no_penjualan AND pi.kd_barang ='$Kode' 
				  $filterSQL";
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		$jumlahJual = $jumlahJual + $my2Data['total_barang'];
		$jumlahBelanja = $jumlahBelanja + $my2Data['total_belanja'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right"><strong> TOTAL :</strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($jumlahJual); ?></strong></td>
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
