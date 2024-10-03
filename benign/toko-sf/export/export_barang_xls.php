<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# JIKA DATA KODE FILTER DIDAPAT
if(isset($_GET['kodeKategori']) and isset($_GET['kodeJenis'])) {
	
	# Membaca data dari form
	$dataKategori		= $_GET['kodeKategori'];
	$dataJenis			= $_GET['kodeJenis'];

	# FORMAT EXCEL
	function xlsBOF() {
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}
	
	function xlsEOF() {
		echo pack("ss", 0x0A, 0x00);
		return;
	}
	
	function xlsWriteNumber($Row, $Col, $Value) {
		echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
		echo pack("d", $Value);
		return;
	}
	
	function xlsWriteLabel($Row, $Col, $Value ) {
		$L = strlen($Value);
		echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
		echo $Value;
		return;
	}
	
		
	xlsBOF();
	xlsWriteLabel(0,1,"DATA BARANG" );
	
	xlsWriteLabel(1,0, "Kode" );
	xlsWriteLabel(1,1, "Barcode" );
	xlsWriteLabel(1,2, "Nama Barang");
	xlsWriteLabel(1,3, "Keterangan");
	xlsWriteLabel(1,4, "Satuan" );
	xlsWriteLabel(1,5, "Hrg Modal" );
	xlsWriteLabel(1,6, "HrgJual 1" );
	xlsWriteLabel(1,7, "HrgJual 2" );
	xlsWriteLabel(1,8, "HrgJual 3" );
	xlsWriteLabel(1,9, "HrgJual 4" );
	xlsWriteLabel(1,10, "Stok" );
	xlsWriteLabel(1,11, "Stok Op" );
	xlsWriteLabel(1,12, "Stok Min " );
	xlsWriteLabel(1,13, "Stok Max" );
	xlsWriteLabel(1,14, "LokasiStok" );
	xlsWriteLabel(1,15, "LokasiRak" );
	xlsWriteLabel(1,16, "KodeMerek " );
	xlsWriteLabel(1,17, "KodeJenis" );
	xlsWriteLabel(1,18, "KodeSupplier" );
	$xlsRow = 2;

	header("Pragma: public" );
	header("Expires: 0" );
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
	header("Content-Type: application/force-download" );
	header("Content-Type: application/octet-stream" );
	header("Content-Type: application/download" );;
	header("Content-Disposition: attachment;filename=barang.xls " );
	header("Content-Transfer-Encoding: binary " );
		
	// Membuat Sub SQL dengan Filter
	if(trim($dataKategori)=="Semua") {
		$filterSQL = "";
	}
	else {
		// KATEGORI DIPILIH
		if(trim($dataJenis)=="Semua") {
			// Jika Jenis Tidak dipilih
			$filterSQL = "WHERE jenis.kd_kategori = '$dataKategori'";
		}
		else {
			// Jika Jenis Dipilih
			$filterSQL = "WHERE barang.kd_jenis = '$dataJenis'";
		}
	}

	# Skrip enampilkan Semua Daftar Barang
	$bacaSql 	= "SELECT barang.* FROM barang LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
						$filterSQL ORDER BY barang.kd_barang ";
	$bacaQry = mysql_query($bacaSql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($bacaData = mysql_fetch_array($bacaQry)) {
		$nomor++;
		
		// Menulis hasil data ke Excel
		xlsWriteLabel($xlsRow,0, $bacaData['kd_barang']); 
		xlsWriteLabel($xlsRow,1, $bacaData['barcode']); 
		xlsWriteLabel($xlsRow,2, $bacaData['nm_barang']); 
		xlsWriteLabel($xlsRow,3, $bacaData['keterangan']); 
		xlsWriteLabel($xlsRow,4, $bacaData['satuan']); 
		xlsWriteLabel($xlsRow,5, $bacaData['harga_modal']); 
		xlsWriteLabel($xlsRow,6, $bacaData['harga_jual_1']); 
		xlsWriteLabel($xlsRow,7, $bacaData['harga_jual_2']); 
		xlsWriteLabel($xlsRow,8, $bacaData['harga_jual_3']); 
		xlsWriteLabel($xlsRow,9, $bacaData['harga_jual_4']); 
		xlsWriteLabel($xlsRow,10, $bacaData['stok']); 
		xlsWriteLabel($xlsRow,11, $bacaData['stok_opname']); 
		xlsWriteLabel($xlsRow,12, $bacaData['stok_minimal']); 
		xlsWriteLabel($xlsRow,13, $bacaData['stok_maksimal']); 
		xlsWriteLabel($xlsRow,14, $bacaData['lokasi_stok']); 
		xlsWriteLabel($xlsRow,15, $bacaData['lokasi_rak']); 
		xlsWriteLabel($xlsRow,16, $bacaData['kd_merek']); 
		xlsWriteLabel($xlsRow,17, $bacaData['kd_jenis']); 
		xlsWriteLabel($xlsRow,18, $bacaData['kd_supplier']); 
		
		$xlsRow++;
	}
	
	// Tutup file Excel
	xlsEOF();
			
	echo "<meta http-equiv='refresh' content='5; url=?open=Export-Barang'>";
	exit;
}
else {
	echo "<meta http-equiv='refresh' content='5; url=?open=Export-Barang'>";
}
?>
