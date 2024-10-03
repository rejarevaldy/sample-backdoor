<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_barcode'] == "Yes") {

// Membaca data dari filter Kategori
$kodeKat		= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : "Semua";
$dataKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membaca data dari filter Jenis
$kodeJenis		= isset($_GET['kodeJenis']) ? $_GET['kodeJenis'] : "Semua";
$dataJenis 		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $kodeJenis;

// Membaca data dari filter Merek
$kodeMerek		= isset($_GET['kodeMerek']) ? $_GET['kodeMerek'] : "Semua";
$dataMerek 		= isset($_POST['cmbMerek']) ? $_POST['cmbMerek'] : $kodeMerek;

// Membuat Sub SQL dengan Filter
if(trim($dataJenis)=="Semua") {
	// Jenis tidak dipilih
	
	if(trim($dataMerek)=="Semua") {
		// Merek juga tidak dipilih
		$filterSQL = "";
	}
	else {
		// Merek dipilih
		$filterSQL = "AND barang.kd_merek = '$dataMerek'";
	}
}
else {
	// Jenis dipilih
	
	if(trim($dataMerek)=="Semua") {
		// Merek tidak dipilih
		$filterSQL = "AND barang.kd_jenis = '$dataJenis'";
	}
	else {
		$filterSQL = "AND barang.kd_jenis = '$dataJenis' AND barang.kd_merek = '$dataMerek'";
	}
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang, merek WHERE barang.kd_merek = merek.kd_merek $filterSQL"; 
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<h2> TOOL BARCODE </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="134"><strong>Kategori/ Jenis</strong></td>
      <td width="13"><strong>:</strong></td>
      <td width="339"><select name="cmbKategori" onchange="javascript:submitform();" >
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
          <option value="Semua">....</option>
          <?php
			  $bacaSql = "SELECT * FROM jenis WHERE kd_kategori='$dataKategori' ORDER BY nm_jenis";
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
      <td><strong>Merek</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbMerek">
          <option value="Semua">....</option>
          <?php
			  $bacaSql = "SELECT * FROM merek ORDER BY nm_merek";
			  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
			  while ($bacaData = mysql_fetch_array($bacaQry)) {
				if ($bacaData['kd_merek'] == $dataMerek) {
					$cek = " selected";
				} else { $cek=""; }
				echo "<option value='$bacaData[kd_merek]' $cek> $bacaData[nm_merek]</option>";
			  }
			  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value="Tampil" /></td>
    </tr>
  </table>
</form>

<form action="cetak_barcode_print.php" method="post" name="form2" target="_blank">
<table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="11" align="right"><input name="btnCetak" type="submit" id="btnCetak" value=" Cetak Barcode " /></td>
    </tr>
  <tr>
    <td width="24" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="53" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="215" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td width="212" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="206" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td width="30" align="center" bgcolor="#F5F5F5"><strong>Cek</strong></td>
    <td width="45" align="center" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="46" bgcolor="#F5F5F5"><strong>Lokasi</strong></td>
    <td width="29" bgcolor="#F5F5F5"><strong>Rak</strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
    </tr>
  <?php
	# Menampilkan Data Barang dari Database, dengan filter data dari form
	$mySql = "SELECT barang.*, merek.nm_merek, jenis.nm_jenis FROM merek, barang 
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				WHERE barang.kd_merek = merek.kd_merek 
			 $filterSQL ORDER BY barang.kd_barang ASC LIMIT $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
    <td align="center">
      <select name="cmbQty[<?php echo $Kode; ?>]">
	  <?php
	  // Membuat pilihan berupa jumlah stok
	  for($qty=1; $qty <= $myData['stok']; $qty++) {
	  	echo "<option value='$qty' $cek>$qty</option>";
	  }
	  ?>
      </select>      </td>
    <td><?php echo $myData['lokasi_stok']; ?></td>
    <td><?php echo $myData['lokasi_rak']; ?></td>
    <td width="39" align="center"><a href="barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank">View</a></td>
    <td width="45" align="center"><a href="barcode128_print.php?Kode=<?php echo $Kode; ?>" target="_blank"><img src="images/btn_barcode.png" width="22"  border="0" /></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
    <td colspan="6" align="right"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Cetak-Barcode&hal=$list[$h]&kodeKat=$dataKategori&kodeJenis=$dataJenis&kodeMerek=$dataMerek'>$h</a> ";
	}
	?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td colspan="6" align="right"><input name="btnCetak" type="submit" value=" Cetak Barcode " /></td>
  </tr>
</table>
<p><strong>* Note:</strong> Centang dulu pada <strong>Cek</strong>, baru pilih jumlah <strong>Stok</strong> (jumlah barcode yang dibuat) </p>
</form>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
