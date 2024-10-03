<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_bulan'] == "Yes") {

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

# MEMBUAT SQL FILTER PER BULAN & TAHUN
if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "AND LEFT(tgl_penjualan,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "AND LEFT(tgl_penjualan,4)='$dataTahun' AND MID(tgl_penjualan,6,2)='$dataBulan'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Laba/Rugi Penjualan Barang per Bulan/ Tahun </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN LABA/RUGI PENJUALAN BARANG PER BULAN/ TAHUN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong> Bulan/ Tahun  </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="1006" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="65" bgcolor="#F5F5F5"><strong>Tgl. Nota </strong></td>
    <td width="65" bgcolor="#F5F5F5"><strong>No. Nota </strong></td>
    <td width="50" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="355" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td width="115" align="right" bgcolor="#F5F5F5"><strong>Hrg. Modal (Rp)</strong></td>
    <td width="116" align="right" bgcolor="#F5F5F5"><strong>Hrg. Jual (Rp) </strong></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
    <td width="122" align="right" bgcolor="#F5F5F5"><strong>Laba/Rugi (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$untungRugi 	= 0;
	$totalHrgModal	= 0;
	$totalHrgJual	= 0;
  	$totalRugiLaba	= 0; 
	$totalBarang	= 0;
	
	// Skrip menampilkan data Penjualan per Item Barang dengan filter Bulan
	$mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_modal, pi.harga_jual, pi.jumlah 
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_penjualan = pi.no_penjualan
				$filterSQL
				ORDER BY no_penjualan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		# Hitung
		$untungRugi		= $myData['harga_jual'] - $myData['harga_modal'];
		$totalHrgModal	= $totalHrgModal + ( $myData['harga_modal'] * $myData['jumlah']);  // Menghitung total modal beli
		$totalHrgJual	= $totalHrgJual + ( $myData['harga_jual'] * $myData['jumlah']);  // Menghitung total harga jual
		$totalBarang	= $totalBarang + $myData['jumlah'];  // Menghitung total barang terjual
		$totalRugiLaba  =  $totalHrgJual - $totalHrgModal;  // Menghitung total Laba/Rugi (selish harga beli dan penjualan)
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($untungRugi); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong>GRAND TOAL  : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHrgModal); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHrgJual); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalRugiLaba); ?></strong></td>
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
