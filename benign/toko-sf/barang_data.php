<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";
# Hak akses
if($aksesData['mu_data_barang'] == "Yes") {

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?><table width="950" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA BARANG</b></h1></td>
  </tr>
  <tr>
    <td width="401" colspan="2"><a href="?open=Barang-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="20" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
        <td width="48" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
        <td width="341" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
        <td width="31" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>Stok</strong></td>
        <td width="50" rowspan="2" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
        <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA MODAL </strong></td>
        <td colspan="4" align="center" bgcolor="#F5F5F5"><strong>HARGA JUAL </strong></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <tr>
                <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 1(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal 2(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal  3(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Modal  4(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 1(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level 2(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level  3(Rp)</strong></td>
        <td width="80" align="right" bgcolor="#F5F5F5"><strong>Level  4(Rp)</strong></td>
        </tr>
	<?php
	// Skrip menampilkan data dari database
	$mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
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
        <td align="center"><?php echo $myData['stok']; ?></td>
        <td><?php echo $myData['satuan']; ?></td>
        <td align="right"><?php echo format_angka($myData['harga_modal_1']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_modal_2']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_modal_3']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_modal_4']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_jual_1']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_jual_2']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_jual_3']); ?></td>
        <td align="right"><?php echo format_angka($myData['harga_jual_4']); ?></td>
        <td width="39" align="center"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
        <td width="39" align="center"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td align="right">
	<strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
