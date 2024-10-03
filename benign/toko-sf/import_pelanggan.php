<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/excel_reader2.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_import_pelanggan'] == "Yes") {

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnImport'])){
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (empty($_FILES['namaFile']['tmp_name'])) {
		$pesanError[] = "Data <b>File Excel Pelanggan</b> belum ada yang diplih, gunakan format Excel !";		
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
		# TIDAK ADA ERROR SATUPUN, MAKA DATA DIPROS
		# Jika jumlah error message tidak ada, simpan datanya

		// membaca file excel yang diupload
		$data = new Spreadsheet_Excel_Reader($_FILES['namaFile']['tmp_name']);
		
		// membaca jumlah baris dari data excel
		$baris = $data->rowcount($sheet_index=0);

		echo "JUMLAH BARIS DATA EXCEL : ".$baris;
		 
		// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
		$sukses = 0;
		$gagal = 0;
		$update	= 0;
		
		# BACA FILE EXCEL, LALU MASUKAN KE TABEL data_klb
		// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
		for($i=3; $i<=$baris; $i++) {
			// membaca data kode (kolom ke-1)
			$dataKode	= trim($data->val($i, 1)); // data kolom Kode
			$dataKode	= str_replace(" ","",$dataKode);
			 
			$dataNama		= $data->val($i, 2); // data kolom Nama
			$dataNama		= str_replace('"','',$dataNama);
			$dataNamaToko	= $data->val($i, 3); // data kolom Nama Toko 
			$dataNamaToko	= str_replace('"','',$dataNamaToko);
			$dataAlamat		= $data->val($i, 4); // data kolom Alamat
			$dataAlamat		= str_replace('"','',$dataAlamat);
			$dataTelepon	= $data->val($i, 5);  
			
			// Proses Input data baru
			$dataGagal	= "";
			
			// Periksa apakah datanya sudah pernah diinput
			$cekSql	= "SELECT * FROM pelanggan WHERE kd_pelanggan='$dataKode'";
			$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Gagal query cek ".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				# UPDATE DATA (DATA LAMA DIPERBARUI DENGAN DATA DARI EXCEL)
				$mySql	= "UPDATE pelanggan SET 
										nm_pelanggan	= '$dataNama',
										nm_toko			= '$dataNamaToko',
										alamat			= '$dataAlamat',
										no_telepon		= '$dataTelepon'
								WHERE kd_pelanggan ='$dataKode'"; 
				mysql_query($mySql, $koneksidb) or die ("Gagal query update".mysql_error());
				$update++;
			}
			else {
				# SIMPAN DATA BARU
				$mySql	= "INSERT INTO pelanggan (kd_pelanggan, nm_pelanggan, nm_toko, alamat, no_telepon) 
								VALUES ('$dataKode', '$dataNama', '$dataNamaToko', '$dataAlamat', '$dataTelepon')";
				$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
				if($myQry){
					// jika proses insert data sukses, maka counter $sukses bertambah
					// jika gagal, maka counter $gagal yang bertambah
					if($myQry) $sukses++; else $gagal++;
				}
			}
		}
	
		
		# HASIL DAN REPORT
		echo "<h3>Proses import data selesai.</h3>";
		echo "<p>Jumlah data baru yang sukses diimport : ".$sukses."<br>";
		echo "<p>Jumlah data update yang sukses diimport : ".$update."<br>";
		echo "Jumlah data yang gagal diimport : ".$gagal."</p>";
		
		echo "<meta http-equiv='refresh' content='5; url=?open=Import-Pelanggan'>";
		exit;
	}	
	
} // Penutup POST	

# =============
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataJenis	    = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';

?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"  name="form1">
<table class="table-list" width="100%" style="margin-top:0px;">
	
	<tr>
	  <td colspan="3" bgcolor="#CCCCCC"><strong>IMPORT DATA PELANGGAN </strong></td>
    </tr>
	<tr>
	  <td width="18%"><strong>File Data  ( .Xls 2003 ) </strong></td>
	  <td width="1%"><b>:</b></td>
	  <td width="81%"><input name="namaFile" type="file" size="50" /></td>
	</tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnImport" value=" IMPORT FILE " style="cursor:pointer;"></td>
    </tr>
</table>
<br />
<h2><strong>Syarat file Excel yang akan di-Import adalah </strong><br />
</h2>
<ol>
  <li>File Excel disimpan dalam format Excel lama, yaitu <strong>Excel 97 - 2003 ( .Xls ) </strong></li>
  <li>Atur susunan kolom datanya adalah;    
    <table border="0" cellpadding="2" cellspacing="1" width="800" class="table-list" >
      <tbody>
        <tr>
          <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
          <td width="226" bgcolor="#CCCCCC"><strong>Nama Pelanggan </strong></td>
          <td width="108" bgcolor="#CCCCCC"><strong>Nama Toko </strong></td>
          <td width="261" bgcolor="#CCCCCC"><strong>Alamat</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
        </tr>
        <tr bgcolor="">
          <td>P0001</td>
          <td>CASH (Tunai)</td>
          <td>-</td>
          <td>-</td>
          <td width="45">0819111112</td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td bgcolor="#F5F5F5">P0002</td>
          <td bgcolor="#F5F5F5">Waluyo</td>
          <td bgcolor="#F5F5F5">Waluyo Boneka</td>
          <td bgcolor="#F5F5F5">Jl. Janti, Karang Jambe, Yogyakarta</td>
          <td width="45">0819111113</td>
        </tr>
        <tr bgcolor="">
          <td>P0003</td>
          <td>Sardi Sudrajad</td>
          <td>Boneka Sardi</td>
          <td>Jl. Janti, Karang Jambe 130, Yogyakarta</td>
          <td width="45">0819111114</td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td bgcolor="#F5F5F5">P0004</td>
          <td bgcolor="#F5F5F5">Taufik Hidayat</td>
          <td bgcolor="#F5F5F5">Boneka Lutcu</td>
          <td bgcolor="#F5F5F5">Jl. Magelang, Km 2, Yogyakarta</td>
          <td width="45">0819111115</td>
        </tr>
      </tbody>
    </table>
  </li>
  <li>Catatan, Jika ingin Meng-Import file Xls hasil Export dari Tools dalam program ini, maka Anda harus memodifikasi dulu pada salah satu bagian datanya, atau cukup diklik 2x pada Sel (cell) Excel lalu disimpan (Save). Contoh pesan error: <strong>The filename C:\xampp\tmp\phpB5.tmp is not readable</strong></li>
</ol>
</form>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
