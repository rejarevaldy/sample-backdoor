<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_pembelian'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
		
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM pembelian WHERE no_pembelian='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
		
			// Baca data dalam tabel anak (pembelian_item)
			$bacaSql = "SELECT * FROM pembelian_item WHERE no_pembelian='$Kode'";
			$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca data".mysql_error());
			while($bacaData = mysql_fetch_array($bacaQry)) {
				$kodeBarang	= $bacaData['kd_barang'];
				$jumlah		= $bacaData['jumlah'];
				
				// Skrip Kembalikan Jumlah Stok
				$stokSql = "UPDATE barang SET stok = stok - $jumlah WHERE kd_barang='$kodeBarang'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			}
			
			// Hapus data pada tabel anak (pembelian_item)
			$mySql = "DELETE FROM pembelian_item WHERE no_pembelian='$Kode'";
			mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Pembelian-Tampil'>";
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
