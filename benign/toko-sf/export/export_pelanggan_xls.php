<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

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
	xlsWriteLabel(0,1,"DATA PELANGGAN" );
	
	xlsWriteLabel(1,0, "Kode" );
	xlsWriteLabel(1,1, "Nama Pelanggan" );
	xlsWriteLabel(1,2, "Nama Toko");
	xlsWriteLabel(1,3, "Alamat");
	xlsWriteLabel(1,4, "No. Telepon" );
	$xlsRow = 2;

	header("Pragma: public" );
	header("Expires: 0" );
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
	header("Content-Type: application/force-download" );
	header("Content-Type: application/octet-stream" );
	header("Content-Type: application/download" );;
	header("Content-Disposition: attachment;filename=pelanggan.xls " );
	header("Content-Transfer-Encoding: binary " );

	# Skrip enampilkan Semua Daftar Pelanggan
	$bacaSql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan";
	$bacaQry = mysql_query($bacaSql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($bacaData = mysql_fetch_array($bacaQry)) {
		$nomor++;
		
		// Menulis hasil data ke Excel
		xlsWriteLabel($xlsRow,0, $bacaData['kd_pelanggan']); 
		xlsWriteLabel($xlsRow,1, $bacaData['nm_pelanggan']); 
		xlsWriteLabel($xlsRow,2, $bacaData['nm_toko']); 
		xlsWriteLabel($xlsRow,3, $bacaData['alamat']); 
		xlsWriteLabel($xlsRow,4, $bacaData['no_telepon']); 
		
		$xlsRow++;
	}
	
	// Tutup file Excel
	xlsEOF();
			
	echo "<meta http-equiv='refresh' content='5; url=?open=Export-Pelanggan'>";
	exit;
?>
