<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_pelanggan'] == "Yes") {

# Bulan dan Tahun Terpilih
$kodePlg	= isset($_GET['kodePlg']) ? $_GET['kodePlg'] : ''; // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataPelanggan 	= isset($_POST['cmbPelanggan']) ? $_POST['cmbPelanggan'] : $kodePlg; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataPelanggan and $dataTahun) {
	$filterSQL = "AND p.kd_pelanggan='$dataPelanggan' AND LEFT(p.tgl_penjualan,4)='$dataTahun'";
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penjualan_barang_pelanggan.php?tahun=$dataTahun&kodePlg=$dataPelanggan')";
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
<h2>LAPORAN HASIL PENJUALAN BARANG PER PELANGGAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td><strong>Pelanggan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbPelanggan">
          <?php
		// Menampilkan Data Pelanggan
	  $bacaSql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_pelanggan'] == $dataPelanggan) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_pelanggan]' $cek> $bacaData[kd_pelanggan] - $bacaData[nm_pelanggan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td width="119"><strong>Tahun  </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="362">
	  <select name="cmbTahun">
      <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_penjualan,4)) As tahun_kecil, MAX(LEFT(tgl_penjualan,4)) As tahun_besar FROM penjualan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		
		// Membaca tahun
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select>
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
	
	// Skrip menampilkan data Barang dari tiap Transaksi Penjualan, dilengkapi filter Pelanggan
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
		echo " <a href='?open=Laporan-Penjualan-Barang-Pelanggan&hal=$list[$h]&kodePlg=$dataPelanggan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/penjualan_barang_pelanggan.php?tahun=<?php echo $dataTahun; ?>&kodePlg=<?php echo $dataPelanggan; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
