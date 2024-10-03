<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_bayar_penjualan'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeKasir	= $_SESSION['SES_LOGIN'];

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if(isset($_POST['btnBayar'])){
	// Membaca form data
	$txtNoPenjualan= $_POST['txtNoPenjualan'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtUangBayar	= $_POST['txtUangBayar'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtHutang		= $_POST['txtHutang'];
	
	// Validasi
	$pesanError = array();
	if (trim($txtNoPenjualan)=="") {
		$pesanError[] = "Data <b>Kode Penjualan</b> tidak terbaca, buka lagi dari halaman utama Penjualan !";		
	}
	if(trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b> Tgl. Pembayaran</b> tidak boleh kosong, pilih pada Kalender !";		
	}
	if (trim($txtUangBayar)=="" or ! is_numeric(trim($txtUangBayar))) {
		$pesanError[] = "Data <b>Uang Bayar (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	else {
		if (trim($txtUangBayar) > trim($txtHutang)) {
			$pesanError[] = "Data <b>Uang Bayar (Rp) Berlebih</b>, harus sama dengan <b>Total Belanja (Rp)</b> !";		
		}		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> masih kosong, silahkan dilengkapi informasinya !";		
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
		# SIMPAN DATA KE PEMBAYARAN
		$noTransaksi = buatKode("pembayaran_jual", "PJ");
		$mySql	= "INSERT INTO pembayaran_jual (no_pembayaran_jual, tgl_pembayaran_jual, no_penjualan, total_bayar, keterangan, kd_user)
					VALUES ('$noTransaksi', '$txtTanggal', '$txtNoPenjualan', '$txtUangBayar', '$txtKeterangan', '$kodeKasir')";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query simpan data ".mysql_error());	
			
		if($myQry) {
			if(trim($txtUangBayar)== trim($txtHutang)) {
				// Skrip update status
				$mySql = "UPDATE penjualan SET status_bayar='Lunas' WHERE no_penjualan='$txtNoPenjualan'";
				mysql_query($mySql, $koneksidb) or die ("Eror update status".mysql_error());
			}
		}
		
		echo "DATA TRANSAKSI PEMBAYARAN BERHASIL DISIMPAN";
				
	// Refresh halaman
	echo "<meta http-equiv='refresh' content='0; url=?open=Penjualan-Tampil'>";
	}
}

# ====================================================
if(isset($_GET['Kode'])) {
	# Baca variabel URL
	$Kode = $_GET['Kode'];
	
	# Perintah untuk mendapatkan data dari tabel penjualan
	$mySql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan 
				LEFT JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan 
				LEFT JOIN user ON penjualan.kd_user=user.kd_user 
				WHERE penjualan.no_penjualan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
	
	// Jika status bayarnya sudah Lunas
	if($myData['status_bayar']=="Lunas") {
		// Refresh
		echo "<b>SUDAH DILAKUKAN PEMBAYARAN </b>";
		echo "<meta http-equiv='refresh' content='2; url=?open=Penjualan-Tampil'>";
		exit;
	}
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	$Kode	= "";
	exit;
}

# MENGHITUNG RINCIAN HUTANG
$subSotal	= 0;
$totalHarga	= 0;

$notaSql = "SELECT * FROM penjualan_item WHERE no_penjualan='$Kode'";
$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
while($notaData = mysql_fetch_array($notaQry)) {
	$subSotal 	= $notaData['jumlah'] * $notaData['harga_jual'];
	$totalHarga	= $totalHarga + $subSotal;
}

# MENGHITUNG TOTAL PEMBAYARAN
$totalTerbayar	= 0;
$bayarSql = "SELECT * FROM pembayaran_jual WHERE no_penjualan='$Kode'";
$bayarQry = mysql_query($bayarSql, $koneksidb)  or die ("Query pembayaran salah : ".mysql_error());
while($bayarData = mysql_fetch_array($bayarQry)) {
	$totalTerbayar	= $totalTerbayar + $bayarData['total_bayar'];
}

// Menghitung Hutang
$totalHutang	= $totalHarga - ( $myData['uang_bayar'] + $totalTerbayar );

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("pembayaran_jual", "PJ");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="frmadd">
<table width="900" border="0" cellspacing="1" cellpadding="4" class="table-list">
  <tr>
    <td colspan="3"><h2>PEMBAYARAN</h2></td>
    </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>PENJUALAN</strong></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="204"><b>No. Penjualan </b></td>
    <td width="10"><b>:</b></td>
    <td width="658" valign="top"><strong><?php echo $myData['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Penjualan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Operator</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_user']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>HUTANG</strong></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total Belanja (Rp) </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo format_angka($totalHarga); ?></td>
  </tr>
  <tr>
    <td><strong>Uang Muka (Rp)</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo format_angka($myData['uang_bayar']); ?></td>
  </tr>
  <tr>
    <td><strong>Total Pembayaran (Rp)</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo format_angka($totalTerbayar); ?></td>
  </tr>
  <tr>
    <td><strong>Total Hutang (Rp) </strong></td>
    <td><b>:</b></td>
    <td valign="top"><strong><?php echo format_angka($totalHutang); ?>
      <input name="txtHutang" type="hidden"  value="<?php echo $totalHutang; ?>" />
    </strong></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>PEMBAYARAN</strong></td>
    <td>&nbsp;</td>
    <td valign="top"> <input name="txtNoPenjualan" type="hidden"  value="<?php echo $Kode; ?>" /> </td>
  </tr>
  <tr>
    <td><strong>No. Pembayaran </strong></td>
    <td><b>:</b></td>
    <td valign="top"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="20" maxlength="20" readonly="readonly"/></td>
  </tr>
  <tr>
    <td><strong>Tgl. Pembayaran </strong></td>
    <td><b>:</b></td>
    <td valign="top"><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="20" /></td>
  </tr>
  <tr>
    <td><strong>Total Bayar (Rp) </strong></td>
    <td><b>:</b></td>
    <td valign="top"><input name="txtUangBayar" id="txtUangBayar" value="<?php echo $dataUangBayar; ?>" size="20" maxlength="12" /></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><input name="txtKeterangan" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top"><b>
      <input name="btnBayar" type="submit" id="btnBayar" value="Simpan Bayar" />
    </b></td>
  </tr>
</table>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="76" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="466" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="117" align="right" bgcolor="#F5F5F5"><strong>Harga (Rp)</strong> </td>
    <td width="57" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
    <td width="125" align="center" bgcolor="#F5F5F5"><strong>SubTotal(Rp) </strong></td>
  </tr>
  <?php
//  tabel menu 
$my2Sql ="SELECT penjualan_item.*, barang.nm_barang, jenis.nm_jenis FROM penjualan_item 
		 LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
		 LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
		 WHERE penjualan_item.no_penjualan='$Kode' ORDER BY penjualan_item.kd_barang";
$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0; 
while($my2Data = mysql_fetch_array($my2Qry)) {
	$qtyItem		= $qtyItem + $my2Data['jumlah'];
	$subTotal		= $my2Data['harga_jual'] * $my2Data['jumlah']; // harga beli dari tabel penjualan_item (harga terbaru dari pelanggan)
	$totalBelanja	= $totalBelanja + $subTotal;
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $my2Data['kd_barang']; ?></td>
    <td><?php echo $my2Data['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['harga_jual']); ?></td>
    <td align="right"><?php echo $my2Data['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="4" align="right"><b> GRAND TOTAL  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo $qtyItem; ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong>
      <input name="txtTotalBayar" type="hidden" id="txtTotalBayar" value="<?php echo $totalBelanja; ?>" />
    Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
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
