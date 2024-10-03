<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_returbeli'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR barang DI TMP
if(isset($_GET['Aksi'])){
	$Aksi	= $_GET['Aksi'];
	$id		= $_GET['id'];
	
	if(trim($Aksi)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql  = "DELETE FROM tmp_returbeli WHERE id='$id' AND kd_user='$kodeUser'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(trim($Aksi)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================


# TOMBOL TAMBAH (KODE barang) DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca Data dari Form
	$cmbSupplier		= $_POST['cmbSupplier'];
	$txtBarcode			= $_POST['txtBarcode'];
	$txtKeteranganBrg	= $_POST['txtKeteranganBrg'];
	$txtKeteranganBrg	= str_replace("'","&acute;", $txtKeteranganBrg);
	$txtJumlah			= $_POST['txtJumlah'];
	
	# Validasi Form	
	$pesanError = array();
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";		
	}
	if (trim($txtBarcode)=="") {
		$pesanError[] = "Data <b>Kode Barcode/ PLU</b> belum diisi, ketik Kode dari Keyboard atau dari <b>Tools Barcode Reader</b> !";		
	}
	else {
		// Validasi Kode Barcode/PLU apakah ada dalam database
		$cekSql	= "SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
		if(mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Data <b>Kode Barcode/PLU</b> Tidak Dikenali, data sudah ada dalam database !";
		}
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah Barang (Qty)</b> belum diisi, silahkan <b>isi dengan angka</b> !";		
	}
	if (trim($txtKeteranganBrg)=="") {
		$pesanError[] = "Data <b>Keterangan Barang</b> belum diisi, silahkan dilengkapi !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN KE DATABASE (tmp_returbeli)	

		# Kode barang Baru, membuka tabel barang
		# Cek data di dalam tabel barang, mungkin yang diinput dari form adalah Barcode dan mungkin Kode-nya
		$mySql ="SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query cek barang".mysql_error());
		$myData = mysql_fetch_array($myQry);
		$myQty = mysql_num_rows($myQry);
		if($myQty >= 1) {
			// Membaca kode barang/ barang
			$kodeBarang		= $myData['kd_barang'];
			$kodeBarcode	= $myData['barcode'];

			# Jika sudah pernah dipilih, cukup datanya di update jumlahnya			
			$cekSql ="SELECT * FROM tmp_returbeli WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_returbeli SET jumlah = jumlah + $txtJumlah WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql 	= "INSERT INTO tmp_returbeli (kd_supplier, kd_barang,jumlah,  keterangan, kd_user) 
					VALUES ('$cmbSupplier', '$kodeBarang', '$txtJumlah', '$txtKeteranganBrg',  '$kodeUser')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			}
		}
	}

}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel from
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];
			
	# Validasi Form
	$pesanError = array();
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";		
	}
	if (trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if (trim($cmbSupplier)=="") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_returbeli WHERE kd_user='$kodeUser'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, belum ada barang yang dimasukan, <b>minimal 1 barang/Barang</b>.";
	}
	
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel returbeli dan returbeli_item
		$noTransaksi = buatKode("returbeli", "RB");
		$mySql	= "INSERT INTO returbeli (no_returbeli, tgl_returbeli, kd_supplier, keterangan, kd_user) 
						VALUES ('$noTransaksi', '$txtTanggal', '$cmbSupplier', '$txtKeterangan', '$kodeUser')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# �LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT * FROM tmp_returbeli WHERE kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_barang'];
			$dataJumlah	= $tmpData['jumlah'];
			$dataKeterangan	= $tmpData['keterangan'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO returbeli_item SET 
									no_returbeli='$noTransaksi', 
									kd_barang='$dataKode', 
									jumlah='$dataJumlah', 
									keterangan='$dataKeterangan'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok - $dataJumlah WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_returbeli WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?open=Returbeli-Baru'>";
	}	
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("returbeli", "RB");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';

# SAAT KOTAK KODE BARANG DIINPUT DATA, MAKA OTOMATIS FORM TERISI
// Input data dapat dilakukan dengan cara mengetik dari Keyboard, atau juga dari Barcode Reader
if(isset($_POST['txtBarcode'])) {
	$txtBarcode	= $_POST['txtBarcode'];
	
	// Membaca data barang lewat Barcode yang didapat dari form
	$mySql ="SELECT * FROM barang WHERE kd_barang ='$txtBarcode' OR barcode ='$txtBarcode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($myQry) >=1) {
		$myData= mysql_fetch_array($myQry);
		$dataBarcode	= $myData['barcode'];
		$dataNamaBrg	= $myData['nm_barang'];
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataBarcode	= "";
		$dataNamaBrg	= "";
	}
}
else {
	$dataBarcode	= "";
	$dataNamaBrg	= "";
}
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" cellpadding="3" cellspacing="1"  class="table-list">
    <tr>
      <td colspan="3"><h1>RETUR PEMBELIAN BARANG</h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA TRANSAKSI </strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="21%"><strong>No. Retur </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="78%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl. Retur </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $tglTransaksi; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Supplier</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbSupplier">
        <option value="Kosong">....</option>
        <?php
	  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_supplier'] == $dataSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[nm_supplier]</option>";
	  }
	  ?>
      </select> </td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INPUT  BARANG </strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Barcode / PLU </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtBarcode" id="txtBarcode" size="30" maxlength="20" value="<?php echo $dataBarcode; ?>" onChange="javascript:submitform();"/>
        <a href="javaScript: void(0)" onclick="popup('pencarian_barang.php')" target="_self"> <b>Cari Barang</b> </a></td>
    </tr>
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNamaBrg; ?>" size="80" maxlength="200" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><b>Jumlah, Keterangan </b></td>
      <td><b>:</b></td>
      <td><b>
        <input class="angkaC" name="txtJumlah" size="4" maxlength="4" value="1" 
				 onblur="if (value == '') {value = '1'}" 
				 onfocus="if (value == '1') {value =''}"/>
        <input name="txtKeteranganBrg" size="40" maxlength="100"/>
        <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="6">DAFTAR BARANG </th>
    </tr>
    <tr>
      <td width="26" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="70" bgcolor="#CCCCCC"><strong>Kode</strong></td>
      <td width="448" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
      <td width="236" bgcolor="#CCCCCC"><strong>Keterangan Barang </strong></td>
      <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
      <td width="39" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
// Qury menampilkan data dalam Grid TMP_returbeli 
$tmpSql ="SELECT barang.nm_barang, tmp.* FROM tmp_returbeli As tmp
		LEFT JOIN barang ON tmp.kd_barang = barang.kd_barang
		WHERE tmp.kd_user='$kodeUser' ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  $jumlahbarang = 0;
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id				= $tmpData['id'];
	$jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td><?php echo $tmpData['keterangan']; ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td><a href="?Aksi=Delete&id=<?php echo $id; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>TOTAL BARANG : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo $jumlahbarang; ?></b></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    
    
    <tr>
      <td colspan="5" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
