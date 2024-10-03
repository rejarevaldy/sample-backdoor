<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	<?php if($aksesData['mu_data_user'] == "Yes") { ?>
	<li><a href='?open=User-Data' title='User Login'>Data User</a></li>
	
	<?php } if($aksesData['mu_data_pelanggan'] == "Yes") { ?>
	<li><a href='?open=Pelanggan-Data' title='Pelanggan'>Data Pelanggan</a></li>
	
	<?php } if($aksesData['mu_data_supplier'] == "Yes") { ?>
	<li><a href='?open=Supplier-Data' title='Supplier'>Data Supplier</a></li>
	
	<?php } if($aksesData['mu_data_merek'] == "Yes") { ?>
	<li><a href='?open=Merek-Data' title='Merek'>Data Merek</a></li>
	
	<?php } if($aksesData['mu_data_kategori'] == "Yes") { ?>
	<li><a href='?open=Kategori-Data' title='Kategori'>Data Kategori</a></li>
	
	<?php } if($aksesData['mu_data_jenis'] == "Yes") { ?>
	<li><a href='?open=Jenis-Data' title='Jenis'>Data Jenis</a></li>
	
	<?php } if($aksesData['mu_data_barang'] == "Yes") { ?>
	<li><a href='?open=Barang-Data' title='Barang'>Data Barang</a></li>

	<?php } if($aksesData['mu_kontrol_stok'] == "Yes") { ?>
	<li><a href='?open=Barang-Stok' title='Barang'>Stok Barang</a></li>
	
	<?php } if($aksesData['mu_pencarian'] == "Yes") { ?>
	<li><a href='?open=Barang-Cari' title='Pencarian'>Pencarian Barang</a></li>
		
	<?php } if($aksesData['mu_trans_pembelian'] == "Yes") { ?>
	<li><a href='pembelian/' title='Pembelian' target='_blank'>Transaksi Pembelian Stok</a> </li>
	
	<?php } if($aksesData['mu_trans_returbeli'] == "Yes") { ?>
	<li><a href='retur-beli/' title='Retur' target='_blank'>Transaksi Retur Pembelian</a> </li>
	
	<?php } if($aksesData['mu_trans_penjualan'] == "Yes") { ?>
	<li><a href='penjualan/' title='Penjualan' target='_blank'>Transaksi Penjualan Ritel</a> </li>
	
	<?php } if($aksesData['mu_trans_returjual'] == "Yes") { ?>
	<li><a href='retur-jual/' title='Retur' target='_blank'>Transaksi Retur Penjualan</a> </li>
	
	<?php } if($aksesData['mu_bayar_penjualan'] == "Yes") { ?>
	<li><a href='pembayaran-pelanggan/' title='Pembayaran' target='_blank'>Pembayaran Pelanggan</a> </li>
	
	<?php } if($aksesData['mu_bayar_pembelian'] == "Yes") { ?>
	<li><a href='pembayaran-supplier/' title='Pembayaran' target='_blank'>Pembayaran Supplier</a> </li>
	
	<?php } if($aksesData['mu_laporan_cetak'] == "Yes") { ?>
	<li><a href='?open=Laporan-Cetak' title='Laporan'>Laporan Cetak</a></li>
	
	<?php } if($aksesData['mu_laporan_grafik'] == "Yes") { ?>
	<li><a href='?open=Laporan-Grafik' title='Laporan'>Laporan Grafik</a></li>
	
	<?php } if($aksesData['mu_barcode'] == "Yes") { ?>
	<li><a href='?open=Cetak-Barcode' title='Cetak Barcode'>Tools Cetak Label Barcode</a></li>
	
	<?php } if($aksesData['mu_backup_restore'] == "Yes") { ?>
	<li><a href='?open=Backup-Restore' title='Laporan'>Tools Backup & Restore</a></li>
	
	<?php } if($aksesData['mu_export_import'] == "Yes") { ?>
	<li><a href='?open=Export-Import' title='Laporan'>Tools Export/Import</a></li>
	
	<?php } ?>
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
</ul>
<?php
}
else {
# JIKA BELUM LOGIN (BELUM ADA SESION LEVEL YG DIBACA)
?>
<ul>
	<li><a href='?open=Login' title='Login System'>Login</a></li>	
</ul>
<?php
}
?>
