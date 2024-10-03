<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_barang_bulan'] == "Yes") {

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

// Membaca Bulan Terpilih dari Form/ URL
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

// Membaca Tahun Terpilih dari Form/ URL
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

// Membuat SQL Filter Bulan dan Tahun
if($dataTahun and $dataBulan) {
	$filterSQL = $filterSPL."AND LEFT(p.tgl_pembelian,4)='$dataTahun' AND MID(p.tgl_pembelian,6,2)='$dataBulan'";
}
else {
	$filterSQL = $filterSPL;
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pembelian_barang_bulan.php?kodeSupplier=$kodeSupplier&bulan=$dataBulan&tahun=$dataTahun')";
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
<h2>LAPORAN PEMBELIAN BARANG PER BULAN</h2>
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
      <td><strong>Bulan Transaksi </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBulan">
          <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
						 "04" => "04. April", "05" => "05. Mei", "06" => "06. Juni", "07" => "07. Juli",
						 "08" => "08. Agustus", "09" => "09. September", "10" => "10. Oktober",
						 "11" => "11. November", "12" => "12. Desember");
						 
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pembelian,4)) As tahun_kecil, MAX(LEFT(tgl_pembelian,4)) As tahun_besar FROM pembelian";
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
        </select></td>
    </tr>
    <tr>
      <td width="137">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="344"><input name="btnTampil" type="submit" value=" Tampilkan " />
	  <input name="btnCetak" type="submit"  value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="20" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Tgl. Faktur </strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>No. Faktur </strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="380" bgcolor="#CCCCCC"><strong>Nama Barang  </strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>PPN/PPH (Rp) </strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>Hrg. Beli (Rp) </strong></td>
    <td width="49" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="110" align="right" bgcolor="#CCCCCC"><strong>Hrg. Total (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalHarga		= 0;
	$totalBarang	= 0;
	
	// Skrip Menampilkan data Pembelian Item Barang dengan Filter Bulan
	$mySql = "SELECT p.no_pembelian, p.tgl_pembelian, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.jumlah, pi.ppn, 
				(pi.harga_beli * pi.jumlah) As total_harga
				FROM pembelian As p, pembelian_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_pembelian = pi.no_pembelian
				$filterSQL
				ORDER BY no_pembelian, kd_barang ASC LIMIT $halaman, $baris";
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
    <td align="right"><?php echo format_angka($myData['total_harga']  + $ppn); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="6" align="right"><strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pembelian-Barang-Bulan&hal=$list[$h]&kodeSupplier=$kodeSupplier&&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>

<a href="cetak/pembelian_barang_bulan.php?kodeSupplier=<?php echo $kodeSupplier; ?>&bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
