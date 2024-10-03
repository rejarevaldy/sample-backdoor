<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_minimal'] == "Yes") {

// Baca variabel URL browser
$kodeKat	 = isset($_GET['kodeKat']) ? $_GET['kodeKat'] : 'Semua'; 
// Baca variabel dari Form setelah di Post
$dataKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membuat Sub SQL dengan Filter
if(trim($dataKategori)=="Semua") {
	$filterSQL = "";
}
else {
	$filterSQL = "AND jenis.kd_kategori = '$dataKategori'";
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/barang_minimal.php?kodeKategori=$dataKategori', width=330)";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis WHERE stok <= stok_minimal $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die("Error paging:".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> LAPORAN DATA BARANG STOK MINIMAL/ LIMIT </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="84"><strong> Kategori </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="397">
	  <select name="cmbKategori">
        <option value="Semua">....</option>
        <?php
	  $bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori]</option>";
	  }
	  ?>
      </select>
      <input name="btnTampilkan" type="submit" value=" Tampilkan  "/>
      <input name="btnCetak" type="submit" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="958" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" rowspan="2" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="44" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="69" rowspan="2" bgcolor="#F5F5F5"><strong> Barcode </strong></td>
    <td width="329" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="129" rowspan="2" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>INFO STOK</strong></td>
    <td width="50" rowspan="2" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
  </tr>
  <tr>
    <td width="50" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="71" align="right" bgcolor="#F5F5F5"><strong>Opname</strong></td>
    <td width="71" align="right" bgcolor="#F5F5F5"><strong>Min</strong></td>
    <td width="72" align="right" bgcolor="#F5F5F5"><strong>Max</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT barang.*, jenis.nm_jenis FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
				WHERE barang.stok <= barang.stok_minimal
				$filterSQL 
				ORDER BY barang.kd_barang ASC LIMIT $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td> <?php echo $nomor; ?> </td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td> <?php echo $myData['barcode']; ?> </td>
    <td> <?php echo $myData['nm_barang']; ?> </td>
    <td> <?php echo $myData['nm_jenis']; ?> </td>
    <td align="right"><?php echo format_angka($myData['stok']); ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($myData['stok_opname']); ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($myData['stok_minimal']); ?></td>
    <td align="right"><?php echo format_angka($myData['stok_maksimal']); ?></td>
    <td><?php echo $myData['satuan']; ?> </td>
  </tr>
  <?php } ?>
  <tr class="selKecil">
    <td colspan="4"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="6" align="right">
	<strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Barang-Minimal&hal=$list[$h]&kodeKat=$dataKategori'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/barang_minimal.php?kodeKategori=<?php echo $dataKategori; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
