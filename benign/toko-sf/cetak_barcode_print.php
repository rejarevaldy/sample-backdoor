<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/bar128.php";
?>
<html>
<head>
<title> :: Cetak Label Barcode</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size:11px;
}
body {
	margin-top: 1px;
}
-->
</style>

</head>
<body>
<table class="table-list" width="200" border="0" cellspacing="40" cellpadding="4">
  <tr>
<?php
# JIKA MENEMUKAN CBKODE, salah satu Cekbox dipilih dan klik tombol Cetak Barcode
if(isset($_POST['cbKode']) and isset($_POST['cmbQty'])) {
	$cbKode = $_POST['cbKode'];
	$cmbQty = $_POST['cmbQty'];
	$jum  = count($cbKode);
	if($jum==0) {
		echo "BELUM ADA KODE BARANG YANG DIPILIH";
		echo "<meta http-equiv='refresh' content='1; url=index.php?open=Cetak-Barcode'>";
	}
	else {
		$no = 0; $lebar = 3;
		foreach($_POST['cbKode'] as $indeks => $nilai) {
			$qty	= $cmbQty[$nilai];
			
			$mySql = "SELECT * FROM barang WHERE kd_barang='$nilai'";
			$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$myData = mysql_fetch_array($myQry);
			for($i=1; $i <= $qty; $i++) {
				$no++;
			?>
				<td width="201" valign="top" align="center">
				TOKO FITRI
				<br>
				<?php 
					if($myData['barcode'] !="") {
						  echo $myData['nm_barang'];
						  echo "<br>Rp. ". format_angka($myData['harga_jual_4']);
						  echo bar128(stripslashes($myData['barcode'])); 
					} 
				?></td>
			<?php
				// Membuat TR tabel
				if ($no == $lebar) { echo "</tr>"; $lebar = $lebar + 3; }
			
			} // end for
			
		 }  // End foreach
	}
}
else {
	echo "BELUM ADA KODE BARANG YANG DIPILIH";
	echo "<meta http-equiv='refresh' content='1; url=index.php?open=Cetak-Barcode'>";
}?>
</table>
</body>
</html>