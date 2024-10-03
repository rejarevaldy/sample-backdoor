<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Set nilai pada filter
$filterSql = ""; 

// Membaca data dari filter Kategori
$kodeKat		= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : "Semua";
$kodeKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membuat Sub SQL dengan Filter
if(trim($kodeKategori)=="Semua") {
	$filterSQL = "";
}
else {
	$filterSQL = "AND jenis.kd_kategori = '$kodeKategori'";
}

// Membaca data dari Pencarian
$kataKunci 	= isset($_GET['kataKunci']) ? $_GET['kataKunci'] : '';
$kataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $kataKunci;


# TOMBOL CARI DIKLIK
if (isset($_POST['btnCari'])) {
	// Query dan filter pencarian
	$cariSQL 	= " WHERE ( barang.nm_barang LIKE '%".$kataKunci."%' OR barang.kd_barang ='$kataKunci' OR barang.barcode ='$kataKunci')".$filterSQL;
}
else {
	$cariSQL 	= " WHERE  barang.nm_barang LIKE '%$kataKunci%' ".$filterSQL;
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$hal 		= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis $cariSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Barang</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css"></head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>PENCARIAN BARANG </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0"  class="table-list">
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><strong>PENCARIAN DATA </strong></td>
      </tr>
      <tr>
        <td><strong> Kategori </strong></td>
        <td><strong>:</strong></td>
        <td><select name="cmbKategori">
            <option value="Semua">- Semua -</option>
            <?php
			// Menampilkan data Kategori
	  $mySql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($kodeKategori == $myData['kd_kategori']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_kategori]' $cek> $myData[nm_kategori]</option>";
	  }
	  ?>
        </select></td>
      </tr>
      <tr>
        <td width="131"><strong>Kata Kunci </strong></td>
        <td width="11"><strong>:</strong></td>
        <td width="738"><input name="txtKataKunci" type="text" value="<?php echo $kataKunci; ?>" size="50" maxlength="100" />
            <input name="btnCari" type="submit"  value="Cari" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>* Kata Kunci: </strong>Kode/ Barcode/ Nama Barang </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="26" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="59" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="116" bgcolor="#CCCCCC"><strong>Barcode/ PLU</strong></td>
        <td width="390" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
        <td width="136" bgcolor="#CCCCCC"><strong>Jenis</strong></td>
        <td width="136" bgcolor="#CCCCCC"><strong>Merek</strong></td>
        </tr>
      <?php
	// Skrip menampilkan data Barang, informasinya lengkap dengan Merek dan Kategori
	$mySql 	= "SELECT barang.*, merek.nm_merek, jenis.nm_jenis FROM barang 
					LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
					LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				$cariSQL
				ORDER BY barang.kd_barang LIMIT $hal, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];

		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td> 
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.close();"> <b><?php echo $myData['kd_barang']; ?> </b> </a>		</td>
        <td>
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.close();"> <b><?php echo $myData['barcode']; ?> </b> </a>		</td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['nm_jenis']; ?></td>
        <td><?php echo $myData['nm_merek']; ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="4" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
        <td colspan="2" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='pencarian_barang.php?hal=$list[$h]&kodeKat=$kodeKategori&kataKunci=$kataKunci'>$h</a> ";
	}
	?></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>