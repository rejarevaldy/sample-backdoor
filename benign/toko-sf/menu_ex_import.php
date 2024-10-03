<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<ul>
	<?php if($aksesData['mu_export_barang'] == "Yes") { ?>
	<li><a href="?open=Export-Barang">Export Barang ke Excel</a></li>
	
	<?php } if($aksesData['mu_import_barang'] == "Yes") { ?>
	<li><a href="?open=Import-Barang">Import Barang dari Excel</a></li>	
	
	<?php } if($aksesData['mu_export_pelanggan'] == "Yes") { ?>
	<li><a href="?open=Export-Pelanggan">Export Pelanggan ke Excel</a></li>
	
	<?php } if($aksesData['mu_import_pelanggan'] == "Yes") { ?>
	<li><a href="?open=Import-Pelanggan">Import Pelanggan dari Excel</a></li>	
	
	<?php } ?>
</ul>	
<?php
}
?>