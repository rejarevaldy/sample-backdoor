<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses
if($aksesData['mu_data_barang'] == "Yes") {

# TAMPILKAN DATA UNTUK DIEDIT
$Kode	= $_GET['Kode']; 
$mySql 	= "SELECT barang.*, kategori.nm_kategori, jenis.nm_jenis, merek.nm_merek FROM barang 
			LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
			LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
			LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
			WHERE barang.kd_barang='$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData	= mysql_fetch_array($myQry);
?>
<html>
<head>
<title>::  Lihat Barang</title>
<link href="styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <th colspan="3">DETIL BARANG </th>
	</tr>
	<tr>
	  <td width="22%"><strong>Kode </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="77%"><?php echo $myData['kd_barang']; ?></td>
	</tr>
	<tr>
      <td><strong>Barcode</strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['barcode']; ?></td>
	</tr>
	<tr>
	  <td><b>Nama Barang </b></td>
      <td><strong>:</strong></td>
	  <td><?php echo $myData['nm_barang']; ?></td>
	</tr>
	<tr>
	  <td><b>Keterangan</b></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['keterangan']; ?></td>
	</tr>
	<tr>
      <td><strong>Satuan</strong></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['satuan']; ?></td>
    </tr>
	<tr>
      <td><b>Harga Modal/Beli (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_modal']); ?></td>
	</tr>
	<tr>
      <td><b>Harga Modal 1 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_modal_1']); ?></td>
	</tr>
	<tr>
      <td><b>Harga Modal 2 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_modal_2']); ?></td>
  </tr>
	<tr>
      <td><b>Harga Modal 3 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_modal_3']); ?></td>
  </tr>
	<tr>
      <td><b>Harga Modal 4 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_modal_4']); ?></td>
	</tr>
	<tr>
      <td><b>Harga Jual 1 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_jual_1']); ?></td>
	</tr>
	<tr>
      <td><b>Harga Jual 2 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_jual_2']); ?></td>
  </tr>
	<tr>
      <td><b>Harga Jual 3 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_jual_3']); ?></td>
  </tr>
	<tr>
      <td><b>Harga Jual 4 (Rp.) </b></td>
	  <td><b>:</b></td>
	  <td><?php echo format_angka($myData['harga_jual_4']); ?></td>
	</tr>
	<tr>
      <td><b>Merek</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['nm_merek']; ?></td>
    </tr>
	<tr>
      <td><strong>Kategori / Jenis</strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['nm_kategori']; ?></td>
	</tr>
	<tr>
      <td><strong>Lokasi Stok </strong></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['lokasi_stok']; ?></td>
    </tr>
	<tr>
      <td><strong>Lokasi Rak </strong></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['lokasi_rak']; ?></td>
	</tr>
	<tr>
      <td bgcolor="#F5F5F5"><strong>KONTROL STOK </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
      <td><strong>Stok </strong></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['stok']; ?></td>
  </tr>
	<tr>
      <td><strong>Stok Opname </strong></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['stok_opname']; ?></td>
	</tr>
	<tr>
      <td><strong>Stok Minimal</strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['stok_minimal']; ?></td>
	</tr>
	<tr>
      <td><b>Stok Maksimal </b></td>
	  <td><b>:</b></td>
	  <td><?php echo $myData['stok_maksimal']; ?></td>
	</tr>
</table>
</body>
</html>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

