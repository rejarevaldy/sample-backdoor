<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_supplier'] == "Yes") {

// Baca variabel URL browser
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua'; 
// Baca variabel dari Form setelah di Post
$kodeSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;

// Membuat filter SQL
if ($kodeSupplier=="Semua") {
	//Query #1 (semua data)
	$filterSQL 	= "";
}
else {
	//Query #2 (filter)
	$filterSQL 	= " WHERE pembelian.kd_supplier ='$kodeSupplier'";
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pembelian_supplier.php?kodeSupplier=$kodeSupplier', width=330)";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembelian $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$baris);
?>
<h2>LAPORAN PEMBELIAN PER SUPPLIER</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="84"><strong> Supplier </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="397">
	  <select name="cmbSupplier">
          <option value="Semua">....</option>
          <?php
	  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_supplier'] == $kodeSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[kd_supplier] - $bacaData[nm_supplier]</option>";
	  }
	  ?>
        </select>
          <input name="btnTampilkan" type="submit" value=" Tampilkan  "/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnCetak" type="submit" value=" Cetak " /></td>
    </tr>
  </table>
</form>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="79" bgcolor="#CCCCCC"><strong>Tgl. Faktur </strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>No. Faktur </strong></td>
    <td width="179" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="244" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>PPN/PPH (Rp)</strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>Jumlah Brg</strong></td>
    <td width="125" align="right" bgcolor="#CCCCCC"><strong>Total Belanja (Rp) </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
  	// Variabel data
	$totalHarga	= 0;
	$totalBarang	= 0;
	
	// Skrip untuk menampilkan Transaksi Pembelian dengan Filter Supplier
	$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			$filterSQL 
			ORDER BY no_pembelian DESC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $halaman;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		# Membaca Kode pembelian/ Nomor transaksi
		$noNota = $myData['no_pembelian'];
		
		# Menghitung Total Tiap Transaksi
		$my2Sql = "SELECT SUM(harga_beli * jumlah) As total_belanja,
    SUM(jumlah) As total_barang ,
    SUM(harga_beli * jumlah *(ppn / 100)) AS ppn
						  FROM pembelian_item WHERE no_pembelian='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
		
	// Menjumlah Total Semua Transaksi yang ditampilkan
  $totalHarga	= $totalHarga + ($my2Data['total_belanja'] + $my2Data['ppn']) ;
  $totalBarang	= $totalBarang + $my2Data['total_barang'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
   <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo format_angka($my2Data['ppn']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja'] + $my2Data['ppn']); ?></td>
    <td width="37" align="center"><a href="cetak/pembelian_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totalHarga); ?></strong></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="6" align="right"><strong>Halaman ke :
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pembelian-Supplier&hal=$list[$h]&kodeSupplier=$kodeSupplier'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>

<a href="cetak/pembelian_supplier.php?kodeSupplier=<?php echo $kodeSupplier; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
