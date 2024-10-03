<?php
# KONTROL MENU PROGRAM
if($_GET) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){				
		case '' :
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";	break;
			
		case 'Halaman-Utama' :
			if(!file_exists ("main.php")) die ("File tidak ditemukan !"); 
			include "main.php";	break;
			
		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ditemukan !"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ditemukan !"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ditemukan !"); 
			include "login_out.php"; break;		

		# DATA USER
		case 'User-Data' :
			if(!file_exists ("user_data.php")) die ("File tidak ditemukan !"); 
			include "user_data.php";	 break;		
		case 'User-Add' :
			if(!file_exists ("user_add.php")) die ("File tidak ditemukan !"); 
			include "user_add.php";	 break;		
		case 'User-Delete' :
			if(!file_exists ("user_delete.php")) die ("File tidak ditemukan !"); 
			include "user_delete.php"; break;		
		case 'User-Edit' :
			if(!file_exists ("user_edit.php")) die ("File tidak ditemukan !"); 
			include "user_edit.php"; break;	

		# MEREK BARANG
		case 'Merek-Data' :
			if(!file_exists ("merek_data.php")) die ("File tidak ditemukan !"); 
			include "merek_data.php"; break;		
		case 'Merek-Add' :
			if(!file_exists ("merek_add.php")) die ("File tidak ditemukan !"); 
			include "merek_add.php";	break;		
		case 'Merek-Delete' :
			if(!file_exists ("merek_delete.php")) die ("File tidak ditemukan !"); 
			include "merek_delete.php"; break;		
		case 'Merek-Edit' :
			if(!file_exists ("merek_edit.php")) die ("File tidak ditemukan !"); 
			include "merek_edit.php"; break;	

		# KATEGORI BARANG
		case 'Kategori-Data' :
			if(!file_exists ("kategori_data.php")) die ("File tidak ditemukan !"); 
			include "kategori_data.php"; break;		
		case 'Kategori-Add' :
			if(!file_exists ("kategori_add.php")) die ("File tidak ditemukan !"); 
			include "kategori_add.php";	break;		
		case 'Kategori-Delete' :
			if(!file_exists ("kategori_delete.php")) die ("File tidak ditemukan !"); 
			include "kategori_delete.php"; break;		
		case 'Kategori-Edit' :
			if(!file_exists ("kategori_edit.php")) die ("File tidak ditemukan !"); 
			include "kategori_edit.php"; break;	
			
		# JENIS BARANG
		case 'Jenis-Data' :
			if(!file_exists ("jenis_data.php")) die ("File tidak ditemukan !"); 
			include "jenis_data.php"; break;		
		case 'Jenis-Add' :
			if(!file_exists ("jenis_add.php")) die ("File tidak ditemukan !"); 
			include "jenis_add.php";	break;		
		case 'Jenis-Delete' :
			if(!file_exists ("jenis_delete.php")) die ("File tidak ditemukan !"); 
			include "jenis_delete.php"; break;		
		case 'Jenis-Edit' :
			if(!file_exists ("jenis_edit.php")) die ("File tidak ditemukan !"); 
			include "jenis_edit.php"; break;	
			
		# DATA BARANG
		case 'Barang-Data' :
			if(!file_exists ("barang_data.php")) die ("File tidak ditemukan !"); 
			include "barang_data.php"; break;		
		case 'Barang-Add' :
			if(!file_exists ("barang_add.php")) die ("File tidak ditemukan !"); 
			include "barang_add.php"; break;		
		case 'Barang-Delete' :
			if(!file_exists ("barang_delete.php")) die ("File tidak ditemukan !"); 
			include "barang_delete.php"; break;		
		case 'Barang-Edit' :
			if(!file_exists ("barang_edit.php")) die ("File tidak ditemukan !"); 
			include "barang_edit.php"; break;
			
		case 'Barang-Stok' :
			if(!file_exists ("barang_stok_kontrol.php")) die ("Maaf ..!, file tidak ada !"); 
			include "barang_stok_kontrol.php"; break;		
			
		case 'Barang-Cari' :
			if(!file_exists ("barang_cari.php")) die ("Maaf ..!, file tidak ada !"); 
			include "barang_cari.php"; break;		

		# SUPPLIER
		case 'Supplier-Data' :
			if(!file_exists ("supplier_data.php")) die ("File tidak ditemukan !"); 
			include "supplier_data.php"; break;		
		case 'Supplier-Add' :
			if(!file_exists ("supplier_add.php")) die ("File tidak ditemukan !"); 
			include "supplier_add.php"; break;
		case 'Supplier-Delete' :
			if(!file_exists ("supplier_delete.php")) die ("File tidak ditemukan !"); 
			include "supplier_delete.php"; break;
		case 'Supplier-Edit' :
			if(!file_exists ("supplier_edit.php")) die ("File tidak ditemukan !"); 
			include "supplier_edit.php"; break;

		# PELANGGAN
		case 'Pelanggan-Data' :
			if(!file_exists ("pelanggan_data.php")) die ("File tidak ditemukan !"); 
			include "pelanggan_data.php"; break;		
		case 'Pelanggan-Add' :
			if(!file_exists ("pelanggan_add.php")) die ("File tidak ditemukan !"); 
			include "pelanggan_add.php"; break;
		case 'Pelanggan-Delete' :
			if(!file_exists ("pelanggan_delete.php")) die ("File tidak ditemukan !"); 
			include "pelanggan_delete.php"; break;
		case 'Pelanggan-Edit' :
			if(!file_exists ("pelanggan_edit.php")) die ("File tidak ditemukan !"); 
			include "pelanggan_edit.php"; break;

		case 'Pencarian-Barang' :
			if(!file_exists ("pencarian_barang.php")) die ("File tidak ditemukan !"); 
			include "pencarian_barang.php"; break;		


		# REPORT INFORMASI / LAPORAN DATA
		case 'Laporan-Cetak' :
				if(!file_exists ("menu_laporan.php")) die ("File tidak ditemukan !"); 
				include "menu_laporan.php"; break;

			# LAPORAN MASTER DATA
			case 'Laporan-User' :
				if(!file_exists ("laporan_user.php")) die ("File tidak ditemukan !"); 
				include "laporan_user.php"; break;
	
			case 'Laporan-Supplier' :	
				if(!file_exists ("laporan_supplier.php")) die ("File tidak ditemukan !"); 
				include "laporan_supplier.php"; break;
				
			case 'Laporan-Pelanggan' :	
				if(!file_exists ("laporan_pelanggan.php")) die ("File tidak ditemukan !"); 
				include "laporan_pelanggan.php"; break;
				
			case 'Laporan-Kategori' :	
				if(!file_exists ("laporan_kategori.php")) die ("File tidak ditemukan !"); 
				include "laporan_kategori.php"; break;
				
			case 'Laporan-Jenis' :	
				if(!file_exists ("laporan_jenis.php")) die ("File tidak ditemukan !"); 
				include "laporan_jenis.php"; break;
				
			case 'Laporan-Merek' :	
				if(!file_exists ("laporan_merek.php")) die ("File tidak ditemukan !"); 
				include "laporan_merek.php"; break;
							
			case 'Laporan-Barang-Kategori' :
				if(!file_exists ("laporan_barang_kategori.php")) die ("Maaf ..!, file tidak ada !"); 
				include "laporan_barang_kategori.php"; break;
					
			case 'Laporan-Barang-Jenis' :
				if(!file_exists ("laporan_barang_jenis.php")) die ("Maaf ..!, file tidak ada !"); 
				include "laporan_barang_jenis.php"; break;
					
			case 'Laporan-Barang-Merek' :
				if(!file_exists ("laporan_barang_merek.php")) die ("Maaf ..!, file tidak ada !"); 
				include "laporan_barang_merek.php"; break;
				
			case 'Laporan-Barang-Supplier' :
				if(!file_exists ("laporan_barang_supplier.php")) die ("Maaf ..!, file tidak ada !"); 
				include "laporan_barang_supplier.php"; break;
				
			case 'Laporan-Barang-Stok-Minimal' :
				if(!file_exists ("laporan_barang_minimal.php")) die ("Maaf ..!, file tidak ada !"); 
				include "laporan_barang_minimal.php"; break;
				
			case 'Laporan-Barang-Stok-Maksimal' :
				if(!file_exists ("laporan_barang_maksimal.php")) die ("Maaf ..!, file tidak ada !"); 
				include "laporan_barang_maksimal.php"; break;
				
			# LAPORAN PEMBELIAN
			case 'Laporan-Pembelian-Periode' :
				if(!file_exists ("laporan_pembelian_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_pembelian_periode.php"; break;
				
			case 'Laporan-Pembelian-Bulan' :
				if(!file_exists ("laporan_pembelian_bulan.php")) die ("File tidak ditemukan  !"); 
				include "laporan_pembelian_bulan.php"; break;
				
			case 'Laporan-Pembelian-Supplier' :
				if(!file_exists ("laporan_pembelian_supplier.php")) die ("File tidak ditemukan !"); 
				include "laporan_pembelian_supplier.php"; break;
				
			case 'Laporan-Pembelian-Barang-Periode' :
				if(!file_exists ("laporan_pembelian_barang_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_pembelian_barang_periode.php"; break;

			case 'Laporan-Pembelian-Barang-Bulan' :
				if(!file_exists ("laporan_pembelian_barang_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_pembelian_barang_bulan.php"; break;
				
			# LAPORAN RETUR BELI (PEMBELIAN)
			case 'Laporan-Returbeli-Periode' :
				if(!file_exists ("laporan_returbeli_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_returbeli_periode.php"; break;
				
			case 'Laporan-Returbeli-Barang-Periode' :
				if(!file_exists ("laporan_returbeli_barang_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_returbeli_barang_periode.php"; break;
												
			case 'Laporan-Returbeli-Barang-Bulan' :
				if(!file_exists ("laporan_returbeli_barang_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_returbeli_barang_bulan.php"; break;
												
			# LAPORAN PENJUALAN 
			case 'Laporan-Penjualan-Periode' :
				if(!file_exists ("laporan_penjualan_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_periode.php"; break;
				
			case 'Laporan-Penjualan-Bulan' :
				if(!file_exists ("laporan_penjualan_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_bulan.php"; break;
				
			case 'Laporan-Penjualan-Tahun' :
				if(!file_exists ("laporan_penjualan_tahun.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_tahun.php"; break;
				
			case 'Laporan-Penjualan-Pelanggan' :
				if(!file_exists ("laporan_penjualan_pelanggan.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_pelanggan.php"; break;
				
			# LAPORAN PENDAPATAN
			case 'Laporan-Penjualan-Barang-Periode' :
				if(!file_exists ("laporan_penjualan_barang_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_barang_periode.php"; break;
				
			case 'Laporan-Penjualan-Barang-Tanggal' :
				if(!file_exists ("laporan_penjualan_barang_tanggal.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_barang_tanggal.php"; break;
				
			case 'Laporan-Penjualan-Barang-Bulan' :
				if(!file_exists ("laporan_penjualan_barang_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_barang_bulan.php"; break;
				
			case 'Laporan-Penjualan-Barang-Tahun' :
				if(!file_exists ("laporan_penjualan_barang_tahun.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_barang_tahun.php"; break;
				
			case 'Laporan-Penjualan-Barang-Pelanggan' :
				if(!file_exists ("laporan_penjualan_barang_pelanggan.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_barang_pelanggan.php"; break;
				
			case 'Laporan-Penjualan-Barang-Terlaris' :
				if(!file_exists ("laporan_penjualan_barang_terlaris.php")) die ("File tidak ditemukan !"); 
				include "laporan_penjualan_barang_terlaris.php"; break;
				
			case 'Laporan-Labarugi-Periode' :
				if(!file_exists ("laporan_labarugi_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_labarugi_periode.php"; break;
				
			case 'Laporan-Labarugi-Bulan' :
				if(!file_exists ("laporan_labarugi_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_labarugi_bulan.php"; break;
				
			case 'Laporan-Rekap-Penjualan-Periode' :
				if(!file_exists ("laporan_rekap_penjualan_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_rekap_penjualan_periode.php"; break;
				
			case 'Laporan-Rekap-Penjualan-Bulan' :
				if(!file_exists ("laporan_rekap_penjualan_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_rekap_penjualan_bulan.php"; break;

			# LAPORAN RETUR JUAL (PENJUALAN)
			case 'Laporan-Returjual-Periode' :
				if(!file_exists ("laporan_returjual_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_returjual_periode.php"; break;
				
			case 'Laporan-Returjual-Barang-Periode' :
				if(!file_exists ("laporan_returjual_barang_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_returjual_barang_periode.php"; break;
												
			case 'Laporan-Returjual-Barang-Bulan' :
				if(!file_exists ("laporan_returjual_barang_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_returjual_barang_bulan.php"; break;
				
		# TOOLS
		case 'Cetak-Barcode' :
			if(!file_exists ("cetak_barcode.php")) die ("Maaf ..!, file tidak ada !"); 
			include "cetak_barcode.php"; break;		

		case 'Backup-Restore' :
			if(!file_exists ("backup_restore.php")) die ("File tidak ditemukan  !"); 
			include "backup_restore.php"; break;	
				
		case 'Export-Import' :
			if(!file_exists ("menu_ex_import.php")) die ("File tidak ditemukan  !"); 
			include "menu_ex_import.php"; break;		
				
		case 'Import-Barang' :
			if(!file_exists ("import_barang.php")) die ("File tidak ditemukan  !"); 
			include "import_barang.php"; break;		
				
		case 'Import-Pelanggan' :
			if(!file_exists ("import_pelanggan.php")) die ("File tidak ditemukan  !"); 
			include "import_pelanggan.php"; break;		
			
		case 'Export-Barang' :
			if(!file_exists ("export_barang.php")) die ("File tidak ditemukan  !"); 
			include "export_barang.php"; break;		
			
		case 'Export-Pelanggan' :
			if(!file_exists ("export_pelanggan.php")) die ("File tidak ditemukan  !"); 
			include "export_pelanggan.php"; break;	
				
		case 'Laporan-Grafik' :				
				if(!file_exists ("menu_grafik.php")) die ("Maaf ..!, file tidak ada !"); 
				include "menu_grafik.php"; break;	
												
		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?page
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
	include "main.php";	
}
?>