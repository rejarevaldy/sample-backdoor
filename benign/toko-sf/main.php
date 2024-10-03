<?php
if(isset($_SESSION['SES_LOGIN'])) {
	echo "<h2 style='margin:-5px 0px 5px 0px; padding:0px;'>Selamat datang ........!</h2></p>";
	echo "<h3 style='margin:-5px 0px 5px 0px; padding:0px;'>Software POS (Point Of Sale) Toko Distributor v 2.2</h3></p>";
	
	$kode	= $_SESSION['SES_LOGIN'];
	
	// membaca user yang login
	$mySql = "SELECT * FROM user WHERE kd_user ='$kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	
	echo "Anda sudah login dengan <b> Level Akses : $myData[level]</b>";
?> <BR /><BR />
<table  class="table-list" width="400" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>INFORMASI</strong></td>
  </tr>
  <tr>
    <td width="100"><strong>Nama </strong></td>
    <td width="6"><strong>:</strong></td>
    <td width="272"> <?php echo $myData['nm_user']; ?></td>
  </tr>
  <tr>
    <td><strong>Username</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['username']; ?></td>
  </tr>
  <tr>
    <td><strong>Level</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
</table>

<?php 
	exit;
}
else {
	echo "<h2 style='margin:-5px 0px 5px 0px; padding:0px;'>Selamat datang ........!</h2></p>";
	echo "<h3 style='margin:-5px 0px 5px 0px; padding:0px;'>Software POS (Point Of Sale) Toko Distributor v 2.2</h3></p>";
	echo "<b>Anda belum login, silahkan <a href='?open=Login' alt='Login'>login </a>untuk mengakses sitem ini ";	
}
?>