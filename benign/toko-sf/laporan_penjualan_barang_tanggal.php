<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_tanggal'] == "Yes") {

# Deklarasi variabel
$filterSQL = ""; 
$dataTanggal	= ""; 

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (tanggal)
	$filterSQL = "AND tgl_penjualan = '".InggrisTgl($dataTanggal)."'";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$dataTanggal 	= isset($_GET['tanggal']) ? $_GET['tanggal'] : $dataTanggal;
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (tanggal)
	$filterSQL = "AND tgl_penjualan = '".InggrisTgl($dataTanggal)."'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/penjualan_barang_tanggal.php?tanggal=$dataTanggal')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan As p, penjualan_item As pi WHERE p.no_penjualan = pi.no_penjualan 
			$filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>LAPORAN HASIL PENJUALAN BARANG PER TANGGAL </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="90"><strong>Tanggal </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="18" />
        <input name="btnTampil" type="submit" value=" Tampilkan " />
        <input name="btnCetak" type="submit"  value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="72" bgcolor="#CCCCCC"><strong>Tgl.Nota</strong></td>
    <td width="74" bgcolor="#CCCCCC"><strong>No. Nota </strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="353" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="110" align="right" bgcolor="#CCCCCC"><strong>Hrg. Jual (Rp) </strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="115" align="right" bgcolor="#CCCCCC"><strong>Sub Total (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	  $subTotalHarga	= 0;
  	$totalSemuaBarang= 0;
  	$totalSemuaHarga = 0; 
	
	// Skrip menampilkan data Barang dari tiap Transaksi Penjualan, dilengkapi filter Tanggal Transaksi
	$mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_jual, pi.jumlah 
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_penjualan = pi.no_penjualan
				$filterSQL
				ORDER BY p.no_penjualan ASC LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		# Hitung Baris Kanan (Sub Total)
		$subTotalHarga	= $myData['harga_jual'] * $myData['jumlah'];
		
		// Hitung Satu Kolom ke Bawah (Grand Total)
		$totalSemuaBarang	= $totalSemuaBarang + $myData['jumlah']; 
		$totalSemuaHarga	= $totalSemuaHarga + $subTotalHarga; 
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalHarga); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalSemuaBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalSemuaHarga); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jumData; ?></td>
    <td colspan="5" align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Penjualan-Barang-Tanggal&hal=$list[$h]&tanggal=$dataTanggal'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/penjualan_barang_tanggal.php?tanggal=<?php echo $dataTanggal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
