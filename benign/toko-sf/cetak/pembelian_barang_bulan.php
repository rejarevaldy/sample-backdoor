<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_barang_bulan'] == "Yes") {

// Baca variabel URL browser
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua'; 

// Membuat filter SQL
if ($kodeSupplier=="Semua") {
	//Query #1 (semua data)
	$filterSQL 		= "";
	$infoSupplier	= "";
}
else {
	//Query #2 (filter)
	$filterSQL 	= " AND p.kd_supplier ='$kodeSupplier'";
	
	// Membaca nama Supplier untuk informasi
	$infoSql	= "SELECT nm_supplier FROM supplier WHERE kd_supplier='$kodeSupplier'";
	$infoQry	= mysql_query($infoSql, $koneksidb);
	$infoData	= mysql_fetch_array($infoQry);
	$infoSupplier	= $infoData['nm_supplier'];
}

# =================================================================

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Membuat SQL Filter data
if($dataBulan and $dataTahun) {
	$filterData = $filterSQL."AND LEFT(p.tgl_pembelian,4)='$dataTahun' AND MID(p.tgl_pembelian,6,2)='$dataBulan'";
}
else {
	$filterData = $filterSQL;
}
?>
<html>
<head>
<title> :: Laporan Pembelian Barang per Bulan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN PEMBELIAN BARANG PER BULAN</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td><strong>Supplier</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoSupplier; ?></td>
  </tr>
  <tr>
    <td width="134"><strong> Bulan Penjualan </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $listBulan[$dataBulan]; ?>, <?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="24" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Tgl. Faktur </strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>No. Faktur </strong></td>
    <td width="46" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="341" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td width="95" align="right" bgcolor="#F5F5F5"><strong>PPN/PPH (Rp) </strong></td>
    <td width="108" align="right" bgcolor="#F5F5F5"><strong>Hrg. Beli (Rp) </strong></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
    <td width="120" align="right" bgcolor="#F5F5F5"><strong>Hrg. Total (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalHarga	= 0;
	$totalBarang= 0;
	
	// Skrip Menampilkan data Pembelian Item Barang dengan Filter Bulan
	$mySql = "SELECT p.no_pembelian, p.tgl_pembelian, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.jumlah, pi.ppn, 
				(pi.harga_beli * pi.jumlah) As total_harga
				FROM pembelian As p, pembelian_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_pembelian = pi.no_pembelian
				$filterData
				ORDER BY no_pembelian, kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		
		# Rekap data
		$ppn = $myData['harga_beli'] * $myData['jumlah'] * ($myData['ppn'] / 100);
		$totalHarga	= $totalHarga + $myData['total_harga'] + $ppn;  // Menghitung total modal beli
		$totalBarang= $totalBarang + $myData['jumlah'];   // Menghitung total barang terjual
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($ppn); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($myData['total_harga'] + $ppn); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right"><strong>GRAND TOTAL:</strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHarga); ?></strong></td>
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
