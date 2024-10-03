<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";
# Hak akses
if($aksesData['mu_data_barang'] == "Yes") {

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtBarcode		= $_POST['txtBarcode'];
	
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan	= str_replace("'","&acute;",$txtKeterangan); // menghalangi penulisan tanda petik satu (')
	
	$cmbSatuan		= $_POST['cmbSatuan'];
		
	$txtHargaModal	= $_POST['txtHargaModal'];
	$txtHargaModal	= str_replace(".","",$txtHargaModal); // validasi, supaya tanda titik dihilangkan, angka 1.700 = 1700
	
	$txtHargaModal_1	= $_POST['txtHargaModal_1'];
	$txtHargaModal_1	= str_replace(".","",$txtHargaModal_1); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaModal_2	= $_POST['txtHargaModal_2'];
	$txtHargaModal_2	= str_replace(".","",$txtHargaModal_2); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaModal_3	= $_POST['txtHargaModal_3'];
	$txtHargaModal_3	= str_replace(".","",$txtHargaModal_3); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaModal_4	= $_POST['txtHargaModal_4'];
	$txtHargaModal_4	= str_replace(".","",$txtHargaModal_4); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaJual_1	= $_POST['txtHargaJual_1'];
	$txtHargaJual_1	= str_replace(".","",$txtHargaJual_1); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaJual_2	= $_POST['txtHargaJual_2'];
	$txtHargaJual_2	= str_replace(".","",$txtHargaJual_2); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaJual_3	= $_POST['txtHargaJual_3'];
	$txtHargaJual_3	= str_replace(".","",$txtHargaJual_3); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtHargaJual_4	= $_POST['txtHargaJual_4'];
	$txtHargaJual_4	= str_replace(".","",$txtHargaJual_4); // validasi, supaya tanda titik dihilangkan, angka 1.700 menjadi 1700

	$txtStokOpname	= $_POST['txtStokOpname'];
	$txtStokMaksimal= $_POST['txtStokMaksimal'];
	$txtStokMinimal	= $_POST['txtStokMinimal'];
	
	$cmbLokasiStok	= $_POST['cmbLokasiStok'];
	$txtLokasiRak	= $_POST['txtLokasiRak'];
	
	$cmbSupplier	= $_POST['cmbSupplier'];
	$cmbMerek		= $_POST['cmbMerek'];
	$cmbKategori	= $_POST['cmbKategori'];
	$cmbJenis		= $_POST['cmbJenis'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($cmbSatuan)=="Kosong") {
		$pesanError[] = "Data <b>Satuan</b> belum dipilih, silahkan dilengkapi !";		
	}
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum dipilih, silahkan dilengkapi !";		
	}
	if (trim($cmbMerek)=="Kosong") {
		$pesanError[] = "Data <b>Merek</b> belum dipilih, silahkan dilengkapi !";		
	}
	if (trim($cmbJenis)=="Kosong") {
		$pesanError[] = "Data <b>Jenis Barang</b> belum dipilih, silahkan dilengkapi !";		
	}
	if (trim($cmbLokasiStok)=="Kosong") {
		$pesanError[] = "Data <b>Lokasi Stok</b> belum dipilih, silahkan dilengkapi !";		
	}
	if (trim($txtLokasiRak)=="") {
		$pesanError[] = "Data <b>Lokasi Rak</b> tidak boleh kosong, boleh diisi tanda (-) jika tidak ada !";		
	}
	
	if (trim($txtHargaModal)=="" or ! is_numeric(trim($txtHargaModal))) {
		$pesanError[] = "Data <b>Harga Beli (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}

	if (trim($txtHargaModal_1)=="" or ! is_numeric(trim($txtHargaModal_1))) {
		$pesanError[] = "Data <b>Harga Modal (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	
	if (trim($txtHargaModal_2)=="" or ! is_numeric(trim($txtHargaModal_2))) {
		$pesanError[] = "Data <b>Harga Modal (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}	
	
	if (trim($txtHargaModal_3)=="" or ! is_numeric(trim($txtHargaModal_3))) {
		$pesanError[] = "Data <b>Harga Modal (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}	
	
	if (trim($txtHargaModal_4)=="" or ! is_numeric(trim($txtHargaModal_4))) {
		$pesanError[] = "Data <b>Harga Modal (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}

	if (trim($txtHargaJual_1)=="" or ! is_numeric(trim($txtHargaJual_1))) {
		$pesanError[] = "Data <b>Harga Jual Level 1 (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	else {
		if (trim($txtHargaModal) >= trim($txtHargaJual_1) ) {
			$pesanError[] = "Data <b>Harga Jual Level 1 (Rp.)</b> masih rugi, harus lebih besar dari <b>Hrg. Modal (Rp.)</b> !";		
		}		
	}
	
	if (trim($txtHargaJual_2)=="" or ! is_numeric(trim($txtHargaJual_2))) {
		$pesanError[] = "Data <b>Harga Jual Level 2 (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	else {
		if (trim($txtHargaModal) >= trim($txtHargaJual_2) ) {
			$pesanError[] = "Data <b>Harga Jual Level 2 (Rp.)</b> masih rugi, harus lebih besar dari <b>Hrg. Modal (Rp.)</b> !";		
		}		
	}
	
	if (trim($txtHargaJual_3)=="" or ! is_numeric(trim($txtHargaJual_3))) {
		$pesanError[] = "Data <b>Harga Jual Level 3 (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	else {
		if (trim($txtHargaModal) >= trim($txtHargaJual_3) ) {
			$pesanError[] = "Data <b>Harga Jual Level 3 (Rp.)</b> masih rugi, harus lebih besar dari <b>Hrg. Modal (Rp.)</b> !";		
		}		
	}
	
	if (trim($txtHargaJual_4)=="" or ! is_numeric(trim($txtHargaJual_4))) {
		$pesanError[] = "Data <b>Harga Jual Level 4 (Rp.)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";	
	}
	else {
		if (trim($txtHargaModal) >= trim($txtHargaJual_4) ) {
			$pesanError[] = "Data <b>Harga Jual Level 4 (Rp.)</b> masih rugi, harus lebih besar dari <b>Hrg. Modal (Rp.)</b> !";		
		}		
	}

	if (trim($txtStokOpname)=="" or ! is_numeric(trim($txtStokOpname))) {
		$pesanError[] = "Data <b>Stok Opname (barang tidak siap jual)</b> harus diisi angka atau diisi 0 !";		
	}
	if (trim($txtStokMinimal)=="" or ! is_numeric(trim($txtStokMinimal))) {
		$pesanError[] = "Data <b>Stok Batas Minimal</b> harus diisi angka atau diisi 0 !";		
	}
	if (trim($txtStokMaksimal)=="" or ! is_numeric(trim($txtStokMaksimal))) {
		$pesanError[] = "Data <b>Stok Batas Maksimal/ Aman</b> harus diisi angka atau diisi 0 !";		
	}
	
	# Validasi Nama barang, jika sudah ada akan ditolak
	$sqlCek="SELECT * FROM barang WHERE nm_barang='$txtNama'";
	$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($qryCek)>=1){
		$pesanError[] = "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, ganti dengan yang lain";
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
		# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("barang", "B");
		$mySql	= "INSERT INTO barang (kd_barang, barcode, nm_barang, keterangan, satuan, 
										harga_modal, harga_modal_1, harga_modal_2, harga_modal_3, harga_modal_4, harga_jual_1, harga_jual_2, harga_jual_3, harga_jual_4,
										stok_opname, stok_minimal, stok_maksimal,  
										lokasi_stok, lokasi_rak, kd_supplier, kd_merek, kd_jenis) 
							VALUES ('$kodeBaru', '$txtBarcode', '$txtNama', '$txtKeterangan', '$cmbSatuan', 
									'$txtHargaModal', '$txtHargaModal_1', '$txtHargaModal_2', '$txtHargaModal_3', '$txtHargaModal_4', '$txtHargaJual_1', '$txtHargaJual_2', '$txtHargaJual_3', '$txtHargaJual_4',
									'$txtStokOpname', '$txtStokMinimal', '$txtStokMaksimal',
									'$cmbLokasiStok', '$txtLokasiRak', '$cmbSupplier', '$cmbMerek', '$cmbJenis')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Add'>";
		}
		exit;
	}

} // Penutup POST
	
# MASUKKAN DATA KE VARIABEL
$dataKode	= buatKode("barang", "B");
$barcode	= substr($dataKode, -6, 6); // 6 digit dari kanan (hilangkan karakter simbol B)
$dataBarcode		= isset($_POST['txtBarcode']) ? $_POST['txtBarcode'] : $barcode;
$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataSatuan			= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : '';
$dataHargaModal		= isset($_POST['txtHargaModal']) ? $_POST['txtHargaModal'] : '0';
$dataHargaModal_1	= isset($_POST['txtHargaModal_1']) ? $_POST['txtHargaModal_1'] : '0';
$dataHargaModal_2	= isset($_POST['txtHargaModal_2']) ? $_POST['txtHargaModal_2'] : '0';
$dataHargaModal_3	= isset($_POST['txtHargaModal_3']) ? $_POST['txtHargaModal_3'] : '0';
$dataHargaModal_4	= isset($_POST['txtHargaModal_4']) ? $_POST['txtHargaModal_4'] : '0';
$dataHargaJual_1	= isset($_POST['txtHargaJual_1']) ? $_POST['txtHargaJual_1'] : '0';
$dataHargaJual_2	= isset($_POST['txtHargaJual_2']) ? $_POST['txtHargaJual_2'] : '0';
$dataHargaJual_3	= isset($_POST['txtHargaJual_3']) ? $_POST['txtHargaJual_3'] : '0';
$dataHargaJual_4	= isset($_POST['txtHargaJual_4']) ? $_POST['txtHargaJual_4'] : '0';
$dataSupplier		= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataMerek			= isset($_POST['cmbMerek']) ? $_POST['cmbMerek'] : '';
$dataKategori		= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataLokasiStok		= isset($_POST['cmbLokasiStok']) ? $_POST['cmbLokasiStok'] : '';
$dataLokasiRak		= isset($_POST['txtLokasiRak']) ? $_POST['txtLokasiRak'] : '';
$dataStokOpname		= isset($_POST['txtStokOpname']) ? $_POST['txtStokOpname'] : '0';
$dataStokMinimal	= isset($_POST['txtStokMinimal']) ? $_POST['txtStokMinimal'] : '0';
$dataStokMaksimal	= isset($_POST['txtStokMaksimal']) ? $_POST['txtStokMaksimal'] : '0';
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="100%" cellpadding="2" cellspacing="1" class="table-list" style="margin-top:0px;">
	<tr>
	  <th colspan="3">TAMBAH DATA  BARANG </th>
	</tr>
	<tr>
	  <td width="22%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="77%"><input name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly"/></td></tr>
	<tr>
      <td><b>Barcode</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBarcode" value="<?php echo $dataBarcode; ?>" size="40" maxlength="20" 
	  				onblur="if (value == '') {value = '<?php echo $dataBarcode; ?>'}" 
				 	onfocus="if (value == '<?php echo $dataBarcode; ?>') {value =''}"/></td>
    </tr>
	<tr>
	  <td><b>Nama Barang </b></td>
      <td><b>:</b></td>
	  <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="80" /></td>
    </tr>
	<tr>
	  <td><b>Keterangan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="200" /></td>
	</tr>
	<tr>
	  <td><strong>Satuan</strong></td>
	  <td><b>:</b></td>
	  <td><b>
	    <select name="cmbSatuan">
          <option value="Kosong">....</option>
          <?php
		  include_once "library/inc.pilihan.php";
          foreach ($satuan as $nilai) {
            if ($dataSatuan == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
	  </b></td>
    </tr>
	<tr>
      <td><b>Supplier</b></td>
	  <td><b>:</b></td>
	  <td><b>
        <select name="cmbSupplier">
          <option value="Kosong">....</option>
          <?php
	  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
	  	if ($dataSupplier == $bacaData['kd_supplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$bacaData[kd_supplier]' $cek> $bacaData[nm_supplier]</option>";
	  }
	  ?>
        </select>
      </b></td>
    </tr>
	<tr>
      <td><b>Merek</b></td>
	  <td><b>:</b></td>
	  <td><b>
        <select name="cmbMerek">
          <option value="Kosong">....</option>
          <?php
	  $bacaSql = "SELECT * FROM merek ORDER BY kd_merek";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
	  	if ($dataMerek == $bacaData['kd_merek']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$bacaData[kd_merek]' $cek> $bacaData[nm_merek]</option>";
	  }
	  ?>
        </select>
      </b></td>
    </tr>
	<tr>
      <td><strong>Kategori / Jenis</strong></td>
	  <td><strong>:</strong></td>
	  <td><select name="cmbKategori" onchange="javascript:submitform();" >
          <option value="Kosong">....</option>
          <?php
		$bacaSql = "SELECT * FROM kategori ORDER BY nm_kategori";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_kategori']== $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori] </option>";
		}
		?>
      </select>
	    /
        <select name="cmbJenis">
          <option value="Kosong">....</option>
          <?php
	  $bacaSql = "SELECT * FROM jenis WHERE kd_kategori='$dataKategori' ORDER BY kd_jenis";
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
	  <td><strong>Lokasi Stok </strong></td>
	  <td><b>:</b></td>
	  <td><b>
	    <select name="cmbLokasiStok">
          <?php
		  $pilihan	= array("Toko", "Gudang");
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
	  <td><strong>Lokasi Rak </strong></td>
	  <td><b>:</b></td>
	  <td><input name="txtLokasiRak" value="<?php echo $dataLokasiRak; ?>" size="20" maxlength="40"/></td>
    </tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>HARGA</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
      <td><b>Harga Modal/Beli (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaModal" value="<?php echo $dataHargaModal; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Modal 1 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaModal_1" value="<?php echo $dataHargaModal_1; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Modal 2 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaModal_2" value="<?php echo $dataHargaModal_2; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Modal 3 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaModal_3" value="<?php echo $dataHargaModal_3; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Modal 4 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaModal_4" value="<?php echo $dataHargaModal_4; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Jual Level 1 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaJual_1" value="<?php echo $dataHargaJual_1; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Jual Level 2 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaJual_2" value="<?php echo $dataHargaJual_2; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Jual Level 3 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaJual_3" value="<?php echo $dataHargaJual_3; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
      <td><b>Harga Jual Level 4 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaJual_4" value="<?php echo $dataHargaJual_4; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>KONTROL STOK </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Stok Opname </strong></td>
	  <td><b>:</b></td>
	  <td><input name="txtStokOpname" id="txtStokOpname" 
				onfocus="if (value == '0') {value =''}" 
	  			onblur="if (value == '') {value = '0'}" value="<?php echo $dataStokOpname; ?>" size="10" maxlength="10"/></td>
    </tr>
	<tr>
	  <td><strong>Stok Minimal</strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtStokMinimal" id="txtStokMinimal" 
				onfocus="if (value == '0') {value =''}" 
	  			onblur="if (value == '') {value = '0'}" value="<?php echo $dataStokMinimal; ?>" size="10" maxlength="10"/></td>
    </tr>
	<tr>
	  <td><b>Stok Maksimal </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtStokMaksimal" id="txtStokMaksimal" 
				onfocus="if (value == '0') {value =''}" 
	  			onblur="if (value == '') {value = '0'}" value="<?php echo $dataStokMaksimal; ?>" size="10" maxlength="10"/></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
<strong># Note:</strong> Stok akan bertambah jika sudah ada Order dari Form <a href="pembelian/" target="_blank">Pembelian (Penerimaan Barang Masuk)</a>
</form>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
