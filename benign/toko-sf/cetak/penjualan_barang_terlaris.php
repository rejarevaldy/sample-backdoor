<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_terlaris'] == "Yes") {

// Membaca Jumlah Terlaris
$dataJumlah = isset($_GET['jumlah']) ? $_GET['jumlah'] : 10;

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

# MEMBUAT FILTER BERDASARKAN TANGGAL & TAHUN
if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "AND LEFT(p.tgl_penjualan,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "AND LEFT(p.tgl_penjualan,4)='$dataTahun' AND MID(p.tgl_penjualan,6,2)='$dataBulan'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$infoBulan	= "";
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Penjualan Barang Terlaris - POS Distributor</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN  PENJUALAN <b><?php echo $dataJumlah; ?></b> BARANG TERLARIS </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="148"><strong> Periode Bulan/Tahun</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="223"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="55"  bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="429" bgcolor="#F5F5F5"><b>Nama Barang </b></td>
    <td width="140" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
    <td width="119" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="101" align="right" bgcolor="#F5F5F5"><b>Total Terjual </b></td>
  </tr>
  <?php
	// variabel
	$jumlahJual = 0;
	
	// Menampilkan daftar Barang yang dibeli pada Bulan terpilih
	$mySql = "SELECT barang.kd_barang, barang.nm_barang, jenis.nm_jenis, merek.nm_merek, SUM(pi.jumlah) As total_terjual
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang= barang.kd_barang
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				WHERE p.no_penjualan = pi.no_penjualan 
				$filterSQL
				GROUP BY barang.kd_barang ORDER BY total_terjual DESC
				LIMIT $dataJumlah";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// Menghitung Total
		$jumlahJual = $jumlahJual + $myData['total_terjual'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($myData['total_terjual']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong> GRAND TOTAL :</strong></td>
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
