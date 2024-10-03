<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<ul>
	<?php if($aksesData['mlap_user'] == "Yes") { ?>
	<li><a href="?open=Laporan-User" target="_blank">Laporan Data User</a></li>
	
	<?php } if($aksesData['mlap_supplier'] == "Yes") { ?>
	<li><a href="?open=Laporan-Supplier" target="_blank">Laporan Data Supplier</a></li>
	
	<?php } if($aksesData['mlap_pelanggan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pelanggan" target="_blank">Laporan Data Pelanggan</a></li>
	
	<?php } if($aksesData['mlap_merek'] == "Yes") { ?>
	<li><a href="?open=Laporan-Merek" target="_blank">Laporan Data Merek</a></li>
	
	<?php } if($aksesData['mlap_kategori'] == "Yes") { ?>
	<li><a href="?open=Laporan-Kategori" target="_blank">Laporan Data Kategori</a></li>
	
	<?php } if($aksesData['mlap_jenis'] == "Yes") { ?>
	<li><a href="?open=Laporan-Jenis" target="_blank">Laporan Data Jenis</a></li>
	
	<?php } if($aksesData['mlap_barang_kategori'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Kategori" target="_blank">Laporan Data Barang per Kategori</a></li>
	
	<?php } if($aksesData['mlap_barang_jenis'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Jenis" target="_blank">Laporan Data Barang per Jenis</a></li>
	
	<?php } if($aksesData['mlap_barang_merek'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Merek" target="_blank">Laporan Data Barang per Merek</a></li>
	
	<?php } if($aksesData['mlap_barang_minimal'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Stok-Minimal" target="_blank">Laporan Data Barang Stok Minimal</a></li>
	
	<?php } if($aksesData['mlap_barang_maksimal'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Stok-Maksimal" target="_blank">Laporan Data Barang Stok Maksimal</a></li>

	<br />
	
	<?php } if($aksesData['mlap_pembelian_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Periode" target="_blank">Laporan Transaksi Pembelian per Periode</a></li>
	
	<?php } if($aksesData['mlap_pembelian_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Bulan" target="_blank">Laporan Transaksi Pembelian per Bulan</a></li>
	
	<?php } if($aksesData['mlap_pembelian_supplier'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Supplier" target="_blank">Laporan Transaksi Pembelian per Supplier</a></li>
	
	<?php } if($aksesData['mlap_pembelian_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Barang-Periode" target="_blank">Laporan Pembelian Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_pembelian_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Barang-Bulan" target="_blank">Laporan Pembelian Barang per Bulan</a></li>
	<br />
	
	<?php } if($aksesData['mlap_returbeli_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returbeli-Periode" target="_blank">Laporan Retur Pembelian per Periode</a></li>
	
	 <?php } if($aksesData['mlap_returbeli_bulan'] == "Yes") { ?>
	<!-- <li><a href="?open=Laporan-Returbeli-Bulan" target="_blank">Laporan Retur Beli per Bulan & Tahun</a></li>  -->
	
	<?php } if($aksesData['mlap_returbeli_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returbeli-Barang-Periode" target="_blank">Laporan Retur Pembelian Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_returbeli_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returbeli-Barang-Bulan" target="_blank">Laporan Retur Pembelian Barang per Bulan</a></li>
	<br />
	
	<?php }  if($aksesData['mlap_penjualan_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Periode" target="_blank">Laporan Transaksi Penjualan per Periode</a></li>
	
	<?php }  if($aksesData['mlap_penjualan_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Bulan" target="_blank">Laporan Transaksi Penjualan per Bulan</a></li>
	
	<?php }  if($aksesData['mlap_penjualan_pelanggan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Pelanggan" target="_blank">Laporan Transaksi Penjualan per Pelanggan</a></li>
	<br />
	
	<?php } if($aksesData['mlap_penjualan_barang_tanggal'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Barang-Tanggal" target="_blank">Laporan Penjualan Barang per Tanggal</a></li>
	
	<?php } if($aksesData['mlap_penjualan_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Barang-Periode" target="_blank">Laporan Penjualan Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_penjualan_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Barang-Bulan" target="_blank">Laporan Penjualan Barang per Bulan</a></li>
	
	<?php } if($aksesData['mlap_penjualan_barang_pelanggan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Barang-Pelanggan" target="_blank">Laporan Penjualan Barang per Pelanggan</a></li>
	
	<?php } if($aksesData['mlap_penjualan_terlaris'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Barang-Terlaris" target="_blank">Laporan Penjualan Berang Terlaris</a></li>
	
	<?php } if($aksesData['mlap_penjualan_rekap_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Penjualan-Periode" target="_blank">Laporan Rekap Penjualan per Periode</a></li>
	
	<?php } if($aksesData['mlap_penjualan_rekap_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Penjualan-Bulan" target="_blank">Laporan Rekap Penjualan per Bulan</a></li>
	
	<?php } if($aksesData['mlap_labarugi_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Labarugi-Periode" target="_blank">Laporan Laba/Rugi Penjualan per Periode</a></li>
	
	<?php } if($aksesData['mlap_labarugi_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Labarugi-Bulan" target="_blank">Laporan Laba/Rugi Penjualan per Bulan</a></li>
	<br />

	<?php } if($aksesData['mlap_returjual_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returjual-Periode" target="_blank">Laporan Retur Penjualan per Periode</a></li>
	
	<?php } if($aksesData['mlap_returjual_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returjual-Barang-Periode" target="_blank">Laporan Retur Penjualan Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_returjual_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returjual-Barang-Bulan" target="_blank">Laporan Retur Penjualan Barang per Bulan</a></li>

	<?php } ?>
</ul>
<?php
}
?>