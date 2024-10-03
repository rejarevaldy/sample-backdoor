<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

# Membaca kata kunci dari URL dan FORM
$kataKunci 		= isset($_GET['kataKunci']) ? $_GET['kataKunci'] : '';
$dataKataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $kataKunci;


# PENCARIAN DATA 
if(isset($dataKataKunci)) {
	// SQL Filter
	$filterSQL 	= "AND ( kd_barang='$dataKataKunci' 
						OR barcode ='$dataKataKunci' 
						OR nm_barang LIKE '%$dataKataKunci%'";

	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $dataKataKunci);
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			// SQL Sub Filter per potong kata
			$filterSQL	.= " OR nm_barang LIKE'%$kata%'";
		}
	}
	$filterSQL	.= " ) ";
	
}
else {
	//Query #1 (all)
	$filterSQL 	= "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM merek, barang WHERE barang.kd_merek = merek.kd_merek $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error $pageSql: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="1100" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>PENCARIAN BARANG</b></h1></td>
  </tr>
  <tr>
    <td colspan="2">
	  <table width="500" border="0"  class="table-list">
		<tr>
		  <td width="151" bgcolor="#F5F5F5"><strong>PENCARIAN  </strong></td>
		  <td width="10">&nbsp;</td>
		  <td width="330">&nbsp;</td>
		</tr>
		<tr>
		  <td><strong>Nama Barang  </strong></td>
		  <td><strong>:</strong></td>
		  <td><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100" />
		    <input name="btnCari" type="submit" value="Cari" /></td>
		  </tr>
	  </table>	</td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="22" rowspan="2" bgcolor="#F5F5F5"><strong>No</strong></td>
        <td width="53" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
        <td width="300" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
        <td width="130" rowspan="2" bgcolor="#F5F5F5"><strong>Merek</strong></td>
        <td width="129" rowspan="2" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
        <td colspan="3" align="center" bgcolor="#F5F5F5"><strong>STOK</strong></td>
        <td colspan="4" rowspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><strong></strong></td>
      </tr>
      <tr>
        <td width="60" align="center" bgcolor="#F5F5F5"><strong>Stok</strong></td>
        <td width="59" bgcolor="#F5F5F5"><strong>Lokasi</strong></td>
        <td width="60" bgcolor="#F5F5F5"><strong>Rak</strong></td>
        </tr>
      <?php
	# MENJALANKAN QUERY FILTER DI ATAS
	$mySql 	= "SELECT barang.*, merek.nm_merek, jenis.nm_jenis FROM merek, barang 
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				WHERE barang.kd_merek = merek.kd_merek 
			 	$filterSQL
				ORDER BY barang.kd_barang ASC LIMIT $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];

		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		
		// warna merah jika harga Jual lebih kecil dari harga Beli (rugi)
		if($myData['harga_modal'] >= $myData['harga_jual_1']
		or $myData['harga_modal'] >= $myData['harga_jual_2']
		or $myData['harga_modal'] >= $myData['harga_jual_3']) {
			$merah	= "#FF0000";
		}
		else { $merah= $warna; }
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_barang']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['nm_merek']; ?></td>
        <td><?php echo $myData['nm_jenis']; ?></td>
        <td align="center"><?php echo $myData['stok']; ?></td>
        <td><?php echo $myData['lokasi_stok']; ?></td>
        <td><?php echo $myData['lokasi_rak']; ?></td>
        <td width="40" align="center"><a href="barcode128_print.php?Kode=<?php echo $Kode; ?>" target="_blank"><img src="images/btn_barcode.png" width="22"  border="0" /></a><a href="barcode128_print.php?Kode=<?php echo $Kode; ?>" target="_blank"></a></td>
        <td width="40" align="center"><a href="barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank">View</a></td>
        <td width="40" align="center"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_blank" alt="Edit Data">Edit</a></td>
        <td width="40" align="center"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_blank" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="5" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
        <td colspan="7" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Barang-Cari&hal=$list[$h]&kataKunci=$dataKataKunci'>$h</a> ";
	}
	?></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
