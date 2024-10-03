<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_pelanggan'] == "Yes") {

// Membaca data  dari URL
$dataPelanggan	= isset($_GET['kodePlg']) ? $_GET['kodePlg'] : 'P001'; 
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

# MEMBUAT SQL FILTER PER BULAN & TAHUN
if($dataPelanggan and $dataTahun) {
	$filterSQL = "AND p.kd_pelanggan='$dataPelanggan' AND LEFT(p.tgl_penjualan,4)='$dataTahun'";
	
	// Mendapatkan informasi
	$infoSql = "SELECT * FROM pelanggan WHERE kd_pelanggan='$dataPelanggan'";
	$infoQry = mysql_query($infoSql, $koneksidb);
	$infoData= mysql_fetch_array($infoQry);
	$namaPelanggan = $infoData['kd_pelanggan']." / ".$infoData['nm_pelanggan'];
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Data Penjualan Barang Per Bulan/ Tahun - POS Distributor</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA PENJUALAN BARANG PER PELANGGAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td><?php echo $namaPelanggan; ?></td>
  </tr>
  <tr>
    <td width="134"><strong> Tahun  </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $dataTahun; ?></td>
  </tr>
</table>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="72" bgcolor="#F5F5F5"><strong>Tgl.Nota</strong></td>
    <td width="74" bgcolor="#F5F5F5"><strong>No. Nota </strong></td>
    <td width="60" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="353" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td width="110" align="right" bgcolor="#F5F5F5"><strong>Hrg. Jual (Rp) </strong></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
    <td width="115" align="right" bgcolor="#F5F5F5"><strong>Sub Total (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$subTotalHarga	= 0;
	$totalSemuaBarang= 0;
  	$totalSemuaHarga = 0; 
	
	// Skrip menampilkan data Barang dari tiap Transaksi Penjualan, dilengkapi filter Pelanggan
	$mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_jual, pi.jumlah 
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_penjualan = pi.no_penjualan
				$filterSQL
				ORDER BY p.no_penjualan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		# Hitung Baris Kanan (Sub Total)
		$subTotalHarga	= $myData['harga_jual'] * $myData['jumlah'];
		
		// Hitung Satu Kolom ke Bawah (Grand Total)
		$totalSemuaBarang	= $totalSemuaBarang + $myData['jumlah']; 
		$totalSemuaHarga	= $totalSemuaHarga + $subTotalHarga; 
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalHarga); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalSemuaBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalSemuaHarga); ?></strong></td>
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
