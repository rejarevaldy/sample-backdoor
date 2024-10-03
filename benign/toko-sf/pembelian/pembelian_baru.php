<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_pembelian'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR barang DI TMP
if(isset($_GET['Aksi'])){
	$Aksi	= $_GET['Aksi'];
	$id		= $_GET['id'];
	
	if(trim($Aksi)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql	= "DELETE FROM tmp_pembelian WHERE id='$id' AND kd_user='$kodeUser'";
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
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtJual		= $_POST['cmbLevel'];
	$txtBarcode		= $_POST['txtBarcode'];
	$txtPPN			= $_POST['txtPPN'];
	$txtHarga		= $_POST['txtHarga'];
	$txtJumlah		= $_POST['txtJumlah'];



	// $dataLevel	= "";

	// $dataLevel			= isset($_GET['Level']) ? $_GET['Level'] : $dataLevel;
	// $dataLevel			= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $dataLevel;

	// // Level harga
	// if($dataLevel=="1") {
	// 	$dataJual		= 'Modal 1';
	// }
	// elseif($dataLevel=="2") {
	// 	$dataJual		= 'Modal 2';
	// }
	// elseif($dataLevel=="3") {
	// 	$dataJual		= 'Modal 3';
	// }
	// elseif($dataLevel=="4") {
	// 	$dataJual		= 'Modal 4';
	// }
	// else {
	// 	$dataJual		= 'Modal 0';
	// }
			
	# Validasi Kotak isi Form
	$pesanError = array();
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";		
	}
	if (trim($txtBarcode)=="") {
		$pesanError[] = "Data <b>Kode Barcode/ PLU belum diisi</b>, ketik Kode dari Keyboard atau dari <b>Tools Barcode Reader</b> !";		
	}
	else {
		// Validasi Kode Barcode/PLU apakah ada dalam database
		$cekSql	= "SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
		if(mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Data <b>Kode Barcode/PLU Tidak Dikenali</b>, data sudah ada dalam database !";
		}
	}
	if (trim($txtHarga)=="" or ! is_numeric(trim($txtHarga))) {
		$pesanError[] = "Data <b>Harga Pembelian (Rp) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
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
		# AREA SKRIP SIMPAN KE DATABASE (tmp_pembelian)	

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
			$cekSql ="SELECT * FROM tmp_pembelian WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_pembelian SET jumlah = jumlah + $txtJumlah WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql 	= "INSERT INTO tmp_pembelian (kd_supplier, kd_barang,  ppn, harga, jual, jumlah,  kd_user) 
				VALUES ('$cmbSupplier', '$kodeBarang',  '$txtPPN', '$txtHarga', '$txtJual', '$txtJumlah',  '$kodeUser')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			}
		}
	}
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca variabel data from
	$txtTanggal 	= $_POST['txtTanggal'];
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	
	# Validasi Kotak isi Form
	$pesanError = array();
	if (trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_pembelian WHERE kd_user='$kodeUser'";
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
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel pembelian dan pembelian_item
		$noTransaksi = buatKode("pembelian", "BL");
		$mySql	= "INSERT INTO pembelian SET 
						no_pembelian='$noTransaksi', 
						tgl_pembelian='".InggrisTgl($txtTanggal)."', 
						kd_supplier='$cmbSupplier', 
						keterangan='$txtKeterangan', 
						kd_user='$kodeUser'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# �LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT * FROM  tmp_pembelian WHERE kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_barang'];
			$dataHarga	= $tmpData['harga'];
			$dataJual	= $tmpData['jual'];
			$dataJumlah	= $tmpData['jumlah'];
			$ppn		= $tmpData['ppn'];

			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO pembelian_item SET 
									no_pembelian='$noTransaksi', 
									kd_barang='$dataKode', 
									ppn='$ppn',
									harga_beli='$dataHarga', 
									jual='$dataJual', 
									jumlah='$dataJumlah'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok + $dataJumlah WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			
			// Skrip Update Harga Kulak (Modal)
			$stokSql = "UPDATE barang SET harga_modal =$dataHarga WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Harga Modal".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_pembelian WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?open=Pembelian-Baru'>";
	}	
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("pembelian", "BL");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataPPN	 	= isset($_POST['txtPPN']) ? $_POST['txtPPN'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';

$dataBarcode	= "";
$dataNamaBrg	= "";
$dataHarga	= "";
$dataJual	= "";



$dataLevel	= "";

$dataLevel			= isset($_GET['Level']) ? $_GET['Level'] : $dataLevel;
$dataLevel			= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $dataLevel;

# SAAT KOTAK KODE BUKU DIINPUT DATA, MAKA OTOMATIS FORM TERISI
if(isset($_POST['txtBarcode'])) {
	// Membaca data barang
	$txtBarcode	= $_POST['txtBarcode'];
	$my2Sql = "SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query auto 2".mysql_error());
	if(mysql_num_rows($my2Qry) >=1) {
		$my2Data= mysql_fetch_array($my2Qry);
		$dataBarcode	= $my2Data['barcode'];
		$dataNamaBrg	= $my2Data['nm_barang'];
		$dataHarga		= $my2Data['harga_modal'];

		// Level harga
		if($dataLevel=="1") {
			$dataHarga		= $my2Data['harga_modal_1'];
			$dataJual		= 'Modal 1';
		}
		elseif($dataLevel=="2") {
			$dataHarga		= $my2Data['harga_modal_2'];
			$dataJual		= 'Modal 2';
		}
		elseif($dataLevel=="3") {
			$dataHarga		= $my2Data['harga_modal_3'];
			$dataJual		= 'Modal 3';
		}
		elseif($dataLevel=="4") {
			$dataHarga		= $my2Data['harga_modal_4'];
			$dataJual		= 'Modal 4';
		}
		else {
			$dataHarga		= 0;
			$dataJual		= 'Modal 0';
		}
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataBarcode	= "";
		$dataNamaBrg	= "";
		$dataHarga	= "";
	}
}

// Jika sudah Klik Tambah, form Input Barang dikosongkan lagi
if(isset($_POST['btnTambah'])){
	// mengosongkan
	$dataBarcode	= "";
	$dataNamaBrg	= "";
	$dataHarga	= "";
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
      <td colspan="3"><h1>PEMBELIAN BARANG</h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA TRANSAKSI </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="21%"><strong>No. Pembelian </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="78%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="20" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl. Pembelian </strong></td>
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
      </select></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INPUT  BARANG </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td><strong>Level Modal </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbLevel"  onchange="javascript:submitform();">
          <option value="Kosong">....</option>
          <?php
		$pilihan	= array(1 => "Modal 1", 2 => "Modal 2", 3 => "Modal 3", 4 => "Modal 4");
          foreach ($pilihan as $nilai => $judul) {
            if ($dataLevel == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek> $judul</option>";
          }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Barcode / PLU </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtBarcode" id="txtBarcode" size="30" maxlength="20" value="<?php echo $dataBarcode; ?>" onchange="javascript:submitform();">
	  <a href="javaScript: void(0)" onclick="popup('pencarian_barang.php')" target="_self"> <b>Cari Barang</b> </a></td>
    </tr>
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNamaBrg; ?>" size="80" maxlength="200" readonly="readonly" /></td>
    </tr>
	<td><b>PPN/PPH (%) </b></td>
      <td><b>:</b></td>
      <td><b>
	  <input name="txtPPN" value="0" size="20" maxlength="20" 
	  onblur="if (value == '') {value = '0'}" 
				 onfocus="if (value == '0') {value =''}"/>
	  </b></td>
    <tr>
      <td><b>Harga Beli/ Modal (Rp) </b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="txtHarga" id="txtHarga" size="20" maxlength="12" value="<?php echo $dataHarga; ?>"/>
		
        Jumlah : 
        <input class="angkaC" name="txtJumlah" size="4" maxlength="4" value="10" 
				 onblur="if (value == '') {value = '10'}" 
				 onfocus="if (value == '10') {value =''}"/>
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
      <th colspan="9">DAFTAR BARANG </th>
    </tr>
    <tr>
      <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="70" bgcolor="#CCCCCC"><strong>Kode</strong></td>
      <td width="475" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
      <td width="475" bgcolor="#CCCCCC"><strong>Level Modal </strong></td>
      <td width="100" align="right" bgcolor="#CCCCCC"><strong>PPN (Rp) </strong></td>
      <td width="100" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
      <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
      <td width="110" align="right" bgcolor="#CCCCCC"><strong>Sub Total(Rp) </strong></td>
      <td width="39" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
// deklarasi variabel
$hargaDiskon= 0; 
$totalBayar	= 0; 
$jumlahbarang	= 0;

// Qury menampilkan data dalam Grid TMP_Pembelian 
$tmpSql ="SELECT barang.*, tmp.* FROM barang, tmp_pembelian As tmp
		WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='$kodeUser'
		ORDER BY barang.kd_barang ";

// $tmpSql ="SELECT barang.nm_barang, tmp.* 
// 		FROM barang, tmp_pembelian As tmp
// 		WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='$kodeUser
// 		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id			= $tmpData['id'];
	// $subSotal 	= $tmpData['jumlah'] * $tmpData['harga'];
	// $totalBayar	= $totalBayar + $subSotal;
	// $jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];

	$jumlahbarang		= $jumlahbarang + $tmpData['jumlah'];
	$ppn 			= $tmpData['harga'] * ($tmpData['ppn'] / 100);
	$subSotal 		= $tmpData['jumlah'] * ($tmpData['harga'] + $ppn);
	$totalBayar		= $totalBayar + $subSotal;
?>
    <tr>
		<?php echo $tmpData['harga']?>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td>Modal <?php echo $tmpData['jual'] ?></td>
      <td align="right"><?php echo format_angka($ppn * $tmpData['jumlah']); ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?Aksi=Delete&id=<?php echo $id; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="6" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL BELANJA  (Rp.) : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo $jumlahbarang; ?></b></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
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
