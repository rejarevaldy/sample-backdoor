<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/excel_reader2.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_import_barang'] == "Yes") {

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnImport'])){
	# Membaca data dari form
	$cmbJenis		= $_POST['cmbJenis'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (empty($_FILES['namaFile']['tmp_name'])) {
		$pesanError[] = "Data <b>File Excel Barang</b> belum ada yang diplih, gunakan format Excel !";		
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
			 
			$dataBarcode	= $data->val($i, 2); // data kolom Barcode 
			$dataNama		= $data->val($i, 3); // data kolom Nama
			$dataNama		= str_replace('"','',$dataNama);
			$dataKeterangan	= $data->val($i, 4); // data kolom Keterangan
			$dataKeterangan	= str_replace('"','',$dataKeterangan);
			$dataSatuan		= $data->val($i, 5);  
			$dataHargaBeli	= $data->val($i, 6); 
			$dataHargaJual_1= $data->val($i, 7); 
			$dataHargaJual_2= $data->val($i, 8); 
			$dataHargaJual_3= $data->val($i, 9); 
			$dataHargaJual_4= $data->val($i, 10); 
			$dataStok		= $data->val($i, 11); 
			$dataStokOpname	= $data->val($i, 12); 
			$dataStokMin	= $data->val($i, 13); 
			$dataStokMax	= $data->val($i, 14); 
			$dataLokasiStok	= $data->val($i, 15);
			$dataLokasiRak	= $data->val($i, 16); 
			$dataMerek		= $data->val($i, 17); 
			$dataJenis		= $data->val($i, 18);  
			$dataSupplier	= $data->val($i, 19);
			
			# DATA JENIS
			if($cmbJenis =="Semua") {
				// Jika Jenis dipilih Semua (...), berarti data diimport persis seperti keadaan File Excel
				$dataJenis		= $data->val($i, 18); 
			}
			else {
				// Jika Jenis dipilih salah satu, maka Jenis mengikuti List/Menu(combo)
				$dataJenis	= $cmbJenis;					
			}

			// Proses Input data baru
			$dataGagal	= "";
			
			// Periksa apakah datanya sudah pernah diinput
			$cekSql	= "SELECT * FROM barang WHERE kd_barang='$dataKode'";
			$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Gagal query cek ".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				# UPDATE DATA (DATA LAMA DIPERBARUI DENGAN DATA DARI EXCEL)
				$mySql	= "UPDATE barang SET 
										barcode			= '$dataBarcode',
										nm_barang		= '$dataNama',
										keterangan		= '$dataKeterangan',
										satuan			= '$dataSatuan',
										harga_modal		= '$dataHargaBeli',
										harga_jual_1	= '$dataHargaJual_1',
										harga_jual_2	= '$dataHargaJual_2',
										harga_jual_3	= '$dataHargaJual_3',
										harga_jual_4	= '$dataHargaJual_4',
										stok			= '$dataStok',
										stok_opname		= '$dataStokOpname',
										stok_minimal	= '$dataStokMin',
										stok_maksimal	= '$dataStokMax',
										lokasi_stok		= '$dataLokasiStok',
										lokasi_rak		= '$dataLokasiRak',
										kd_merek		= '$dataMerek',
										kd_jenis		= '$dataJenis',
										kd_supplier		= '$dataSupplier'
								WHERE kd_barang ='$dataKode'"; 
				mysql_query($mySql, $koneksidb) or die ("Gagal query update".mysql_error());
				$update++;
			}
			else {
				# SIMPAN DATA BARU
				$mySql	= "INSERT INTO barang (kd_barang, barcode, nm_barang, keterangan, satuan, 
										harga_modal, harga_jual_1, harga_jual_2, harga_jual_3, harga_jual_4, 
										stok, stok_opname, stok_minimal, stok_maksimal, lokasi_stok, lokasi_rak, 
										kd_merek, kd_jenis, kd_supplier) 
								VALUES ('$dataKode',
										'$dataBarcode',
										'$dataNama',
										'$dataKeterangan',
										'$dataSatuan',
										'$dataHargaBeli',
										'$dataHargaJual_1',
										'$dataHargaJual_2',
										'$dataHargaJual_3',
										'$dataHargaJual_4',
										'$dataStok',
										'$dataStokOpname',
										'$dataStokMin',
										'$dataStokMax', 
										'$dataLokasiStok', '$dataLokasiRak', 
										'$dataMerek', '$dataJenis', '$dataSupplier')";
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
		
		echo "<meta http-equiv='refresh' content='5; url=?open=Import-Barang'>";
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
	  <td colspan="3" bgcolor="#CCCCCC"><strong>IMPORT DATA BARANG </strong></td>
    </tr>
	<tr>
      <td><strong>Kategori &amp; Jenis </strong></td>
	  <td><strong>:</strong></td>
	  <td><select name="cmbKategori" onchange="javascript:submitform();" >
        <option value="Semua">....</option>
        <?php
		  $bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
		  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		  while ($bacaData = mysql_fetch_array($bacaQry)) {
			if ($bacaData['kd_kategori'] == $dataKategori) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori]</option>";
		  }
		  ?>
      </select>
	    / 
	    <select name="cmbJenis">
          <option value="Semua">....</option>
          <?php
	  $bacaSql = "SELECT * FROM jenis WHERE kd_kategori ='$dataKategori' ORDER BY kd_jenis";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jenis'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_jenis]' $cek>$bacaData[nm_jenis]</option>";
	  }
	  ?>
        </select></td>
    </tr>
	<tr>
	  <td width="18%"><strong>File Data Barang ( .Xls 2003 ) </strong></td>
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
    <table width="1305" cellpadding="0" cellspacing="2"  class="table-list" >
      <col width="129" />
      <col width="95" />
      <col width="291" />
      <col width="64" span="2" />
      <tr height="20">
        <td width="38" height="20" bgcolor="#F5F5F5"><strong>Kode</strong></td>
        <td width="75" bgcolor="#F5F5F5"><strong>Barcode</strong></td>
        <td width="160" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
        <td width="63" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
        <td width="67" bgcolor="#F5F5F5"><strong>Satuan </strong></td>
        <td width="65" bgcolor="#F5F5F5"><strong>Hrg Modal </strong></td>
        <td width="60" bgcolor="#F5F5F5"><strong> Jual 1 </strong></td>
        <td width="34" bgcolor="#F5F5F5"><strong>Jual 2 </strong></td>
        <td width="34" bgcolor="#F5F5F5"><strong>Jual 3 </strong></td>
        <td width="34" bgcolor="#F5F5F5"><strong>Jual 4 </strong></td>
        <td width="35" bgcolor="#F5F5F5"><strong>Stok</strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>Stok Opn </strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>Stok Max </strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>Stok Min </strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>LokStok</strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>LokRak</strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>Kode Merk </strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>Kode Jenis </strong></td>
        <td width="70" bgcolor="#F5F5F5"><strong>KodeSupplier</strong></td>
      </tr>
      <tr height="20">
        <td height="20">B000001&nbsp;</td>
        <td>S000004318 </td>
        <td>Kunci Mas Minyak Goreng Pouch 2L</td>
        <td>-</td>
        <td>Pch</td>
        <td>25000</td>
        <td>30100</td>
        <td>30100</td>
        <td>30100</td>
        <td>30100</td>
        <td>100</td>
        <td>5</td>
        <td>100</td>
        <td>20</td>
        <td>Toko</td>
        <td>Miny001</td>
        <td>M014</td>
        <td>J0001</td>
        <td>S002</td>
      </tr>
      <tr height="20">
        <td height="20">B000002</td>
        <td>S000004317</td>
        <td>Kunci Mas Minyak Goreng Botol 1.9L</td>
        <td>-</td>
        <td>Pch</td>
        <td>23000</td>
        <td>27900</td>
        <td>27900</td>
        <td>27900</td>
        <td>27900</td>
        <td>100</td>
        <td>3</td>
        <td>100</td>
        <td>20</td>
        <td>Toko</td>
        <td>Miny001</td>
        <td>M014</td>
        <td>J0001</td>
        <td>S002</td>
      </tr>
      <tr height="20">
        <td height="20">B000003</td>
        <td>S000011252 </td>
        <td>Tropical Minyak Goreng Botol 1000ml</td>
        <td>-</td>
        <td>Pch</td>
        <td>11000</td>
        <td>15000</td>
        <td>15000</td>
        <td>15000</td>
        <td>15000</td>
        <td>100</td>
        <td>3</td>
        <td>100</td>
        <td>20</td>
        <td>Toko</td>
        <td>Miny001</td>
        <td>M014</td>
        <td>J0001</td>
        <td>S002</td>
      </tr>
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
