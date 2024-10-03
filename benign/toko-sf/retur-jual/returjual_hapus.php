<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_returjual'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
		
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM returjual WHERE no_returjual='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
			// Baca data dalam tabel anak (returjual_item)
			$bacaSql = "SELECT * FROM returjual_item WHERE no_returjual='$Kode'";
			$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca data".mysql_error());
			while($bacaData = mysql_fetch_array($bacaQry)) {
				$kodeBarang	= $bacaData['kd_barang'];
				$jumlah		= $bacaData['jumlah'];
				
				// Skrip Kembalikan Jumlah Stok, tidak jadi diretur, maka stok kembali ke Gudang Toko
				$stokSql = "UPDATE barang SET stok = stok + $jumlah WHERE kd_barang='$kodeBarang'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			}
			
			// Hapus data pada tabel anak (returjual_item)
			$mySql = "DELETE FROM returjual_item WHERE no_returjual='$Kode'";
			mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Returjual-Tampil'>";
		}
	}
	else {
		// Jika tidak ada data Kode ditemukan di URL
		echo "<b>Data yang dihapus tidak ada</b>";
	}
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
