<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_jenis'] == "Yes") {
?>
<h2> LAPORAN DATA JENIS </h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="41" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="266" bgcolor="#CCCCCC"><b>Nama Jenis </b></td>
    <td width="265" bgcolor="#CCCCCC"><b>Kategori</b></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><b>Qty Barang </b> </td>
  </tr>
  <?php
	  // Menampilkan daftar jenis
	$mySql = "SELECT jenis.*, kategori.nm_kategori FROM jenis LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori ORDER BY jenis.kd_jenis ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_jenis'];
		
		// Menghitung jumlah barang per Jenis
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_jenis='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_jenis']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right"><?php echo $my2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>
<a href="cetak/jenis.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
