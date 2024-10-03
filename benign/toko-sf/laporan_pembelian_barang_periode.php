<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_barang_periode'] == "Yes") {

// Baca variabel URL browser
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua'; 
// Baca variabel dari Form setelah di Post
$kodeSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;

// Membuat filter SQL
if ($kodeSupplier=="Semua") {
	//Query #1 (semua data)
	$filterSPL 	= "";
}
else {
	//Query #2 (filter)
	$filterSPL 	= " AND p.kd_supplier ='$kodeSupplier'";
}

# =================================================================

// Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

// Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : $tglAwal;

$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : $tglAkhir;

// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
$filterSQL = $filterSPL."AND ( p.tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pembelian_barang_periode.php?kodeSupplier=$kodeSupplier&tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembelian As p, pembelian_item As pi
			WHERE p.no_pembelian = pi.no_pembelian 
			$filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2>LAPORAN PEMBELIAN BARANG PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td><strong>Supplier</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbSupplier">
          <option value="Semua">....</option>
          <?php
		  // Skrip menampilkan data Supplier ke List/Menu (comboBox)
	  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_supplier'] == $kodeSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[nm_supplier]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td width="142"><strong>Periode Transaksi</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="389"><input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
      <input name="txtTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " />
	  <input name="btnCetak" type="submit"  value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="22" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Tgl. Faktur </strong></td>
    <td width="79" bgcolor="#CCCCCC"><strong>No. Faktur </strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="380" bgcolor="#CCCCCC"><strong>Nama Barang  </strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>PPN/PPH (Rp) </strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>Hrg. Beli (Rp) </strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="110" align="right" bgcolor="#CCCCCC"><strong>Hrg. Total (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalHarga	= 0;
	$totalBarang	= 0;
	
	// Skrip Menampilkan data Pembelian Item Barang dengan Filter Periode Tanggal
	$mySql = "SELECT  p.no_pembelian, p.tgl_pembelian, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.jumlah, pi.ppn,
				(pi.harga_beli * pi.jumlah) As total_harga
				FROM pembelian As p, pembelian_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_pembelian = pi.no_pembelian
				$filterSQL
				ORDER BY no_pembelian ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		
		# Rekap data
    $ppn = $myData['harga_beli'] * $myData['jumlah'] * ($myData['ppn'] / 100);
		$totalHarga	= $totalHarga + $myData['total_harga'] + $ppn;  // Menghitung total modal beli
		$totalBarang= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual

    ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($ppn); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($myData['total_harga'] + $ppn); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalHarga ); ?></strong></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="6" align="right"><strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pembelian-Barang-Periode&hal=$list[$h]&kodeSupplier=$kodeSupplier'>$h</a> ";
	}
	?></td>
  </tr>
</table>

<a href="cetak/pembelian_barang_periode.php?kodeSupplier=<?php echo $kodeSupplier; ?>&tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
