<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if(isset($_POST['btnSimpan'])){
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>Kode Barang</b> tidak terbaca !";		
	}
	if (trim($_POST['txtStokOpname'])=="" or ! is_numeric(trim($_POST['txtStokOpname']))) {
		$pesanError[] = "Data <b>Stok Opname</b> jual tidak boleh kosong, harus diisi angka atau 0 !";		
	}
	if (trim($_POST['txtStokOpname']) > trim($_POST['txtStok'])) {
		$pesanError[] = "Data <b>Stok Opname</b> melebihi jumlah <b>Stok</b>, harus lebih kecil !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# Baca Variabel Form
		$txtKode		= $_POST['txtKode'];
		$txtStokOpname	= $_POST['txtStokOpname'];

		# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
		$mySql	= "UPDATE barang SET stok_opname='$txtStokOpname' WHERE kd_barang ='$txtKode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=barang_stok_edit.php?Kode=$txtKode'>";
		}
		exit;
	}	
} // Penutup POST

# JIKA MENDAPATKAN VARIABEL Kode DARI URL
if(isset($_GET['Kode'])) {
	// Mengambil data barang yang sedang diedit
	$Kode	 = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT barang.*, kategori.nm_kategori FROM barang  
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				WHERE barang.kd_barang='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	
		// Masukkan data ke variabel
		$dataKode	= $myData['kd_barang'];
		$dataStokOpname	= isset($_POST['txtStokOpname']) ?  $_POST['txtStokOpname'] : $myData['stok_opname'];
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Stok Opname - INVENTORY TOKO</title>
<link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#CCCCCC"><strong>UBAH STOK OPNAME </strong></td>
	</tr>
	<tr>
	  <td width="14%"><b>Kode Barang </b></td>
	  <td width="1%"><b>:</b></td>
    <td width="85%"><?php echo $myData['kd_barang']; ?>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
      <td><b>Barcode</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['barcode']; ?></td>
    </tr>
	<tr>
	  <td><b>Nama  Barang </b></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['nm_barang']; ?></td></tr>
	<tr>
      <td><b>kategori</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['nm_kategori']; ?></td>
    </tr>
	<tr>
      <td><b>Stok</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['stok']; ?>
      <input name="txtStok" type="hidden" value="<?php echo $myData['stok']; ?>" /></td>
    </tr>
	<tr>
      <td><b>Stok Opname </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtStokOpname" value="<?php echo $dataStokOpname; ?>" size="10" maxlength="30" /></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
</body>
</html>
<p><strong>* Note:</strong>
<ul>
  <li><strong>Stok :</strong> adalah jumlah barang keseluruhan, baik yang bisa dijual dan rusak (opname)</li>
  <li><strong>Stok Opname :</strong> adalah jumlah barang yang bisa dijual, barang ready.   </li>
</ul>
</p>