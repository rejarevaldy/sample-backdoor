<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_labarugi_periode'] == "Yes") {

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

// Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : $tglAkhir;

// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
$filterSQL = "AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/labarugi_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan AS p, penjualan_item AS pi
			WHERE p.no_penjualan = pi.no_penjualan 
			$filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$baris);
?>
<h2>LAPORAN HASIL PENJUALAN BARANG PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="550" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="420"><input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
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

<table class="table-list" width="1006" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="65" bgcolor="#CCCCCC"><strong>Tgl. Nota </strong></td>
    <td width="65" bgcolor="#CCCCCC"><strong>No. Nota </strong></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="372" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="112" align="right" bgcolor="#CCCCCC"><strong>Hrg. Modal (Rp)</strong></td>
    <td width="102" align="right" bgcolor="#CCCCCC"><strong>Hrg. Jual (Rp) </strong></td>
    <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="120" align="right" bgcolor="#CCCCCC"><strong>Laba/Rugi (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$untungRugi 	= 0;
	$totalHrgModal	= 0;
	$totalHrgJual	= 0;
  	$totalRugiLaba	= 0; 
	$totalBarang	= 0;
	
	// Skrip menampilkan data Penjualan per Item Barang dengan filter Periode
	$mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_modal, pi.harga_jual, pi.jumlah 
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_penjualan = pi.no_penjualan
				$filterSQL
				ORDER BY no_penjualan ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		# Hitung
		$untungRugi		= $myData['harga_jual'] - $myData['harga_modal'];
		$totalHrgModal	= $totalHrgModal + ( $myData['harga_modal'] * $myData['jumlah']);  // Menghitung total modal beli
		$totalHrgJual	= $totalHrgJual + ( $myData['harga_jual'] * $myData['jumlah']);  // Menghitung total harga jual
		$totalBarang	= $totalBarang + $myData['jumlah'];  // Menghitung total barang terjual
		$totalRugiLaba  =  $totalHrgJual - $totalHrgModal;  // Menghitung total Laba/Rugi (selish harga beli dan penjualan)
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($untungRugi); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong>GRAND TOAL  : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHrgModal); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalHrgJual); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalRugiLaba); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data : <?php echo $jumData; ?></strong></td>
    <td colspan="6" align="right"><strong>Halaman ke :
        <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Labarugi-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
<a href="cetak/labarugi_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
