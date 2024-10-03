<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_penjualan'] == "Yes") {

# Baca noNota dari URL
if(isset($_GET['noNota'])){
	$noNota = $_GET['noNota'];
	
	// Perintah untuk mendapatkan data dari tabel penjualan
	$mySql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan
				LEFT JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan 
				LEFT JOIN user ON penjualan.kd_user=user.kd_user 
				WHERE penjualan.no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
	
	// Menthitung Total Bayar pada Tabel Pembayaran (ada data jika Cara Bayar-nya Kredit)
	$my2Sql	= "SELECT SUM(total_bayar) As total_bayar FROM pembayaran_jual WHERE no_penjualan='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
	$my2Data = mysql_fetch_array($my2Qry);
	
	// Total Terbayar (total DP + Total Bayar angsur/Kredit)
	$totalTerbayar	= $myData['uang_bayar'] + $my2Data['total_bayar']; 
}
else {
	echo "Nomor Nota (noNota) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Penjualan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script></head>
<body onLoad="window.print()">
<table  class="table-list" width="450" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" align="center"><div align="center"><strong>CV. SF </strong><br />
        <strong>Distributor : </strong>Alat alat Listrik dan Pecah belah <br />
        <strong>Alamat : </strong>Manarap Baru Kab. Banjar <br />
Kalimantan Selatan Hp. 081213226184 </div></td>
  </tr>
  <tr>
    <td width="107"><strong>No. Nota </strong></td>
    <td width="328"> : <?php echo $myData['no_penjualan']; ?></td>
  </tr>
  <tr>
    <td><strong>Tgl. Nota </strong></td>
    <td>: <?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td>: <?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Pelanggan</strong></td>
    <td>: <?php echo $myData['kd_pelanggan']."/".$myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Cara Bayar </strong></td>
    <td>: <?php echo $myData['cara_bayar']; ?></td>
  </tr>
  <tr>
    <td><strong>Status </strong></td>
    <td>: <?php echo $myData['status_bayar']; ?></td>
  </tr>
  <tr>
    <td><strong>Operator</strong></td>
    <td>: <?php echo $myData['nm_user']; ?></td>
  </tr>
</table>

<table class="table-list" width="450" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="245" bgcolor="#F5F5F5"><strong> Barang </strong></td>
    <td width="61" align="right" bgcolor="#F5F5F5"><strong>PPN (Rp)</strong></td>
    <td width="61" align="right" bgcolor="#F5F5F5"><strong>Harga (Rp)</strong></td>
    <td width="27" align="right" bgcolor="#F5F5F5"><strong>Qty</strong></td>
    <td width="101" align="right" bgcolor="#F5F5F5"><strong>Subtotal(Rp) </strong></td>
  </tr>
<?php
# Baca variabel
$totalBayar = 0; 
$jumlahBarang = 0;  
$uangKembali=0;

# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
$notaSql = "SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
			LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
			WHERE penjualan_item.no_penjualan='$noNota'
			ORDER BY barang.kd_barang ASC";
$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list salah : ".mysql_error());
$nomor  = 0;  
while($notaData = mysql_fetch_array($notaQry)) {
	$nomor++;
	//$hargaDiskon	= $notaData['harga_jual'] - ( $notaData['harga_jual'] * $notaData['diskon']/100);
	$ppn 			= $notaData['harga_jual'] * ($notaData['ppn'] / 100);
	$subSotal 	= $notaData['jumlah'] * ($notaData['harga_jual'] + $ppn);
	$totalBayar	= $totalBayar + $subSotal;
	$jumlahBarang = $jumlahBarang + $notaData['jumlah'];
	$uangKembali= $myData['uang_bayar'] - $totalBayar;
?>
  <tr>
    <td><?php echo $notaData['kd_barang']; ?>/ 
    <?php echo $notaData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($ppn * $notaData['jumlah']) ?></td>
    <td align="right"><?php echo format_angka($notaData['harga_jual']); ?></td>
    <td align="right"><?php echo $notaData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" align="right"><strong>Total Belanja (Rp) : </strong></td>
    <td colspan="2" align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><strong> Uang Bayar (Rp) : </strong></td>
    <td colspan="2" align="right"><?php echo format_angka($myData['uang_bayar']); ?></td>
  </tr>
  <?php 
  if($myData['cara_bayar']=="Tunai") {
  ?>
  <tr>
    <td colspan="3" align="right"><strong>Uang Kembali (Rp) : </strong></td>
    <td colspan="2" align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($uangKembali); ?></strong></td>
  </tr>
  <?php 
  }
  if($myData['cara_bayar']=="Kredit") {
		// Menghitung Total Hutang ( Total Belanja - Total Terbayar Kredit yang sudah dilakukan )
	  $totalHutang	= $totalBayar - $totalTerbayar;
  ?>
  <tr>
    <td colspan="3" align="right"><strong>Total Hutang  (Rp) : </strong></td>
    <td colspan="2" align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHutang); ?></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="center">*** Terimakasih Telah Berbelanja *** </td>
  </tr>
</table>
</body>
</html>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
