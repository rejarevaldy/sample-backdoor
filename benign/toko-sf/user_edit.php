<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses
if($aksesData['mu_data_user'] == "Yes") {

# Tombol Simpan diklik
if(isset($_POST['btnSimpan']) or isset($_POST['btnSimpan2'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNamaUser	= $_POST['txtNamaUser'];
	$txtNamaUser	= str_replace("'","&acute;",$txtNamaUser); // menghalangi penulisan tanda petik satu (')

	$txtUsername	= $_POST['txtUsername'];
	$txtUsername	= str_replace("'","&acute;",$txtUsername); // menghalangi penulisan tanda petik satu (')

	$txtPassword	= $_POST['txtPassword'];
	$txtTelepon		= $_POST['txtTelepon'];
	$cmbLevel		= $_POST['cmbLevel'];

	$txtPassLama	= $_POST['txtPassLama'];

	// Membaca Form Hak Akses
	$rbDataUser			=  $_POST['rbDataUser'];
	$rbDataPelanggan	=  $_POST['rbDataPelanggan'];
	$rbDataSupplier		=  $_POST['rbDataSupplier'];
	$rbDataMerek		=  $_POST['rbDataMerek'];
	$rbDataKategori		=  $_POST['rbDataKategori'];
	$rbDataJenis		=  $_POST['rbDataJenis'];
	$rbDataBarang		=  $_POST['rbDataBarang'];
	$rbKontrolStok		=  $_POST['rbKontrolStok'];
	$rbCariBarang		=  $_POST['rbCariBarang'];
	$rbCetakBarcode		=  $_POST['rbCetakBarcode'];
	$rbPembelian		=  $_POST['rbPembelian'];
	$rbReturBeli		=  $_POST['rbReturBeli'];
	$rbPenjualan		=  $_POST['rbPenjualan'];
	$rbReturJual		=  $_POST['rbReturJual'];
	
	$rbBayarBeli		=  $_POST['rbBayarBeli'];
	$rbBayarJual		=  $_POST['rbBayarJual'];

	$rbBackupRestore	=  $_POST['rbBackupRestore'];
	$rbExportBarang		=  $_POST['rbExportBarang'];
	$rbImportBarang		=  $_POST['rbImportBarang'];
	$rbExportPelanggan	=  $_POST['rbExportPelanggan'];
	$rbImportPelanggan	=  $_POST['rbImportPelanggan'];

	$rbLapUser			=  $_POST['rbLapUser'];
	$rbLapPelanggan		=  $_POST['rbLapPelanggan'];
	$rbLapSupplier		=  $_POST['rbLapSupplier'];
	$rbLapMerek			=  $_POST['rbLapMerek'];
	$rbLapKategori		=  $_POST['rbLapKategori'];
	$rbLapJenis			=  $_POST['rbLapJenis'];
	$rbLapBarangMerek	=  $_POST['rbLapBarangMerek'];
	$rbLapBarangKategori		=  $_POST['rbLapBarangKategori'];
	$rbLapBarangJenis			=  $_POST['rbLapBarangJenis'];
	$rbLapBarangMinimal			=  $_POST['rbLapBarangMinimal'];
	$rbLapBarangMaksimal		=  $_POST['rbLapBarangMaksimal'];
	
	$rbLapPembelianPeriode		=  $_POST['rbLapPembelianPeriode'];
	$rbLapPembelianBulan		=  $_POST['rbLapPembelianBulan'];
	$rbLapPembelianSupplier		=  $_POST['rbLapPembelianSupplier'];
	$rbLapPembelianBarangPeriode=  $_POST['rbLapPembelianBarangPeriode'];
	$rbLapPembelianBarangBulan	=  $_POST['rbLapPembelianBarangBulan'];
	$rbLapPembelianRekapPeriode	=  $_POST['rbLapPembelianRekapPeriode'];
	$rbLapPembelianRekapBulan	=  $_POST['rbLapPembelianRekapBulan'];
	
	$rbLapReturBeliPeriode		=  $_POST['rbLapReturBeliPeriode'];
	$rbLapReturBeliBulan		=  $_POST['rbLapReturBeliBulan'];
	$rbLapReturBeliBarangPeriode=  $_POST['rbLapReturBeliBarangPeriode'];
	$rbLapReturBeliBarangBulan	=  $_POST['rbLapReturBeliBarangBulan'];
	$rbLapReturBeliRekapPeriode	=  $_POST['rbLapReturBeliRekapPeriode'];
	$rbLapReturBeliRekapBulan	=  $_POST['rbLapReturBeliRekapBulan'];
	
	$rbLapPenjualanTanggal		=  $_POST['rbLapPenjualanTanggal'];
	$rbLapPenjualanPeriode		=  $_POST['rbLapPenjualanPeriode'];
	$rbLapPenjualanBulan		=  $_POST['rbLapPenjualanBulan'];
	$rbLapPenjualanPelanggan	=  $_POST['rbLapPenjualanPelanggan'];
	$rbLapPenjualanBarangTanggal=  $_POST['rbLapPenjualanBarangTanggal'];
	$rbLapPenjualanBarangPeriode=  $_POST['rbLapPenjualanBarangPeriode'];
	$rbLapPenjualanBarangBulan	=  $_POST['rbLapPenjualanBarangBulan'];
	$rbLapPenjualanBarangPelanggan	=  $_POST['rbLapPenjualanBarangPelanggan'];
	$rbLapPenjualanRekapPeriode	=  $_POST['rbLapPenjualanRekapPeriode'];
	$rbLapPenjualanRekapBulan	=  $_POST['rbLapPenjualanRekapBulan'];
	
	$rbLapPenjualanTerlaris		=  $_POST['rbLapPenjualanTerlaris'];
	$rbLapLabarugiPeriode		=  $_POST['rbLapLabarugiPeriode'];
	$rbLapLabarugiBulan			=  $_POST['rbLapLabarugiBulan'];
		
	$rbLapReturJualPeriode		=  $_POST['rbLapReturJualPeriode'];
	$rbLapReturJualBulan		=  $_POST['rbLapReturJualBulan'];
	$rbLapReturJualBarangPeriode=  $_POST['rbLapReturJualBarangPeriode'];
	$rbLapReturJualBarangBulan	=  $_POST['rbLapReturJualBarangBulan'];
	$rbLapReturJualRekapPeriode	=  $_POST['rbLapReturJualRekapPeriode'];
	$rbLapReturJualRekapBulan	=  $_POST['rbLapReturJualRekapBulan'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNamaUser)=="") {
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($txtPassword)=="" and trim($txtPassLama)=="") {
		$pesanError[] = "Data <b>Password</b> belum dibuat, silahkan dilengkapi !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level Akses</b> belum dipilih, silahkan dilengkapi !";		
	}
	
	// Kode dari form Hidden
	$Kode	= $_POST['txtKode']; 
	
	# VALIDASI USER LOGIN (USERNAME), jika sudah ada akan ditolak
	$cekSql="SELECT * FROM user WHERE username='$txtUsername' AND NOT(kd_user='$Kode')";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "USERNAME<b> $txtUsername </b> sudah ada, ganti dengan yang lain";
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
		# Cek Password baru
		if (trim($txtPassword)=="") {
			$txtPassLama	= $_POST['txtPassLama'];
			$passwordSQL 	= ", password='$txtPassLama'";
		}
		else {
			$passwordSQL 	= ",  password ='".md5($txtPassword)."'";
		}
		
		// Kode dari form Hidden
		$Kode	= $_POST['txtKode']; 
		
		# SIMPAN DATA KE DATABASE (Jika tidak menemukan error, simpan data ke database)
		$mySql  = "UPDATE user SET nm_user='$txtNamaUser', username='$txtUsername', 
					no_telepon='$txtTelepon', level='$cmbLevel'
					$passwordSQL  
					WHERE kd_user='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Update Hak Akses
			$my2Sql  = "UPDATE hak_akses SET 
							mu_data_user = '$rbDataUser', 
							mu_data_supplier = '$rbDataSupplier', 
							mu_data_merek = '$rbDataMerek', 
							mu_data_pelanggan = '$rbDataPelanggan', 
							mu_data_kategori = '$rbDataKategori', 
							mu_data_jenis = '$rbDataJenis', 
							mu_data_barang = '$rbDataBarang', 
							mu_kontrol_stok = '$rbKontrolStok', 
							mu_pencarian = '$rbCariBarang', 
							mu_barcode = '$rbCetakBarcode', 
							mu_trans_pembelian = '$rbPembelian', 
							mu_trans_returbeli = '$rbReturBeli', 
							mu_trans_penjualan = '$rbPenjualan', 
							mu_trans_returjual = '$rbReturJual', 
							mu_bayar_pembelian	= '$rbBayarBeli', 
							mu_bayar_penjualan  = '$rbBayarJual', 
							mu_backup_restore = '$rbBackupRestore', 
							mu_export_import = 'Yes',
							mu_export_barang = '$rbExportBarang',
							mu_import_barang = '$rbImportBarang',
							mu_export_pelanggan = '$rbExportPelanggan',
							mu_import_pelanggan = '$rbExportPelanggan',
							mu_laporan_cetak = 'Yes', 
							mu_laporan_grafik = 'Yes', 
							mlap_user = '$rbLapUser', 
							mlap_supplier = '$rbLapSupplier', 
							mlap_pelanggan = '$rbLapPelanggan', 
							mlap_merek = '$rbLapMerek', 
							mlap_kategori = '$rbLapKategori', 
							mlap_jenis = '$rbLapJenis', 
							mlap_barang_kategori = '$rbLapBarangKategori', 
							mlap_barang_jenis = '$rbLapBarangJenis', 
							mlap_barang_merek = '$rbLapBarangMerek', 
							mlap_barang_minimal = '$rbLapBarangMinimal', 
							mlap_barang_maksimal = '$rbLapBarangMaksimal', 
							mlap_pembelian_periode = '$rbLapPembelianPeriode', 
							mlap_pembelian_bulan = '$rbLapPembelianBulan', 
							mlap_pembelian_supplier = '$rbLapPembelianSupplier', 
							mlap_pembelian_barang_periode = '$rbLapPembelianBarangPeriode', 
							mlap_pembelian_barang_bulan = '$rbLapPembelianBarangBulan', 
							mlap_pembelian_rekap_periode = '$rbLapPembelianRekapPeriode', 
							mlap_pembelian_rekap_bulan = '$rbLapPembelianRekapBulan',
							mlap_returbeli_periode = '$rbLapReturBeliPeriode',
							mlap_returbeli_bulan = '$rbLapReturBeliBulan',
							mlap_returbeli_barang_periode = '$rbLapReturBeliBarangPeriode',
							mlap_returbeli_barang_bulan = '$rbLapReturBeliBarangBulan',
							mlap_returbeli_rekap_periode = '$rbLapReturBeliRekapPeriode',
							mlap_returbeli_rekap_bulan = '$rbLapReturBeliRekapBulan',
							mlap_penjualan_tanggal = '$rbLapPenjualanTanggal',
							mlap_penjualan_periode = '$rbLapPenjualanPeriode',
							mlap_penjualan_bulan = '$rbLapPenjualanBulan',
							mlap_penjualan_pelanggan = '$rbLapPenjualanPelanggan',
							mlap_penjualan_barang_tanggal = '$rbLapPenjualanBarangTanggal',
							mlap_penjualan_barang_periode = '$rbLapPenjualanBarangPeriode',
							mlap_penjualan_barang_bulan = '$rbLapPenjualanBarangBulan',
							mlap_penjualan_barang_pelanggan = '$rbLapPenjualanBarangPelanggan',
							mlap_penjualan_rekap_periode = '$rbLapPenjualanRekapPeriode',
							mlap_penjualan_rekap_bulan = '$rbLapPenjualanRekapBulan',
							mlap_penjualan_terlaris = '$rbLapPenjualanTerlaris',
							mlap_labarugi_periode	= '$rbLapLabarugiPeriode',
							mlap_labarugi_bulan		= '$rbLapLabarugiBulan',
							mlap_returjual_periode = '$rbLapReturJualPeriode',
							mlap_returjual_bulan = '$rbLapReturJualBulan',
							mlap_returjual_barang_periode = '$rbLapReturJualBarangPeriode',
							mlap_returjual_barang_bulan = '$rbLapReturJualBarangBulan',
							mlap_returjual_rekap_periode = '$rbLapReturJualRekapPeriode',
							mlap_returjual_rekap_bulan = '$rbLapReturJualRekapBulan' 
						WHERE kd_user='$Kode'";
			mysql_query($my2Sql, $koneksidb) or die ("Gagal query 2 ".mysql_error());
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan


# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode	= $_GET['Kode']; 
$mySql 	= "SELECT user.*, hak_akses.* FROM user LEFT JOIN hak_akses ON user.kd_user = hak_akses.kd_user WHERE user.kd_user='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	// Data Variabel Temporary (sementara)
	$dataKode		= $myData['kd_user'];
	$dataNamaUser	= isset($_POST['txtNamaUser']) ? $_POST['txtNamaUser'] : $myData['nm_user'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];


	// Data Hak Akses
	$dataUser	   	= isset($_POST['rbDataUser']) ? $_POST['rbDataUser'] : $myData['mu_data_user'];
		if($dataUser =="No") { $pilihUserN = "checked"; $pilihUserY = ""; } else { $pilihUserN = ""; $pilihUserY = "checked"; }

	$dataPelanggan 	= isset($_POST['rbDataPelanggan']) ? $_POST['rbDataPelanggan'] : $myData['mu_data_pelanggan'];
		if($dataPelanggan =="No") { $pilihPelangganN = "checked"; $pilihPelangganY = ""; } else { $pilihPelangganN = ""; $pilihPelangganY = "checked"; }

	$dataSupplier 	= isset($_POST['rbDataSupplier']) ? $_POST['rbDataSupplier'] : $myData['mu_data_supplier'];
		if($dataSupplier =="No") { $pilihSupplierN = "checked"; $pilihSupplierY = ""; } else { $pilihSupplierN = ""; $pilihSupplierY = "checked"; }

	$dataMerek 		= isset($_POST['rbDataMerek']) ? $_POST['rbDataMerek'] : $myData['mu_data_merek'];
		if($dataMerek =="No") { $pilihMerekN = "checked"; $pilihMerekY = ""; } else { $pilihMerekN = ""; $pilihMerekY = "checked"; }

	$dataKategori 		= isset($_POST['rbDataKategori']) ? $_POST['rbDataKategori'] : $myData['mu_data_kategori'];
		if($dataKategori =="No") { $pilihKategoriN = "checked"; $pilihKategoriY = ""; } else { $pilihKategoriN = ""; $pilihKategoriY = "checked"; }

	$dataJenis 		= isset($_POST['rbDataJenis']) ? $_POST['rbDataJenis'] : $myData['mu_data_jenis'];
		if($dataJenis =="No") { $pilihJenisN = "checked"; $pilihJenisY = ""; } else { $pilihJenisN = ""; $pilihJenisY = "checked"; }

	$dataBarang 		= isset($_POST['rbDataBarang']) ? $_POST['rbDataBarang'] : $myData['mu_data_barang'];
		if($dataBarang =="No") { $pilihBarangN = "checked"; $pilihBarangY = ""; } else { $pilihBarangN = ""; $pilihBarangY = "checked"; }

	$dataKontrolStok 	= isset($_POST['rbKontrolStok']) ? $_POST['rbKontrolStok'] : $myData['mu_kontrol_stok'];
		if($dataKontrolStok =="No") { $pilihKontrolStokN = "checked"; $pilihKontrolStokY = ""; } else { $pilihKontrolStokN = ""; $pilihKontrolStokY = "checked"; }
	
	$dataCariBarang 		= isset($_POST['rbCariBarang']) ? $_POST['rbCariBarang'] : $myData['mu_pencarian'];
		if($dataCariBarang =="No") { $pilihCariBarangN = "checked"; $pilihCariBarangY = ""; } else { $pilihCariBarangN = ""; $pilihCariBarangY = "checked"; }

	$dataBarcode 		= isset($_POST['rbCetakBarcode']) ? $_POST['rbCetakBarcode'] : $myData['mu_barcode'];
		if($dataBarcode =="No") { $pilihBarcodeN = "checked"; $pilihBarcodeY = ""; } else { $pilihBarcodeN = ""; $pilihBarcodeY = "checked"; }

// TRANSAKSI PEMBELIAN
	$dataPembelian 		= isset($_POST['rbPembelian']) ? $_POST['rbPembelian'] : $myData['mu_trans_pembelian'];
		if($dataPembelian =="No") { $pilihPembelianN = "checked"; $pilihPembelianY = ""; } else { $pilihPembelianN = ""; $pilihPembelianY = "checked"; }

	$dataReturBeli 		= isset($_POST['rbReturBeli']) ? $_POST['rbReturBeli'] : $myData['mu_trans_returbeli'];
		if($dataReturBeli =="No") { $pilihReturBeliN = "checked"; $pilihReturBeliY = ""; } else { $pilihReturBeliN = ""; $pilihReturBeliY = "checked"; }

	$dataPenjualan 		= isset($_POST['rbPenjualan']) ? $_POST['rbPenjualan'] : $myData['mu_trans_penjualan'];
		if($dataPenjualan =="No") { $pilihPenjualanN = "checked"; $pilihPenjualanY = ""; } else { $pilihPenjualanN = ""; $pilihPenjualanY = "checked"; }

	$dataReturJual 		= isset($_POST['rbReturJual']) ? $_POST['rbReturJual'] : $myData['mu_trans_returjual'];
		if($dataReturJual =="No") { $pilihReturJualN = "checked"; $pilihReturJualY = ""; } else { $pilihReturJualN = ""; $pilihReturJualY = "checked"; }
		
	$dataBayarBeli 		= isset($_POST['rbBayarBeli']) ? $_POST['rbBayarBeli'] : $myData['mu_bayar_pembelian'];
		if($dataBayarBeli =="No") { $pilihBayarBeliN = "checked"; $pilihBayarBeliY = ""; } else { $pilihBayarBeliN = ""; $pilihBayarBeliY = "checked"; }
		
	$dataBayarJual 		= isset($_POST['rbBayarJual']) ? $_POST['rbBayarJual'] : $myData['mu_bayar_penjualan'];
		if($dataBayarJual =="No") { $pilihBayarJualN = "checked"; $pilihBayarJualY = ""; } else { $pilihBayarJualN = ""; $pilihBayarJualY = "checked"; }

// TOOLS
	$dataBackupRestore 		= isset($_POST['rbBackupRestore']) ? $_POST['rbBackupRestore'] : $myData['mu_backup_restore'];
		if($dataBackupRestore =="No") { $pilihBackupRestoreN = "checked"; $pilihBackupRestoreY = ""; } else { $pilihBackupRestoreN = ""; $pilihBackupRestoreY = "checked"; }

	$dataExportBarang 		= isset($_POST['rbExportBarang']) ? $_POST['rbExportBarang'] : $myData['mu_export_barang'];
		if($dataExportBarang =="No") { $pilihExportBarangN = "checked"; $pilihExportBarangY = ""; } else { $pilihExportBarangN = ""; $pilihExportBarangY = "checked"; }
	
	$dataImportBarang 		= isset($_POST['rbImportBarang']) ? $_POST['rbImportBarang'] : $myData['mu_import_pelanggan'];
		if($dataImportBarang =="No") { $pilihImportBarangN = "checked"; $pilihImportBarangY = ""; } else { $pilihImportBarangN = ""; $pilihImportBarangY = "checked"; }

	$dataExportPelanggan 		= isset($_POST['rbExportPelanggan']) ? $_POST['rbExportPelanggan'] : $myData['mu_export_pelanggan'];
		if($dataExportPelanggan =="No") { $pilihExportPelangganN = "checked"; $pilihExportPelangganY = ""; } 
		else { $pilihExportPelangganN = ""; $pilihExportPelangganY = "checked"; }
	
	$dataImportPelanggan 		= isset($_POST['rbImportPelanggan']) ? $_POST['rbImportPelanggan'] : $myData['mu_import_barang'];
		if($dataImportPelanggan =="No") { $pilihImportPelangganN = "checked"; $pilihImportPelangganY = ""; } 
		else { $pilihImportPelangganN = ""; $pilihImportPelangganY = "checked"; }

	$lapUser 			= isset($_POST['rbLapUser']) ? $_POST['rbLapUser'] : $myData['mlap_user'];
		if($lapUser =="No") { $pilihLapUserN = "checked"; $pilihLapUserY = ""; } else { $pilihLapUserN = ""; $pilihLapUserY = "checked"; }

	$lapPelanggan 		= isset($_POST['rbLapPelanggan']) ? $_POST['rbLapPelanggan'] : $myData['mlap_pelanggan'];
		if($lapPelanggan =="No") { $pilihLapPelangganN = "checked"; $pilihLapPelangganY = ""; } else { $pilihLapPelangganN = ""; $pilihLapPelangganY = "checked"; }

	$lapSupplier 		= isset($_POST['rbLapSupplier']) ? $_POST['rbLapSupplier'] : $myData['mlap_pelanggan'];
		if($lapSupplier =="No") { $pilihLapSupplierN = "checked"; $pilihLapSupplierY = ""; } else { $pilihLapSupplierN = ""; $pilihLapSupplierY = "checked"; }

	$lapMerek 		= isset($_POST['rbLapMerek']) ? $_POST['rbLapMerek'] : $myData['mlap_merek'];
		if($lapMerek =="No") { $pilihLapMerekN = "checked"; $pilihLapMerekY = ""; } else { $pilihLapMerekN = ""; $pilihLapMerekY = "checked"; }

	$lapKategori 		= isset($_POST['rbLapKategori']) ? $_POST['rbLapKategori'] : $myData['mlap_kategori'];
		if($lapKategori =="No") { $pilihLapKategoriN = "checked"; $pilihLapKategoriY = ""; } else { $pilihLapKategoriN = ""; $pilihLapKategoriY = "checked"; }

	$lapJenis 		= isset($_POST['rbLapJenis']) ? $_POST['rbLapJenis'] : $myData['mlap_jenis'];
		if($lapJenis =="No") { $pilihLapJenisN = "checked"; $pilihLapJenisY = ""; } else { $pilihLapJenisN = ""; $pilihLapJenisY = "checked"; }

	$lapBarangMerek 		= isset($_POST['rbLapBarangMerek']) ? $_POST['rbLapBarangMerek'] : $myData['mlap_barang_merek'];
		if($lapBarangMerek =="No") { $pilihLapBarangMerekN = "checked"; $pilihLapBarangMerekY = ""; } 
		else { $pilihLapBarangMerekN = ""; $pilihLapBarangMerekY = "checked"; }

	$lapBarangKategori 		= isset($_POST['rbLapBarangKategori']) ? $_POST['rbLapBarangKategori'] : $myData['mlap_barang_merek'];
		if($lapBarangKategori =="No") { $pilihLapBarangKategoriN = "checked"; $pilihLapBarangKategoriY = ""; } 
		else { $pilihLapBarangKategoriN = ""; $pilihLapBarangKategoriY = "checked"; }

	$lapBarangJenis 		= isset($_POST['rbLapBarangJenis']) ? $_POST['rbLapBarangJenis'] : $myData['mlap_barang_merek'];
		if($lapBarangJenis =="No") { $pilihLapBarangJenisN = "checked"; $pilihLapBarangJenisY = ""; } 
		else { $pilihLapBarangJenisN = ""; $pilihLapBarangJenisY = "checked"; }

	
	$lapBarangMinimal 		= isset($_POST['rbLapBarangMinimal']) ? $_POST['rbLapBarangMinimal'] : $myData['mlap_barang_minimal'];
		if($lapBarangMinimal =="No") { $pilihLapBarangMinimalN = "checked"; $pilihLapBarangMinimalY = ""; } 
		else { $pilihLapBarangMinimalN = ""; $pilihLapBarangMinimalY = "checked"; }
	
	$lapBarangMaksimal 		= isset($_POST['rbLapBarangMaksimal']) ? $_POST['rbLapBarangMaksimal'] : $myData['mlap_barang_maksimal'];
		if($lapBarangMaksimal =="No") { $pilihLapBarangMaksimalN = "checked"; $pilihLapBarangMaksimalY = ""; } 
		else { $pilihLapBarangMaksimalN = ""; $pilihLapBarangMaksimalY = "checked"; }

	# PEMBELIAN
	$lapPembelianPeriode 		= isset($_POST['rbLapPembelianPeriode']) ? $_POST['rbLapPembelianPeriode'] : $myData['mlap_pembelian_periode'];
		if($lapPembelianPeriode =="No") { $pilihLapPembelianPeriodeN = "checked"; $pilihLapPembelianPeriodeY = ""; } 
		else { $pilihLapPembelianPeriodeN = ""; $pilihLapPembelianPeriodeY = "checked"; }

	$lapPembelianBulan 		= isset($_POST['rbLapPembelianBulan']) ? $_POST['rbLapPembelianBulan'] : $myData['mlap_pembelian_bulan'];
		if($lapPembelianBulan =="No") { $pilihLapPembelianBulanN = "checked"; $pilihLapPembelianBulanY = ""; } 
		else { $pilihLapPembelianBulanN = ""; $pilihLapPembelianBulanY = "checked"; }

	$lapPembelianSupplier 		= isset($_POST['rbLapPembelianSupplier']) ? $_POST['rbLapPembelianSupplier'] : $myData['mlap_pembelian_supplier'];
		if($lapPembelianSupplier =="No") { $pilihLapPembelianSupplierN = "checked"; $pilihLapPembelianSupplierY = ""; } 
		else { $pilihLapPembelianSupplierN = ""; $pilihLapPembelianSupplierY = "checked"; }

	$lapPembelianBarangPeriode 		= isset($_POST['rbLapPembelianBarangPeriode']) ? $_POST['rbLapPembelianBarangPeriode'] : $myData['mlap_pembelian_barang_periode'];
		if($lapPembelianBarangPeriode =="No") { $pilihLapPembelianBarangPeriodeN = "checked"; $pilihLapPembelianBarangPeriodeY = ""; } 
		else { $pilihLapPembelianBarangPeriodeN = ""; $pilihLapPembelianBarangPeriodeY = "checked"; }

	$lapPembelianBarangBulan 		= isset($_POST['rbLapPembelianBarangBulan']) ? $_POST['rbLapPembelianBarangBulan'] : $myData['mlap_pembelian_barang_bulan'];
		if($lapPembelianBarangBulan =="No") { $pilihLapPembelianBarangBulanN = "checked"; $pilihLapPembelianBarangBulanY = ""; } 
		else { $pilihLapPembelianBarangBulanN = ""; $pilihLapPembelianBarangBulanY = "checked"; }

	$lapPembelianRekapPeriode 		= isset($_POST['rbLapPembelianRekapPeriode']) ? $_POST['rbLapPembelianRekapPeriode'] : $myData['mlap_pembelian_rekap_periode'];
		if($lapPembelianRekapPeriode =="No") { $pilihLapPembelianRekapPeriodeN = "checked"; $pilihLapPembelianRekapPeriodeY = ""; } 
		else { $pilihLapPembelianRekapPeriodeN = ""; $pilihLapPembelianRekapPeriodeY = "checked"; }

	$lapPembelianRekapBulan 		= isset($_POST['rbLapPembelianRekapBulan']) ? $_POST['rbLapPembelianRekapBulan'] : $myData['mlap_pembelian_rekap_bulan'];
		if($lapPembelianRekapBulan =="No") { $pilihLapPembelianRekapBulanN = "checked"; $pilihLapPembelianRekapBulanY = ""; } 
		else { $pilihLapPembelianRekapBulanN = ""; $pilihLapPembelianRekapBulanY = "checked"; }

	# RETUR BELI

	$lapReturBeliPeriode 		= isset($_POST['rbLapReturBeliPeriode']) ? $_POST['rbLapReturBeliPeriode'] : $myData['mlap_returbeli_periode'];
		if($lapReturBeliPeriode =="No") { $pilihLapReturBeliPeriodeN = "checked"; $pilihLapReturBeliPeriodeY = ""; } 
		else { $pilihLapReturBeliPeriodeN = ""; $pilihLapReturBeliPeriodeY = "checked"; }

	$lapReturBeliBulan 		= isset($_POST['rbLapReturBeliBulan']) ? $_POST['rbLapReturBeliBulan'] : $myData['mlap_returbeli_bulan'];
		if($lapReturBeliBulan =="No") { $pilihLapReturBeliBulanN = "checked"; $pilihLapReturBeliBulanY = ""; } 
		else { $pilihLapReturBeliBulanN = ""; $pilihLapReturBeliBulanY = "checked"; }

	$lapReturBeliBarangPeriode 		= isset($_POST['rbLapReturBeliBarangPeriode']) ? $_POST['rbLapReturBeliBarangPeriode'] : $myData['mlap_returbeli_barang_periode'];
		if($lapReturBeliBarangPeriode =="No") { $pilihLapReturBeliBarangPeriodeN = "checked"; $pilihLapReturBeliBarangPeriodeY = ""; } 
		else { $pilihLapReturBeliBarangPeriodeN = ""; $pilihLapReturBeliBarangPeriodeY = "checked"; }

	$lapReturBeliBarangBulan 		= isset($_POST['rbLapReturBeliBarangBulan']) ? $_POST['rbLapReturBeliBarangBulan'] : $myData['mlap_returbeli_barang_bulan'];
		if($lapReturBeliBarangBulan =="No") { $pilihLapReturBeliBarangBulanN = "checked"; $pilihLapReturBeliBarangBulanY = ""; } 
		else { $pilihLapReturBeliBarangBulanN = ""; $pilihLapReturBeliBarangBulanY = "checked"; }

	$lapReturBeliRekapPeriode 		= isset($_POST['rbLapReturBeliRekapPeriode']) ? $_POST['rbLapReturBeliRekapPeriode'] : $myData['mlap_returbeli_rekap_periode'];
		if($lapReturBeliRekapPeriode =="No") { $pilihLapReturBeliRekapPeriodeN = "checked"; $pilihLapReturBeliRekapPeriodeY = ""; } 
		else { $pilihLapReturBeliRekapPeriodeN = ""; $pilihLapReturBeliRekapPeriodeY = "checked"; }

	$lapReturBeliRekapBulan 		= isset($_POST['rbLapReturBeliRekapBulan']) ? $_POST['rbLapReturBeliRekapBulan'] : $myData['mlap_returbeli_rekap_bulan'];
		if($lapReturBeliRekapBulan =="No") { $pilihLapReturBeliRekapBulanN = "checked"; $pilihLapReturBeliRekapBulanY = ""; } 
		else { $pilihLapReturBeliRekapBulanN = ""; $pilihLapReturBeliRekapBulanY = "checked"; }
		
	# PENJUALAN

	$lapPenjualanTanggal 		= isset($_POST['rbLapPenjualanTanggal']) ? $_POST['rbLapPenjualanTanggal'] : $myData['mlap_penjualan_tanggal'];
		if($lapPenjualanTanggal =="No") { $pilihLapPenjualanTanggalN = "checked"; $pilihLapPenjualanTanggalY = ""; } 
		else { $pilihLapPenjualanTanggalN = ""; $pilihLapPenjualanTanggalY = "checked"; }

	$lapPenjualanPeriode 		= isset($_POST['rbLapPenjualanPeriode']) ? $_POST['rbLapPenjualanPeriode'] : $myData['mlap_penjualan_periode'];
		if($lapPenjualanPeriode =="No") { $pilihLapPenjualanPeriodeN = "checked"; $pilihLapPenjualanPeriodeY = ""; } 
		else { $pilihLapPenjualanPeriodeN = ""; $pilihLapPenjualanPeriodeY = "checked"; }

	$lapPenjualanBulan 		= isset($_POST['rbLapPenjualanBulan']) ? $_POST['rbLapPenjualanBulan'] : $myData['mlap_penjualan_bulan'];
		if($lapPenjualanBulan =="No") { $pilihLapPenjualanBulanN = "checked"; $pilihLapPenjualanBulanY = ""; } 
		else { $pilihLapPenjualanBulanN = ""; $pilihLapPenjualanBulanY = "checked"; }

	$lapPenjualanPelanggan 		= isset($_POST['rbLapPenjualanPelanggan']) ? $_POST['rbLapPenjualanPelanggan'] : $myData['mlap_penjualan_pelanggan'];
		if($lapPenjualanPelanggan =="No") { $pilihLapPenjualanPelangganN = "checked"; $pilihLapPenjualanPelangganY = ""; } 
		else { $pilihLapPenjualanPelangganN = ""; $pilihLapPenjualanPelangganY = "checked"; }

	$lapPenjualanBarangTanggal 		= isset($_POST['rbLapPenjualanBarangTanggal']) ? $_POST['rbLapPenjualanBarangTanggal'] : $myData['mlap_penjualan_barang_tanggal'];
		if($lapPenjualanBarangTanggal =="No") { $pilihLapPenjualanBarangTanggalN = "checked"; $pilihLapPenjualanBarangTanggalY = ""; } 
		else { $pilihLapPenjualanBarangTanggalN = ""; $pilihLapPenjualanBarangTanggalY = "checked"; }

	$lapPenjualanBarangPeriode 		= isset($_POST['rbLapPenjualanBarangPeriode']) ? $_POST['rbLapPenjualanBarangPeriode'] : $myData['mlap_penjualan_barang_periode'];
		if($lapPenjualanBarangPeriode =="No") { $pilihLapPenjualanBarangPeriodeN = "checked"; $pilihLapPenjualanBarangPeriodeY = ""; } 
		else { $pilihLapPenjualanBarangPeriodeN = ""; $pilihLapPenjualanBarangPeriodeY = "checked"; }

	$lapPenjualanBarangBulan 		= isset($_POST['rbLapPenjualanBarangBulan']) ? $_POST['rbLapPenjualanBarangBulan'] : $myData['mlap_penjualan_barang_bulan'];
		if($lapPenjualanBarangBulan =="No") { $pilihLapPenjualanBarangBulanN = "checked"; $pilihLapPenjualanBarangBulanY = ""; } 
		else { $pilihLapPenjualanBarangBulanN = ""; $pilihLapPenjualanBarangBulanY = "checked"; }

	$lapPenjualanBarangPelanggan 		= isset($_POST['rbLapPenjualanBarangPelanggan']) ? $_POST['rbLapPenjualanBarangPelanggan'] : $myData['mlap_penjualan_barang_pelanggan'];
		if($lapPenjualanBarangPelanggan =="No") { $pilihLapPenjualanBarangPelangganN = "checked"; $pilihLapPenjualanBarangPelangganY = ""; } 
		else { $pilihLapPenjualanBarangPelangganN = ""; $pilihLapPenjualanBarangPelangganY = "checked"; }

	$lapPenjualanRekapPeriode 		= isset($_POST['rbLapPenjualanRekapPeriode']) ? $_POST['rbLapPenjualanRekapPeriode'] : $myData['mlap_penjualan_rekap_periode'];
		if($lapPenjualanRekapPeriode =="No") { $pilihLapPenjualanRekapPeriodeN = "checked"; $pilihLapPenjualanRekapPeriodeY = ""; } 
		else { $pilihLapPenjualanRekapPeriodeN = ""; $pilihLapPenjualanRekapPeriodeY = "checked"; }

	$lapPenjualanRekapBulan 		= isset($_POST['rbLapPenjualanRekapBulan']) ? $_POST['rbLapPenjualanRekapBulan'] : $myData['mlap_penjualan_rekap_bulan'];
		if($lapPenjualanRekapBulan =="No") { $pilihLapPenjualanRekapBulanN = "checked"; $pilihLapPenjualanRekapBulanY = ""; } 
		else { $pilihLapPenjualanRekapBulanN = ""; $pilihLapPenjualanRekapBulanY = "checked"; }

	$lapPenjualanTerlaris 		= isset($_POST['rbLapPenjualanTerlaris']) ? $_POST['rbLapPenjualanTerlaris'] : $myData['mlap_penjualan_terlaris'];
		if($lapPenjualanTerlaris =="No") { $pilihLapPenjualanTerlarisN = "checked"; $pilihLapPenjualanTerlarisY = ""; } 
		else { $pilihLapPenjualanTerlarisN = ""; $pilihLapPenjualanTerlarisY = "checked"; }

# LABA RUGI PENJUALAN BARANG
$lapLabarugiPeriode 		= isset($_POST['rbLapLabarugiPeriode']) ? $_POST['rbLapLabarugiPeriode'] : $myData['mlap_labarugi_periode'];
	if($lapLabarugiPeriode =="No") { $pilihLapLabarugiPeriodeN = "checked"; $pilihLapLabarugiPeriodeY = ""; } 
	else { $pilihLapLabarugiPeriodeN = ""; $pilihLapLabarugiPeriodeY = "checked"; }

$lapLabarugiBulan 		= isset($_POST['rbLapLabarugiBulan']) ? $_POST['rbLapLabarugiBulan'] : $myData['mlap_labarugi_bulan'];
	if($lapLabarugiBulan =="No") { $pilihLapLabarugiBulanN = "checked"; $pilihLapLabarugiBulanY = ""; } 
	else { $pilihLapLabarugiBulanN = ""; $pilihLapLabarugiBulanY = "checked"; }

	# RETUR JUAL

	$lapReturJualPeriode 		= isset($_POST['rbLapReturJualPeriode']) ? $_POST['rbLapReturJualPeriode'] : $myData['mlap_returjual_periode'];
		if($lapReturJualPeriode =="No") { $pilihLapReturJualPeriodeN = "checked"; $pilihLapReturJualPeriodeY = ""; } 
		else { $pilihLapReturJualPeriodeN = ""; $pilihLapReturJualPeriodeY = "checked"; }

	$lapReturJualBulan 		= isset($_POST['rbLapReturJualBulan']) ? $_POST['rbLapReturJualBulan'] : $myData['mlap_returjual_bulan'];
		if($lapReturJualBulan =="No") { $pilihLapReturJualBulanN = "checked"; $pilihLapReturJualBulanY = ""; } 
		else { $pilihLapReturJualBulanN = ""; $pilihLapReturJualBulanY = "checked"; }


	$lapReturJualBarangPeriode 		= isset($_POST['rbLapReturJualBarangPeriode']) ? $_POST['rbLapReturJualBarangPeriode'] : $myData['mlap_returjual_barang_periode'];
		if($lapReturJualBarangPeriode =="No") { $pilihLapReturJualBarangPeriodeN = "checked"; $pilihLapReturJualBarangPeriodeY = ""; } 
		else { $pilihLapReturJualBarangPeriodeN = ""; $pilihLapReturJualBarangPeriodeY = "checked"; }

	$lapReturJualBarangBulan 		= isset($_POST['rbLapReturJualBarangBulan']) ? $_POST['rbLapReturJualBarangBulan'] : $myData['mlap_returjual_barang_bulan'];
		if($lapReturJualBarangBulan =="No") { $pilihLapReturJualBarangBulanN = "checked"; $pilihLapReturJualBarangBulanY = ""; } 
		else { $pilihLapReturJualBarangBulanN = ""; $pilihLapReturJualBarangBulanY = "checked"; }

	$lapReturJualRekapPeriode 		= isset($_POST['rbLapReturJualRekapPeriode']) ? $_POST['rbLapReturJualRekapPeriode'] : $myData['mlap_returjual_rekap_periode'];
		if($lapReturJualRekapPeriode =="No") { $pilihLapReturJualRekapPeriodeN = "checked"; $pilihLapReturJualRekapPeriodeY = ""; } 
		else { $pilihLapReturJualRekapPeriodeN = ""; $pilihLapReturJualRekapPeriodeY = "checked"; }

	$lapReturJualRekapBulan 		= isset($_POST['rbLapReturJualRekapBulan']) ? $_POST['rbLapReturJualRekapBulan'] : $myData['mlap_returjual_rekap_bulan'];
		if($lapReturJualRekapBulan =="No") { $pilihLapReturJualRekapBulanN = "checked"; $pilihLapReturJualRekapBulanY = ""; } 
		else { $pilihLapReturJualRekapBulanN = ""; $pilihLapReturJualRekapBulanY = "checked"; }
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA USER </b></th>
    </tr>
    <tr>
      <td width="283"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="984"> <input name="textfield" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama User </b></td>
      <td><b>:</b></td>
      <td><input name="txtNamaUser" type="text" value="<?php echo $dataNamaUser; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" size="40" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td><input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="20" maxlength="20" />
      <input name="txtPassLama" type="hidden" value="<?php echo $myData['password']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Level Akses </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Kasir", "Gudang", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>HAK AKSES </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>MASTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong> Data User </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataUser" type="radio" value="No" <?php echo $pilihUserN; ?>/>
        No
        <input name="rbDataUser" type="radio" value="Yes" <?php echo $pilihUserY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataPelanggan" type="radio" value="No"  <?php echo $pilihPelangganN; ?> />
        No
        <input name="rbDataPelanggan" type="radio" value="Yes" <?php echo $pilihPelangganY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataSupplier" type="radio" value="No"  <?php echo $pilihSupplierN; ?> />
        No
        <input name="rbDataSupplier" type="radio" value="Yes" <?php echo $pilihSupplierY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Merek </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataMerek" type="radio" value="No" <?php echo $pilihMerekN; ?> />
        No
        <input name="rbDataMerek" type="radio" value="Yes" <?php echo $pilihMerekY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataKategori" type="radio" value="No" <?php echo $pilihKategoriN; ?> />
        No
        <input name="rbDataKategori" type="radio" value="Yes" <?php echo $pilihKategoriY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Jenis </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataJenis" type="radio" value="No" <?php echo $pilihJenisN; ?> />
        No
        <input name="rbDataJenis" type="radio" value="Yes" <?php echo $pilihJenisY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataBarang" type="radio" value="No" <?php echo $pilihBarangN; ?> />
        No
        <input name="rbDataBarang" type="radio" value="Yes" <?php echo $pilihBarangY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong>Kontrol Stok </strong></td>
      <td><b>:</b></td>
      <td><input name="rbKontrolStok" type="radio" value="No" <?php echo $pilihKontrolStokN; ?> />
        No
          <input name="rbKontrolStok" type="radio" value="Yes" <?php echo $pilihKontrolStokY; ?>/>
      Yes </td>
    </tr>
    <tr>
      <td><strong>Pencarian Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbCariBarang" type="radio" value="No" <?php echo $pilihCariBarangN; ?> />
        No
          <input name="rbCariBarang" type="radio" value="Yes" <?php echo $pilihCariBarangY; ?>/>
Yes </td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>TOOLS</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong> Cetak Label Barcode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbCetakBarcode" type="radio" value="No" <?php echo $pilihBarcodeN; ?> />
        No
        <input name="rbCetakBarcode" type="radio" value="Yes" <?php echo $pilihBarcodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong> Backup &amp; Restore Database </strong></td>
      <td><b>:</b></td>
      <td><input name="rbBackupRestore" type="radio" value="No" <?php echo $pilihBackupRestoreN; ?> />
        No
        <input name="rbBackupRestore" type="radio" value="Yes" <?php echo $pilihBackupRestoreY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Export Barang (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbExportBarang" type="radio" value="No" <?php echo $pilihExportBarangN; ?> />
        No
        <input name="rbExportBarang" type="radio" value="Yes" <?php echo $pilihExportBarangY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Import Barang (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbImportBarang" type="radio" value="No" <?php echo $pilihImportBarangN; ?> />
        No
        <input name="rbImportBarang" type="radio" value="Yes" <?php echo $pilihImportBarangY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Export Pelanggan (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbExportPelanggan" type="radio" value="No" <?php echo $pilihExportPelangganN; ?> />
        No
        <input name="rbExportPelanggan" type="radio" value="Yes" <?php echo $pilihExportPelangganY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Import Pelanggan (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbImportPelanggan" type="radio" value="No" <?php echo $pilihImportPelangganN; ?> />
        No
        <input name="rbImportPelanggan" type="radio" value="Yes" <?php echo $pilihImportPelangganY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>TRANSAKSI</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong> Transaksi Pembelian ke Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPembelian" type="radio" value="No" <?php echo $pilihPembelianN; ?> />
        No
        <input name="rbPembelian" type="radio" value="Yes" <?php echo $pilihPembelianY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong> Transaksi Retur Beli </strong></td>
      <td><b>:</b></td>
      <td><input name="rbReturBeli" type="radio" value="No" <?php echo $pilihReturBeliN; ?> />
        No
        <input name="rbReturBeli" type="radio" value="Yes" <?php echo $pilihReturBeliY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong> Transaksi Penjualan oleh Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPenjualan" type="radio" value="No" <?php echo $pilihPenjualanN; ?> />
        No
        <input name="rbPenjualan" type="radio" value="Yes" <?php echo $pilihPenjualanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Transaksi Retur Jual </strong></td>
      <td><b>:</b></td>
      <td><input name="rbReturJual" type="radio" value="No" <?php echo $pilihReturJualN; ?> />
        No
          <input name="rbReturJual" type="radio" value="Yes" <?php echo $pilihReturJualY; ?>/>
      Yes</td>
    </tr>
    <tr>
      <td><strong>Pembayaran oleh Pelanggan (Trans Jual) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbBayarJual" type="radio" value="No" <?php echo $pilihBayarJualN; ?> />
        No
        <input name="rbBayarJual" type="radio" value="Yes" <?php echo $pilihBayarJualY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Pembayaran ke Supplier (Trans Beli) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbBayarBeli" type="radio" value="No" <?php echo $pilihBayarBeliN; ?> />
        No
        <input name="rbBayarBeli" type="radio" value="Yes" <?php echo $pilihBayarBeliY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN MASTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan User </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapUser" type="radio" value="No" <?php echo $pilihLapUserN; ?> />
        No
        <input name="rbLapUser" type="radio" value="Yes" <?php echo $pilihLapUserY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPelanggan" type="radio" value="No" <?php echo $pilihLapPelangganN; ?> />
        No
        <input name="rbLapPelanggan" type="radio" value="Yes" <?php echo $pilihLapPelangganY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapSupplier" type="radio" value="No" <?php echo $pilihLapSupplierN; ?> />
        No
        <input name="rbLapSupplier" type="radio" value="Yes" <?php echo $pilihLapSupplierY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Merek </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapMerek" type="radio" value="No" <?php echo $pilihLapMerekN; ?> />
        No
        <input name="rbLapMerek" type="radio" value="Yes" <?php echo $pilihLapMerekY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapKategori" type="radio" value="No" <?php echo $pilihLapKategoriN; ?> />
        No
        <input name="rbLapKategori" type="radio" value="Yes" <?php echo $pilihLapKategoriY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Jenis </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapJenis" type="radio" value="No" <?php echo $pilihLapJenisN; ?> />
        No
        <input name="rbLapJenis" type="radio" value="Yes" <?php echo $pilihLapJenisY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Barang per Merek </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangMerek" type="radio" value="No" <?php echo $pilihLapBarangMerekN; ?> />
        No
        <input name="rbLapBarangMerek" type="radio" value="Yes" <?php echo $pilihLapBarangMerekY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Berang per Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangKategori" type="radio" value="No" <?php echo $pilihLapBarangKategoriN; ?> />
        No
        <input name="rbLapBarangKategori" type="radio" value="Yes" <?php echo $pilihLapBarangKategoriY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Berang per Jenis </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangJenis" type="radio" value="No" <?php echo $pilihLapBarangJenisN; ?> />
        No
        <input name="rbLapBarangJenis" type="radio" value="Yes" <?php echo $pilihLapBarangJenisY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Berang Stok Minimal </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangMinimal" type="radio" value="No" <?php echo $pilihLapBarangMinimalN; ?> />
        No
        <input name="rbLapBarangMinimal" type="radio" value="Yes" <?php echo $pilihLapBarangMinimalY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Berang Stok Maksimal </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangMaksimal" type="radio" value="No" <?php echo $pilihLapBarangMaksimalN; ?> />
        No
        <input name="rbLapBarangMaksimal" type="radio" value="Yes" <?php echo $pilihLapBarangMaksimalY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN PEMBELIAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Pembelian per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianPeriode" type="radio" value="No" <?php echo $pilihLapPembelianPeriodeN; ?> />
        No
        <input name="rbLapPembelianPeriode" type="radio" value="Yes" <?php echo $pilihLapPembelianPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianBulan" type="radio" value="No" <?php echo $pilihLapPembelianBulanN; ?> />
        No
        <input name="rbLapPembelianBulan" type="radio" value="Yes" <?php echo $pilihLapPembelianBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian per Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianSupplier" type="radio" value="No" <?php echo $pilihLapPembelianSupplierN; ?> />
        No
        <input name="rbLapPembelianSupplier" type="radio" value="Yes" <?php echo $pilihLapPembelianSupplierY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianBarangPeriode" type="radio" value="No" <?php echo $pilihLapPembelianBarangPeriodeN; ?> />
        No
        <input name="rbLapPembelianBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapPembelianBarangPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianBarangBulan" type="radio" value="No" <?php echo $pilihLapPembelianBarangBulanN; ?> />
        No
        <input name="rbLapPembelianBarangBulan" type="radio" value="Yes" <?php echo $pilihLapPembelianBarangBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianRekapPeriode" type="radio" value="No" <?php echo $pilihLapPembelianRekapPeriodeN; ?> />
        No
        <input name="rbLapPembelianRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapPembelianRekapPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianRekapBulan" type="radio" value="No" <?php echo $pilihLapPembelianRekapBulanN; ?> />
        No
        <input name="rbLapPembelianRekapBulan" type="radio" value="Yes" <?php echo $pilihLapPembelianRekapBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN RETUR BELI </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Retur Beli per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturBeliPeriode" type="radio" value="No" <?php echo $pilihLapReturBeliPeriodeN; ?> />
        No
        <input name="rbLapReturBeliPeriode" type="radio" value="Yes" <?php echo $pilihLapReturBeliPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Beli per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturBeliBulan" type="radio" value="No" <?php echo $pilihLapReturBeliBulanN; ?> />
        No
        <input name="rbLapReturBeliBulan" type="radio" value="Yes" <?php echo $pilihLapReturBeliBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Beli Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturBeliBarangPeriode" type="radio" value="No" <?php echo $pilihLapReturBeliBarangPeriodeN; ?> />
        No
        <input name="rbLapReturBeliBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapReturBeliBarangPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Beli Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturBeliBarangBulan" type="radio" value="No" <?php echo $pilihLapReturBeliBarangBulanN; ?> />
        No
        <input name="rbLapReturBeliBarangBulan" type="radio" value="Yes" <?php echo $pilihLapReturBeliBarangBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Beli Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturBeliRekapPeriode" type="radio" value="No" <?php echo $pilihLapReturBeliRekapPeriodeN; ?> />
        No
        <input name="rbLapReturBeliRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapReturBeliRekapPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Beli Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturBeliRekapBulan" type="radio" value="No" <?php echo $pilihLapReturBeliRekapBulanN; ?> />
        No
        <input name="rbLapReturBeliRekapBulan" type="radio" value="Yes" <?php echo $pilihLapReturBeliRekapBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN PENJUALAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Penjualan per Tanggal (Hari) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanTanggal" type="radio" value="No" <?php echo $pilihLapPenjualanTanggalN; ?> />
        No
        <input name="rbLapPenjualanTanggal" type="radio" value="Yes" <?php echo $pilihLapPenjualanTanggalY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Penjualan per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanPeriode" type="radio" value="No" <?php echo $pilihLapPenjualanPeriodeN; ?> />
        No
        <input name="rbLapPenjualanPeriode" type="radio" value="Yes" <?php echo $pilihLapPenjualanPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBulan" type="radio" value="No" <?php echo $pilihLapPenjualanBulanN; ?> />
        No
        <input name="rbLapPenjualanBulan" type="radio" value="Yes" <?php echo $pilihLapPenjualanBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan per Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanPelanggan" type="radio" value="No" <?php echo $pilihLapPenjualanPelangganN; ?> />
        No
        <input name="rbLapPenjualanPelanggan" type="radio" value="Yes" <?php echo $pilihLapPenjualanPelangganY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Brg per Tanggal </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBarangTanggal" type="radio" value="No" <?php echo $pilihLapPenjualanBarangTanggalN; ?> />
        No
        <input name="rbLapPenjualanBarangTanggal" type="radio" value="Yes" <?php echo $pilihLapPenjualanBarangTanggalY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBarangPeriode" type="radio" value="No" <?php echo $pilihLapPenjualanBarangPeriodeN; ?> />
        No
        <input name="rbLapPenjualanBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapPenjualanBarangPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBarangBulan" type="radio" value="No" <?php echo $pilihLapPenjualanBarangBulanN; ?> />
        No
        <input name="rbLapPenjualanBarangBulan" type="radio" value="Yes" <?php echo $pilihLapPenjualanBarangBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Brg per Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBarangPelanggan" type="radio" value="No" <?php echo $pilihLapPenjualanBarangPelangganN; ?> />
        No
        <input name="rbLapPenjualanBarangPelanggan" type="radio" value="Yes" <?php echo $pilihLapPenjualanBarangPelangganY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanRekapPeriode" type="radio" value="No" <?php echo $pilihLapPenjualanRekapPeriodeN; ?> />
        No
        <input name="rbLapPenjualanRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapPenjualanRekapPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanRekapBulan" type="radio" value="No" <?php echo $pilihLapPenjualanRekapBulanN; ?> />
        No
        <input name="rbLapPenjualanRekapBulan" type="radio" value="Yes" <?php echo $pilihLapPenjualanRekapBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Barang Terlaris </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanTerlaris" type="radio" value="No" <?php echo $pilihLapPenjualanTerlarisN; ?> />
        No
        <input name="rbLapPenjualanTerlaris" type="radio" value="Yes" <?php echo $pilihLapPenjualanTerlarisY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LABA/ RUGI PENJUALAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan  Laba/Rugi Penjualan  per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapLabarugiPeriode" type="radio" value="No" <?php echo $pilihLapLabarugiPeriodeN; ?> />
        No
        <input name="rbLapLabarugiPeriode" type="radio" value="Yes" <?php echo $pilihLapLabarugiPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Laba/Rugi Penjualan  per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapLabarugiBulan" type="radio" value="No" <?php echo $pilihLapLabarugiBulanN; ?> />
        No
        <input name="rbLapLabarugiBulan" type="radio" value="Yes" <?php echo $pilihLapLabarugiBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN RETUR JUAL </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Retur Jual per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturJualPeriode" type="radio" value="No" <?php echo $pilihLapReturJualPeriodeN; ?> />
        No
        <input name="rbLapReturJualPeriode" type="radio" value="Yes" <?php echo $pilihLapReturJualPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Jual per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturJualBulan" type="radio" value="No" <?php echo $pilihLapReturJualBulanN; ?> />
        No
        <input name="rbLapReturJualBulan" type="radio" value="Yes" <?php echo $pilihLapReturJualBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Jual Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturJualBarangPeriode" type="radio" value="No" <?php echo $pilihLapReturJualBarangPeriodeN; ?> />
        No
        <input name="rbLapReturJualBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapReturJualBarangPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Jual Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturJualBarangBulan" type="radio" value="No" <?php echo $pilihLapReturJualBarangBulanN; ?> />
        No
        <input name="rbLapReturJualBarangBulan" type="radio" value="Yes" <?php echo $pilihLapReturJualBarangBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Jual Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturJualRekapPeriode" type="radio" value="No" <?php echo $pilihLapReturJualRekapPeriodeN; ?> />
        No
        <input name="rbLapReturJualRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapReturJualRekapPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Jual  Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturJualRekapBulan" type="radio" value="No" <?php echo $pilihLapReturJualRekapBulanN; ?> />
        No
        <input name="rbLapReturJualRekapBulan" type="radio" value="Yes" <?php echo $pilihLapReturJualRekapBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan2" value=" Simpan " /></td>
    </tr>
  </table>
</form>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
