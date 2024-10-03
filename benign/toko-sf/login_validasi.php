<?php
# MEMBACA TOMBOL KOGIN DARI FILE login.php
if(isset($_POST['btnLogin'])){
	# Baca variabel form
	$txtUser 		= $_POST['txtUser'];
	$txtUser 		= str_replace("'","&acute;",$txtUser);
	
	$txtPassword	= $_POST['txtPassword'];
	$txtPassword	= str_replace("'","&acute;",$txtPassword);
	$cmbLevel		= $_POST['cmbLevel'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if ( trim($txtUser)=="") {
		$pesanError[] = "Data <b> Username </b>  tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b> Password </b> tidak boleh kosong !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level</b> belum ada yang dipilih !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
		
		// Tampilkan lagi form login
		include "login.php";
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN
		$mySql = "SELECT * FROM user WHERE username='$txtUser' AND password='".md5($txtPassword)."' AND level='$cmbLevel'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah : ".mysql_error());
		$myData= mysql_fetch_array($myQry);
		
		# JIKA LOGIN SUKSES
		if(mysql_num_rows($myQry) >=1) {
			// Menyimpan Kode yang Login
			$_SESSION['SES_LOGIN'] = $myData['kd_user']; 

			// Jika yang login Administrator
			if($cmbLevel=="Admin") {
				$_SESSION['SES_LEVEL'] = "Admin";
				$_SESSION['SES_ADMIN'] = "Admin";
			}
			elseif($cmbLevel=="Gudang") {
				// Jika yang login Gudang
				$_SESSION['SES_LEVEL'] = "Gudang";
				$_SESSION['SES_GUDANG'] = "Gudang";
			}
			elseif($cmbLevel=="Kasir") {
				// Jika yang login Kasir
				$_SESSION['SES_LEVEL'] = "Kasir";
				$_SESSION['SES_KASIR'] = "Kasir";
			}
			else {
				$_SESSION['SES_LEVEL'] = "";
				$_SESSION['SES_ADMIN'] = "";
				$_SESSION['SES_GUDANG'] = "";
				$_SESSION['SES_KASIR'] = "";
			}
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Halaman-Utama'>";
		}
		else {
			 echo "Login Anda ditolak ";
		}
	}
} // End POST
?>
 
