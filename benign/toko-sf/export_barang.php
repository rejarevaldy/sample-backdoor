<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_export_barang'] == "Yes") {

// Membaca form
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataJenis	    = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';

# TOMBOL EXPORT DIKLIK
if(isset($_POST['btnExport'])){
	// menjalankan skrip Export
	echo "<script>";
	echo "window.open('export/export_barang_xls.php?kodeKategori=$dataKategori&kodeJenis=$dataJenis')";
	echo "</script>";
}

?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#CCCCCC"><strong>EXPORT DATA BARANG </strong></td>
    </tr>
	<tr>
      <td><strong>Kategori </strong></td>
	  <td><strong>:</strong></td>
	  <td><select name="cmbKategori" onchange="javascript:submitform();" >
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
        </select></td>
	</tr>
	<tr>
	  <td width="18%"><strong>Jenis Barang </strong></td>
	  <td width="1%"><b>:</b></td>
	  <td width="81%">
	    <select name="cmbJenis">
          <option value="Semua">....</option>
          <?php
	  $bacaSql = "SELECT * FROM jenis WHERE kd_kategori='$dataKategori' ORDER BY kd_jenis";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jenis'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_jenis]' $cek>$bacaData[nm_jenis]</option>";
	  }
	  ?>
        </select>
	    <input type="submit" name="btnExport" value=" EXPORT FILE " style="cursor:pointer;" />
	  	  </td>
    </tr>
</table>
</form>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
