<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_penjualan'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR barang DI TMP
if(isset($_GET['Aksi'])){
	$Aksi	= $_GET['Aksi'];
	$id		= $_GET['id'];
	
	if(trim($Aksi)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql  = "DELETE FROM tmp_penjualan WHERE id='$id' AND kd_user='$kodeUser'";
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
	$txtKodePlg		= $_POST['txtKodePlg'];
	$txtBarcode		= $_POST['txtBarcode'];
	$txtPPN			= $_POST['txtPPN'];
	$txtHarga		= $_POST['txtHarga'];
	$txtJumlah		= $_POST['txtJumlah'];

	# Validasi Form
	$pesanError = array();
	if (trim($txtKodePlg)=="") {
		$pesanError[] = "Data <b>Pelanggan</b> belum dipilih, pilih pada combo !";		
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
		else {
			# Cek Stok, jika stok Opname (stok bisa dijual) < kurang dari Jumlah yang dibeli, maka buat Pesan Error
			$cekRow = mysql_fetch_array($cekQry);
			if ($cekRow['stok'] < $txtJumlah) {
				$pesanError[] = "Stok Barang dengan Kode <b>$txtBarcode</b> adalah <b> $cekRow[stok]</b>, Stok tidak mencukupi!";
			}
		}
	}
	if (trim($txtHarga)=="" or ! is_numeric(trim($txtHarga))) {
		$pesanError[] = "Data <b>Harga (Rp)</b>  belum diisi, silahkan <b>isi dengan angka</b> !";		
	}
	else {
		if (trim($txtHarga) <= 100 ) {
			$pesanError[] = "Data <b>Harga (Rp)</b> belum diisi dengan benar, silahkan diperbaiki !";		
		}	
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah Barang (Qty)</b> belum diisi, silahkan <b>isi dengan angka</b> !";		
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
		# SIMPAN KE DATABASE (tmp_penjualan)	

		// Informasi Pelanggan
		$infoSql	= "SELECT * FROM pelanggan WHERE kd_pelanggan='$txtKodePlg'";
		$infoQry 	= mysql_query($infoSql, $koneksidb)  or die ("Query info salah : ".mysql_error());
		$infoData = mysql_fetch_array($infoQry);
		$infoLevel= $infoData['level_harga'];

		# Kode barang Baru, membuka tabel barang
		# Cek data di dalam tabel barang, mungkin yang diinput dari form adalah Barcode dan mungkin Kode-nya
		$mySql ="SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query cek barang".mysql_error());
		$myData= mysql_fetch_array($myQry);
		$myQty = mysql_num_rows($myQry);
		if($myQty >= 1) {
			// Membaca kode barang/ barang
			$kodeBarang		= $myData['kd_barang'];
			$kodeBarcode	= $myData['barcode'];

			// Level Harga
			if($infoLevel == 1) {
				$hargaJual	= $myData['harga_jual_1'];
			}
			elseif($infoLevel == 2) {
				$hargaJual	= $myData['harga_jual_2'];
			}
			elseif($infoLevel == 3) {
				$hargaJual	= $myData['harga_jual_3'];
			}
			elseif($infoLevel == 4) {
				$hargaJual	= $myData['harga_jual_4'];
			}
			else {
				$hargaJual	= $myData['harga_jual_4'];
			}

			# Jika sudah pernah dipilih, cukup datanya di update jumlahnya			
			$cekSql ="SELECT * FROM tmp_penjualan WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser' AND kd_pelanggan='$txtKodePlg'"; 
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_penjualan SET jumlah = jumlah + $txtJumlah WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql 	= "INSERT INTO tmp_penjualan (kd_pelanggan, kd_barang, ppn, harga, jumlah,  kd_user) 
								VALUES ('$txtKodePlg', '$kodeBarang', $txtPPN, '$hargaJual', '$txtJumlah',  '$kodeUser')";
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
	$txtTglTransaksi= InggrisTgl($_POST['txtTglTransaksi']);
	$txtTglTempo 	= InggrisTgl($_POST['txtTglTempo']);
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKodePlg	= $_POST['txtKodePlg'];
	$cmbCaraBayar	= $_POST['cmbCaraBayar'];
	$txtUangBayar	= $_POST['txtUangBayar'];
	$txtTotBayar	= $_POST['txtTotBayar'];
			
	# Validasi Form
	$pesanError = array();
	if(trim($txtTglTransaksi)=="--") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if(trim($txtKodePlg)=="Kosong") {
		$pesanError[] = "Data <b>Nama Pelanggan</b> belum dipilih, silahkan dilengkapi !";		
	}
	if(trim($cmbCaraBayar)=="Kosong") {
		$pesanError[] = "Data <b>Cara Bayar (Tunai/Kredit)</b> belum dipilih, silahkan dilengkapi !";		
	}
	if(trim($cmbCaraBayar)=="Kredit") {
		if(trim($txtTglTempo)=="--") {
			$pesanError[] = "Data <b>Tgl. Jatuh Tempo Kredit</b> belum diisi, pilih pada kalender !";		
		}
	}
	if(trim($cmbCaraBayar)=="Tunai") {
		// Jika bayarnya Tunai, maka uang bayar harus diisi
		if(trim($txtUangBayar)==""  or ! is_numeric(trim($txtUangBayar))) {
			$pesanError[] = "Data <b>Uang Bayar</b> belum diisi, harus berupa angka !";		
		}
		// Jika bayarnya Tunai, maka besar uang harus Lebih atau Sama dengan besar Tagihan / Total Belanja
		if(trim($txtUangBayar) < trim($txtTotBayar)) {
			$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
							 Total belanja adalah <b> Rp. ".format_angka($txtTotBayar)."</b>";		
		}
	}
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql = "SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_user='$kodeUser'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData= mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, belum ada barang yang dimasukan, <b>minimal 1 barang</b>.";
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
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
		if($cmbCaraBayar =="Tunai") {
			$statusBayar	= "Lunas";
		}
		else {
			$statusBayar	= "Hutang";
		}
		
		$noTransaksi = buatKode("penjualan", "JL");
		$mySql	= "INSERT INTO penjualan (no_penjualan, tgl_penjualan, keterangan, kd_pelanggan, 
								cara_bayar, status_bayar, tgl_jatuh_tempo, uang_bayar, kd_user) 
						VALUES ('$noTransaksi', '$txtTglTransaksi', '$txtKeterangan', '$txtKodePlg', 
								'$cmbCaraBayar', '$statusBayar', '$txtTglTempo', '$txtUangBayar', '$kodeUser')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query 1".mysql_error());
		
		# �LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT barang.harga_modal, tmp.* 
					FROM barang, tmp_penjualan As tmp
					WHERE barang.kd_barang = tmp.kd_barang AND tmp.kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 		= $tmpData['kd_barang'];
			$dataHrgModal	= $tmpData['harga_modal'];
			$dataHrgJual	= $tmpData['harga'];
			$dataJumlah		= $tmpData['jumlah'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO penjualan_item (no_penjualan, kd_barang, harga_modal, harga_jual, jumlah) 
						VALUES ('$noTransaksi', '$dataKode', '$dataHrgModal', '$dataHrgJual', '$dataJumlah') ";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query 2".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok - $dataJumlah WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		//echo "<meta http-equiv='refresh' content='0; url=penjualan_nota.php?noNota=$noTransaksi'>";
		echo "<script>";
		echo "window.open('penjualan_nota.php?noNota=$noTransaksi', width=330,height=330,left=100, top=25)";
		echo "</script>";

	}	
}

// Membaca Kode Pelanggan dari URL, didapat saat menu Delete dipilih dari Daftar Barang
$kodePelanggan= isset($_GET['kodePelanggan']) ? $_GET['kodePelanggan'] : '';

# TAMPILKAN DATA KE FORM
$noTransaksi 		= buatKode("penjualan", "JL");
$dataTglTransaksi 	= isset($_POST['txtTglTransaksi']) ? $_POST['txtTglTransaksi'] : date('d-m-Y');
$dataPPN	 		= isset($_POST['txtPPN']) ? $_POST['txtPPN'] : '';
$dataTglTempo	 	= isset($_POST['txtTglTempo']) ? $_POST['txtTglTempo'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataPelanggan		= isset($_POST['txtKodePlg']) ? $_POST['txtKodePlg'] : $kodePelanggan;
$dataCaraBayar		= isset($_POST['cmbCaraBayar']) ? $_POST['cmbCaraBayar'] : '';
$dataUangBayar		= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
$dataKategori		= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';

$dataLevel			= isset($_GET['Level']) ? $_GET['Level'] : '4';
$dataLevel			= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $dataLevel;

$dataBarcode	= "";
$dataNamaBrg	= "";
$dataHarga		= "";

$dataKodePlg	= "";
$dataNamaPlg	= "";

# SAAT KOTAK KODE BUKU DIINPUT DATA, MAKA OTOMATIS FORM TERISI
if(isset($_POST['txtBarcode'])) {
	// Membaca data Pelanggan, data Level Diskon
	//$mySql ="SELECT level_harga FROM pelanggan WHERE kd_pelanggan='$dataPelanggan'";
	//$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query auto 1".mysql_error());
	//$myData= mysql_fetch_array($myQry);
	
	// Membaca data barang
	$txtBarcode	= $_POST['txtBarcode'];
	$my2Sql ="SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query auto 2".mysql_error());
	if(mysql_num_rows($my2Qry) >=1) {
		$my2Data= mysql_fetch_array($my2Qry);
		$dataBarcode	= $my2Data['barcode'];
		$dataNamaBrg	= $my2Data['nm_barang'];
		
		// Level harga
		if($dataLevel=="1") {
			$dataHarga		= $my2Data['harga_jual_1'];
		}
		elseif($dataLevel=="2") {
			$dataHarga		= $my2Data['harga_jual_2'];
		}
		elseif($dataLevel=="3") {
			$dataHarga		= $my2Data['harga_jual_3'];
		}
		elseif($dataLevel=="4") {
			$dataHarga		= $my2Data['harga_jual_4'];
		}
		else {
			$dataHarga		= 0;
		}
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataBarcode	= "";
		$dataNamaBrg	= "";
		$dataHarga		= "";
	}
}

# ========================
# SAAT KOTAK KODE BUKU DIINPUT DATA, MAKA OTOMATIS FORM TERISI
if(isset($_POST['txtKodePlg'])) {
	// Membaca data barang
	$txtKodePlg	= $_POST['txtKodePlg'];
	$mySql ="SELECT * FROM pelanggan WHERE kd_pelanggan ='$txtKodePlg'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query cari pelanggan".mysql_error());
	if(mysql_num_rows($myQry) >=1) {
		$myData= mysql_fetch_array($myQry);
		$dataKodePlg	= $myData['kd_pelanggan'];
		$dataNamaPlg	= $myData['nm_pelanggan'];
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataKodePlg	= "";
		$dataNamaPlg	= "";
	}
}

# =====================
// Jika sudah Klik Tambah, form Input Barang dikosongkan lagi
if(isset($_POST['btnTambah'])){
	// mengosongkan
	$dataBarcode	= "";
	$dataNamaBrg	= "";
	$dataHarga		= "";
	
	$dataKodePlg	= "";
	$dataNamaPlg	= "";
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
      <td colspan="3"><h1>PENJUALAN BARANG</h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA TRANSAKSI </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="21%"><strong>No. Penjualan </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="78%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="20" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl. Penjualan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTglTransaksi" type="text" class="tcal" value="<?php echo $dataTglTransaksi; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Pelanggan</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKodePlg" id="idKodePlg" size="20" maxlength="5" value="<?php echo $dataKodePlg; ?>" 
	  		onchange="javascript:submitform();" onmouseout="javascript:submitform();"/> <input type="submit" name="Submit" value="Klik" />
      <a href="javaScript: void(0)" onclick="popup('pencarian_pelanggan.php')" target="_self"><b>
      
      Cari Pelanggan </b></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="txtNamaPlg" id="idNamaPlg" type="text" value="<?php echo $dataNamaPlg; ?>" size="80" maxlength="200" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><b>Cara Bayar </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbCaraBayar">
          <?php
		  $pilihan	= array("Tunai", "Kredit");
          foreach ($pilihan as $nilai) {
            if ($dataCaraBayar ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Tgl. Jatuh Tempo Kredit </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTglTempo" type="text" class="tcal" value="<?php echo $dataTglTempo; ?>" size="20" maxlength="20" /></td>
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
      <td><strong>Level Harga </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbLevel"  onchange="javascript:submitform();">
        <option value="Kosong">....</option>
        <?php
		$pilihan	= array(1 => "Level 1 - Grosir", 2 => "Level 2 - Partai 1", 3 => "Level 3 - Partai 2", 4 => "Level 4 - Ritel");
          foreach ($pilihan as $nilai => $judul) {
            if ($dataLevel ==$nilai) {
                $cek="selected";
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
        <a href="javaScript: void(0)" onclick="popup('pencarian_barang.php?kodePelanggan=<?php echo $dataPelanggan; ?>&levelPlg=<?php echo $dataLevel; ?>')" target="_self"> <b>Cari Barang</b> </a></td>
    </tr>
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNamaBrg; ?>" size="80" maxlength="200" readonly="readonly" /></td>
    </tr>
	<tr>
	<td><b>PPN (%) </b></td>
      <td><b>:</b></td>
      <td><b>
	  <input name="txtPPN" value="0" size="20" maxlength="20" 
	  onblur="if (value == '') {value = '0'}" 
				 onfocus="if (value == '0') {value =''}"/>
	  </b></td>
	</tr>
    <tr>
      <td><b>Harga Jual (Rp)</b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="txtHarga" id="txtHarga" size="20" maxlength="12" value="<?php echo $dataHarga; ?>"/>
        Jumlah : 
        <input class="angkaC" name="txtJumlah" size="4" maxlength="4" value="1" 
				 onblur="if (value == '') {value = '1'}" 
				 onfocus="if (value == '1') {value =''}"/>
        <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
  </table>
  <br>
  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="8">DAFTAR BARANG </th>
    </tr>
    <tr>
      <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="65" bgcolor="#CCCCCC"><strong>Kode</strong></td>
      <td width="466" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
	  <td width="61" align="right" bgcolor="#CCCCCC"><strong>PPN (Rp)</strong></td>
      <td width="100" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
      <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
      <td width="120" align="right" bgcolor="#CCCCCC"><strong>Sub Total(Rp) </strong></td>
      <td width="39" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
// deklarasi variabel
$hargaDiskon= 0; 
$totalBayar	= 0; 
$jumlahBrg	= 0;

// Qury menampilkan data dalam Grid TMP_Penjualan 
$tmpSql ="SELECT barang.nm_barang, tmp.* 
		FROM barang, tmp_penjualan As tmp
		WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='$kodeUser' AND tmp.kd_pelanggan ='$dataPelanggan'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id				= $tmpData['id'];
	//$hargaDiskon	= $tmpData['harga'] - ( $tmpData['harga'] * $tmpData['diskon']/100);
	// $subSotal 		= $tmpData['jumlah'] * $tmpData['harga'];
	// $totalBayar		= $totalBayar + $subSotal;
	$ppn 			= $tmpData['harga'] * ($tmpData['ppn'] / 100);
	$subSotal 	= $tmpData['jumlah'] * $tmpData['harga'] + $ppn;
	$totalBayar	= $totalBayar + $subSotal + $ppn;
	$jumlahBrg		= $jumlahBrg + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td align="right"><?php echo format_angka($ppn * $tmpData['jumlah']); ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?open=Penjualan-Baru-2&Aksi=Delete&id=<?php echo $id; ?>&kodePelanggan=<?php echo $dataPelanggan; ?>&Level=<?php echo $dataLevel; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL BELANJA  (Rp.) : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo $jumlahBrg; ?></b></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>UANG BAYAR (Rp.) : </strong></td>
      <td bgcolor="#F5F5F5"><input name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" /></td>
      <td bgcolor="#F5F5F5"><input name="txtUangBayar" value="<?php echo $dataUangBayar; ?>" size="16" maxlength="12"/></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
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
