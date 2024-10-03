<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses
if($aksesData['mu_data_merek'] == "Yes") {

	// Membaca data dari URL
	$Kode	= $_GET['Kode'];
	if(isset($Kode)){
		// Skrip menghapus data dari tabel database
		$mySql = "DELETE FROM merek WHERE kd_merek='$Kode'";
		mysql_query($mySql, $koneksidb) or die ("Error query".mysql_error());
		
		// Refresh
		echo "<meta http-equiv='refresh' content='0; url=?open=Merek-Data'>";
	}
	else {
		echo "Data yang dihapus tidak ada";
	}
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
