<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_rekap_periode'] == "Yes") {

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/rekap_penjualan_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}
?>
<h2>LAPORAN REKAP PENJUALAN PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="550" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="136"><strong>Periode Transaksi</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="395"><input name="txtTglAwal" type="text" class="tcal" id="txtTglAwal" value="<?php echo $tglAwal; ?>" size="20" maxlength="20" />
        s/d 
      <input name="txtTglAkhir" type="text" class="tcal" id="txtTglAkhir" value="<?php echo $tglAkhir; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " />
      <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<strong>Hasil Rekap Penjualan Barang per Periode </strong>, dari <b><?php echo $tglAwal; ?></b> s/d <b><?php echo $tglAkhir; ?></b><br />
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="59" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="444" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="162" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="84" align="right" bgcolor="#CCCCCC"><b>Qty Terjual </b></td>
  </tr>
  <?php
	// variabel
	$jumlahJual 	= 0;
	$jumlahBelanja 	= 0;
	
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
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right"><strong> TOTAL :</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahJual); ?></strong></td>
  </tr>
</table>
<a href="cetak/rekap_penjualan_periode.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
