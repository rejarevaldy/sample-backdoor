<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membaca data dari filter Supplier
$kodeSupp		= isset($_GET['kodeSupp']) ? $_GET['kodeSupp'] : "Semua";
$kodeSupplier 	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupp;

// Membaca data dari filter Kategori
$kodeKat		= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : "Semua";
$kodeKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membaca data dari Pencarian
$kataKunci 	= isset($_GET['kataKunci']) ? $_GET['kataKunci'] : '';
$kataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $kataKunci;

// Membuat Sub SQL dengan Filter
if(trim($kodeSupplier)=="Semua") {
	$filterSPL = "";
}
else {
	$filterSPL = "AND barang.kd_supplier = '$kodeSupplier'";
}

// Membuat Sub SQL dengan Filter
if(trim($kodeKategori)=="Semua") {
	$filterKAT = "";
}
else {
	$filterKAT = "AND jenis.kd_kategori = '$kodeKategori'";
}

# TOMBOL CARI DIKLIK
if (isset($_POST['btnCari'])) {
	// Query dan filter pencarian
	$cariSQL 	= $filterSPL.$filterKAT." AND ( barang.nm_barang LIKE '%".$kataKunci."%' OR barang.kd_barang ='$kataKunci' OR barang.barcode ='$kataKunci') ";
}
else {
	$cariSQL 	= $filterSPL.$filterKAT;
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql	= "SELECT * FROM barang, jenis WHERE barang.kd_jenis = jenis.kd_jenis $cariSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
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
    <td colspan="2"><table width="500" border="0"  class="table-list">
      <tr>
        <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      </tr>
      <tr>
        <td><strong>Supplier</strong></td>
        <td><strong>:</strong></td>
        <td><select name="cmbSupplier">
            <option value="Semua">- Semua -</option>
            <?php
			// Menampilkan data Supplier
	  $mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($kodeSupplier == $myData['kd_supplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_supplier]' $cek>$myData[nm_supplier]</option>";
	  }
	  ?>
        </select></td>
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
	  	echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori]</option>";
	  }
	  ?>
        </select></td>
      </tr>
      <tr>
        <td width="102"><strong>Kata Kunci </strong></td>
        <td width="11"><strong>:</strong></td>
        <td width="373"><input name="txtKataKunci" type="text" value="<?php echo $kataKunci; ?>" size="40" maxlength="100" />
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
        <td width="23" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="112" bgcolor="#CCCCCC"><strong>Barcode/ PLU</strong></td>
        <td width="355" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
        <td width="180" bgcolor="#CCCCCC"><strong>Merek</strong></td>
        <td width="32" align="center" bgcolor="#CCCCCC"><strong>Stok</strong></td>
        <td width="106" align="right" bgcolor="#CCCCCC"><strong>Hrg  Beli/Modal(Rp)</strong></td>
        </tr>
      <?php
	# MENJALANKAN QUERY FILTER DI ATAS
	$mySql 	= "SELECT barang.*, merek.nm_merek FROM jenis, barang
					LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
					WHERE barang.kd_jenis = jenis.kd_jenis
				$cariSQL
				ORDER BY barang.kd_barang LIMIT $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];

		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		
		// Warna peringatan Stok Opname
		if($myData['stok'] > 3) {
			$warna_stok	= "";
		}
		elseif($myData['stok'] >= 0) {
			$warna_stok	= "#FFCC00"; // Merah
		}
		else {
			$warna_stok	= "";
		}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td> 
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_modal']; ?>';
								 window.close();"> <b><?php echo $myData['kd_barang']; ?> </b> </a>		</td>
        <td>
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_modal']; ?>';
								 window.close();"> <b><?php echo $myData['barcode']; ?> </b> </a>		</td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['nm_merek']; ?></td>
        <td align="center" bgcolor="<?php echo $warna_stok; ?>"><?php echo $myData['stok']; ?></td>
        <td align="right"><?php echo format_angka($myData['harga_modal']); ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="4" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
        <td colspan="3" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='pencarian_barang.php?hal=$list[$h]&kodeSupp=$kodeSupplier&kodeKat=$kodeKategori&kataKunci=$kataKunci'>$h</a> ";
	}
	?></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>