<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses
if($aksesData['mu_data_user'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		// Membaca URL
		$Kode	= $_GET['Kode'];
		
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM user WHERE kd_user='$Kode' AND username !='admin'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
		}
	}
	else {
		// Jika tidak ada data Kode ditemukan di URL
		echo "<b>Data yang dihapus tidak ada</b>";
	}
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
