<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses
if($aksesData['mu_data_merek'] == "Yes") {

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM merek";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA MEREK</b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Merek-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list"  width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <th width="3%"><strong>No</strong></th>
        <th width="5%"><strong>Kode</strong></th>
        <th width="68%"><strong>Nama Merek </strong></th>
        <th width="13%" align="right">Qty Barang </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
		<?php
		// Skrip menampilkan data dari database
		$mySql = "SELECT * FROM merek ORDER BY kd_merek ASC LIMIT $halaman, $baris";
		$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
		$nomor = 0; 
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_merek'];
			
			// Menghitung jumlah barang
			$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_merek='$Kode'";
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
			
			// gradasi warna
			if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_merek']; ?></td>
        <td><?php echo $myData['nm_merek']; ?></td>
        <td align="right"><?php echo format_angka($my2Data['qty_barang']); ?></td>
        <td width="6%" align="center"><a href="?open=Merek-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
        <td width="5%" align="center"><a href="?open=Merek-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA MEREK INI ... ?')">Delete</a></td>
      </tr>
	<?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td width="466"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td width="423" align="right"><strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Merek-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

