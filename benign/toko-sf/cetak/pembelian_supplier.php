<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_supplier'] == "Yes") {

# Temporary Variabel form
$kodeSupplier	= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : '';

if($_GET) {
	# PILIH KATEGORI
	if ($kodeSupplier =="Semua") {
		$filterSQL = "";
		$namaSupplier= "-";
	}
	else {
		$filterSQL = " WHERE pembelian.kd_supplier='$kodeSupplier'";
		
		// Mendapatkan informasi
		$infoSql = "SELECT * FROM supplier WHERE kd_supplier='$kodeSupplier'";
		$infoQry = mysql_query($infoSql, $koneksidb);
		$infoData= mysql_fetch_array($infoQry);
		$namaSupplier= $infoData['kd_supplier']." / ".$infoData['nm_supplier'];
	}
} // End GET
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Data Pembelian per Supplier  </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA PEMBELIAN PER SUPPLIER</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
  </tr>
  <tr>
    <td width="109"><b>Nama Supplier </b></td>
    <td width="15"><b>:</b></td>
    <td width="262"><?php echo $namaSupplier; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Tgl. Faktur </strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>No. Faktur </strong></td>
    <td width="152" bgcolor="#F5F5F5"><strong>Supplier</strong></td>
    <td width="251" bgcolor="#F5F5F5"><strong>Keterangan </strong></td>
    <td width="95" align="right" bgcolor="#F5F5F5"><strong>PPN/PPH (Rp) </strong></td>
    <td width="126" align="right" bgcolor="#F5F5F5"><strong>Jumlah Brg</strong></td>
    <td width="136" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp)</strong></td>
  </tr>
  <?php
// Variabel data
$totalHarga		= 0;
$totalBarang	= 0;

# Perintah untuk menampilkan pembelian dengan Filter Periode
$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier 
			$filterSQL ORDER BY no_pembelian DESC";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
$nomor = 0;
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$noNota	= $myData['no_pembelian'];
	
	# Menghitung Total Tiap Transaksi
	$my2Sql = "SELECT SUM(harga_beli * jumlah) As total_belanja,
					  SUM(jumlah) As total_barang,
            SUM(harga_beli * jumlah *(ppn / 100)) AS ppn
					  FROM pembelian_item WHERE no_pembelian='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	
	// Menjumlah Total Semua Transaksi yang ditampilkan
	$totalHarga	= $totalHarga + $my2Data['total_belanja']  + $my2Data['ppn'];
	$totalBarang	= $totalBarang + $my2Data['total_barang'];
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo  format_angka($my2Data['ppn']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right">Rp. <?php echo format_angka($my2Data['total_belanja'] + $my2Data['ppn']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBarang); ?></td>
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
