<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Set nilai pada filter
$filterSQL = ""; 

// Membaca data dari Pencarian
$kataKunci 	= isset($_GET['kataKunci']) ? $_GET['kataKunci'] : '';
$kataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $kataKunci;

// Tombol Cari Diklik
if (isset($_POST['btnCari'])) {
	// Query dan filter pencarian
	$cariSQL 	= " WHERE ( pelanggan.nm_pelanggan LIKE '%".$kataKunci."%' OR pelanggan.kd_pelanggan ='$kataKunci')";
}
else {
	$cariSQL 	= " WHERE  pelanggan.nm_pelanggan LIKE '%$kataKunci%' ";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$hal 		= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pelanggan $cariSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Pelanggan</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>PENCARIAN PELANGGAN </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0"  class="table-list">
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><strong>PENCARIAN DATA </strong></td>
      </tr>
      <tr>
        <td width="132"><strong>Kata Kunci </strong></td>
        <td width="11"><strong>:</strong></td>
        <td width="737"><input name="txtKataKunci" type="text" value="<?php echo $kataKunci; ?>" size="50" maxlength="100" />
            <input name="btnCari" type="submit"  value="Cari" /></td>
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
        <td width="53" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="284" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
        <td width="298" bgcolor="#CCCCCC"><strong>Alamat</strong></td>
        <td width="126" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
        <td width="79" align="right" bgcolor="#CCCCCC"><strong>Level Harga </strong></td>
      </tr>
      <?php
	// Skrip menampilkan data Pelanggan 
	$mySql 	= "SELECT * FROM pelanggan $cariSQL ORDER BY pelanggan.kd_pelanggan LIMIT $hal, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_pelanggan'];

		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_pelanggan']; ?></td>
        <td><a href="#" onClick="window.opener.document.getElementById('cmbPelanggan').value = '<?php echo $myData['kd_pelanggan']; ?>';
								 window.close();"><b><?php echo $myData['nm_pelanggan']; ?></b></a></td>
        <td><?php echo $myData['alamat']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td align="right"><?php echo $myData['level_harga']; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
        <td colspan="3" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='pencarian_pelanggan.php?hal=$list[$h]&kataKunci=$kataKunci'>$h</a> ";
	}
	?></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>