<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_kategori'] == "Yes") {

// Membaca data dari filter Kategori
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : "Semua";
$dataKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

// Membaca data dari filter Jenis
$kodeJenis		= isset($_GET['kodeJenis']) ? $_GET['kodeJenis'] : "Semua";
$dataJenis 		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $kodeJenis;

// Membuat Sub SQL dengan Filter
if($dataKategori == "Semua") {
	$filterSQL = "";
}
else {
	if(trim($dataJenis)=="Semua") {
		$filterSQL = "WHERE jenis.kd_kategori = '$dataKategori'";
	}
	else {
		$filterSQL = "WHERE barang.kd_jenis = '$dataJenis'";
	}
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/barang_jenis.php?kodeJenis=$dataJenis', width=330)";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die("Error paging:".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<h2> LAPORAN DATA BARANG PER JENIS</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="125"><strong> Kategori &amp; Jenis  </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="356">
	  <select name="cmbKategori" onchange="javascript:submitform();" >
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
	  /
      <select name="cmbJenis">
        <option value="Kosong">....</option>
        <?php
			  $bacaSql = "SELECT * FROM jenis WHERE kd_kategori='$dataKategori' ORDER BY kd_jenis";
			  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
			  while ($bacaData = mysql_fetch_array($bacaQry)) {
				if ($bacaData['kd_jenis'] == $dataJenis) {
					$cek = " selected";
				} else { $cek=""; }
				echo "<option value='$bacaData[kd_jenis]' $cek> $bacaData[nm_jenis]</option>";
			  }
			  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampilkan" type="submit" value=" Tampilkan  "/>
        <input name="btnCetak" type="submit" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="20" rowspan="2" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="40" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="70" rowspan="2" bgcolor="#F5F5F5"><strong> Barcode </strong></td>
    <td width="285" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="130" rowspan="2" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="31" rowspan="2" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="48" rowspan="2" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
    <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA MODAL </strong></td>
    <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA JUAL </strong></td>
  </tr>
  <tr>
  <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 1(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 2(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 3(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 4(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 1(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 2(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 3(Rp)</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 4(Rp)</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT barang.*, jenis.nm_jenis, merek.nm_merek FROM barang 
				LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek 
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
    <td><?php echo $nomor; ?> </td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['barcode']; ?> </td>
    <td><?php echo $myData['nm_barang']; ?> </td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo $myData['stok']; ?> </td>
    <td><?php echo $myData['satuan']; ?> </td>
    <td align="right"><?php echo format_angka($myData['harga_modal_1']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal_2']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal_3']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal_4']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_1']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_2']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_3']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual_4']); ?></td>
  </tr>
  <?php } ?>
  <tr class="selKecil">
    <td colspan="4"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="12" align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Barang-Jenis&hal=$list[$h]&kodeKategori=$dataKategori&kodeJenis=$dataJenis'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/barang_jenis.php?kodeJenis=<?php echo $dataJenis; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
