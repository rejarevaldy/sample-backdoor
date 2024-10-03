<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Set nilai pada filter
$filterSql = ""; 
 
// Membaca data Level Plg dari URL
$dataLevel		= isset($_GET['levelPlg']) ? $_GET['levelPlg'] : '4';

// Membaca data dari filter Pelanggan
$kodePelanggan	= isset($_GET['kodePelanggan']) ? $_GET['kodePelanggan'] : 'P001';

// Membaca data dari filter Kategori
$kodeKat		= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : "Semua";
$kodeKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membaca data dari Pencarian
$kataKunci 	= isset($_GET['kataKunci']) ? $_GET['kataKunci'] : '';
$kataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $kataKunci;

// Membuat Sub SQL dengan Filter
if(trim($kodeKategori)=="Semua") {
	$filterSql = "";
}
else {
	$filterSql = "AND jenis.kd_kategori = '$kodeKategori'";
}

# TOMBOL CARI DIKLIK
if (isset($_POST['btnCari'])) {
	// Query dan filter pencarian
	$cariSql 	= $filterSql." AND ( barang.nm_barang LIKE '%".$kataKunci."%' OR barang.kd_barang ='$kataKunci' OR barang.barcode ='$kataKunci') ";
}
else {
	$cariSql 	= $filterSql;
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;  // Jumlah baris data
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql= "SELECT * FROM barang, jenis WHERE barang.kd_jenis = jenis.kd_jenis $cariSql";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Barang</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="1000" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>PENCARIAN BARANG </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><table width="500" border="0"  class="table-list">
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER PENCARIAN </strong></td>
      </tr>
      <tr>
        <td><strong> Kategori </strong></td>
        <td><strong>:</strong></td>
        <td><select name="cmbKategori">
            <option value="Semua">- Semua -</option>
            <?php
			// Skrip Menampilkan data Kategori ke List/Menu (ComboBox)
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
        <td width="23" rowspan="2" bgcolor="#F5F5F5"><strong>No</strong></td>
        <td width="45" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
        <td width="95" rowspan="2" bgcolor="#F5F5F5"><strong>Barcode/ PLU</strong></td>
        <td width="286" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
        <td width="138" rowspan="2" bgcolor="#F5F5F5"><strong>Merek</strong></td>
        <td width="32" rowspan="2" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
        <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA JUAL</strong></td>
        </tr>
      <tr>
        <td width="81" align="right" bgcolor="#F5F5F5"><strong>Level 1(Rp)</strong></td>
        <td width="81" align="right" bgcolor="#F5F5F5"><strong>Level 2(Rp)</strong></td>
        <td width="81" align="right" bgcolor="#F5F5F5"><strong>Level 3(Rp)</strong></td>
        <td width="81" align="center" bgcolor="#F5F5F5"><strong>Level 4(Rp)</strong></td>
      </tr>
      <?php
	  // Informasi Pelanggan
	  //$infoSql	= "SELECT * FROM pelanggan WHERE kd_pelanggan='$kodePelanggan'";
	  //$infoQry 	= mysql_query($infoSql, $koneksidb)  or die ("Query info salah : ".mysql_error());
	  ///$infoData = mysql_fetch_array($infoQry);
	  //$infoLevel= $infoData['level_harga'];
	  
	// Skrip menampilkan Data Barang hasil dari Filter dan Pencarian
	$mySql 	= "SELECT barang.*, merek.nm_merek FROM jenis, barang
					LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
					WHERE barang.kd_jenis = jenis.kd_jenis
				$cariSql
				ORDER BY barang.kd_barang LIMIT $hal, $row"; 
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = $hal; 
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
		
		// Level Harga
		if($dataLevel == 1) {
			$hargaJual	= $myData['harga_jual_1'];
		}
		elseif($dataLevel == 2) {
			$hargaJual	= $myData['harga_jual_2'];
		}
		elseif($dataLevel == 3) {
			$hargaJual	= $myData['harga_jual_3'];
		}
		elseif($dataLevel == 4) {
			$hargaJual	= $myData['harga_jual_4'];
		}
		else {
			$hargaJual	= $myData['harga_jual_4'];
		}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td> 
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $hargaJual; ?>';
								 window.close();"> <b><?php echo $myData['kd_barang']; ?> </b> </a>		</td>
        <td> <?php echo $myData['barcode']; ?> </td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['nm_merek']; ?></td>
        <td align="right" bgcolor="<?php echo $warna_stok; ?>"><?php echo $myData['stok']; ?></td>
        <td align="right">
		<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_jual_1']; ?>';
								 window.close();"> <?php echo format_angka($myData['harga_jual_1']); ?>  </a> </td>
        <td align="right">
		<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_jual_2']; ?>';
								 window.close();"> <?php echo format_angka($myData['harga_jual_2']); ?>  </a> </td>
        <td align="right">
		<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_jual_3']; ?>';
								 window.close();"> <?php echo format_angka($myData['harga_jual_3']); ?>  </a> </td>
        <td align="right"> 
		<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_jual_4']; ?>';
								 window.close();"> <?php echo format_angka($myData['harga_jual_4']); ?>  </a> </td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="4" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
        <td colspan="6" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
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