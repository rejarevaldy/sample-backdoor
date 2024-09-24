<?php 

$conn = mysqli_connect("localhost","root", "", "kantor");

$timezone = new DateTimeZone ('Asia/Ujung_Pandang');
    $date = new DateTime();
    $date->setTimeZone($timezone);

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query) or die("Query error : " . mysqli_error($conn));
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
};

function ubah($data){
    global $conn;
    global $date;

    $id = $data["id"];
    $ktp = $data["ktp"];
    $nama = $data["nama"];
    $tanggal_lahir = $data["tanggal_lahir"];
    $handphone = $data["handphone"];
    $alamat = $data["alamat"];
    $pekerjaan = $data["pekerjaan"];
    $tanggal_dibuat = $date->format('Y-m-d');

    $query = "UPDATE data_nasabah 
                SET ktp='$ktp', nama='$nama', tanggal_lahir='$tanggal_lahir', handphone='$handphone', alamat='$alamat', pekerjaan='$pekerjaan' WHERE id= $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
};

function tambah($data){
    global $conn;
    global $date;

    $ktp = $data["ktp"];
    $nama = $data["nama"];
    $tanggal_lahir = $data["tanggal_lahir"];
    $handphone = $data["handphone"];
    $alamat = $data["alamat"];
    $pekerjaan = $data["pekerjaan"];
    $tanggal_dibuat = $date->format('Y-m-d');

    $query = "INSERT INTO data_nasabah VALUES('', '$ktp', '$nama', '$tanggal_lahir', '$handphone', '$alamat', '$pekerjaan')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
};

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM data_nasabah WHERE id = $id");
    return mysqli_affected_rows($conn);
};

function tambahpengeluaran($data){
    global $conn;
    global $date;

    $tanggal_pembelian = $data["tanggal_pembelian"];
    $nama_barang = $data["nama_barang"];
    $satuan = $data["satuan"];
    $harga = $data["harga"];

    $query = "INSERT INTO pengeluaran VALUES('', '$tanggal_pembelian', '$nama_barang', '$satuan', '$harga')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
};

function updatepengeluaran($data){
    global $conn;
    global $date;

    $id = $data["id_pengeluaran"];
    $tanggal_pembelian = $data["tanggal_pembelian"];
    $nama_barang = $data["nama_barang"];
    $satuan = $data["satuan"];
    $harga = $data["harga"];

    $query = "UPDATE pengeluaran SET tanggal_pembelian='$tanggal_pembelian', nama_barang='$nama_barang', satuan='$satuan', harga='$harga' WHERE id_pengeluaran= $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
};

function hapuspengeluaran($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM pengeluaran WHERE id_pengeluaran = $id");
    return mysqli_affected_rows($conn);
};

function tambahpermohonan($data){
    global $conn;
    global $date;

    $ktpPem = $data["ktpPem"];
    $namaPem = $data["namaPem"];
    $tanggal_lahirPem = $data["tanggal_lahirPem"];
    $handphonePem = $data["handphonePem"];
    $pekerjaanPem = $data["pekerjaanPem"];
    $alamatPem = $data["alamatPem"];
    $jenis_permohonan = $data["jenis_permohonan"];
    $jenis_sertifikat = $data["jenis_sertifikat"];
    $sertifikat = $data["sertifikat"];
    $tanah = $data["tanah"];
    $bangunan = $data["bangunan"];
    $objek = $data["objek"];
    $nop = $data["nop"];
    $kelurahan = $data["kelurahan"];
    $kecamatan = $data["kecamatan"];
    $ktpPen = $data["ktpPen"];
    $namaPen = $data["namaPen"];
    $tanggal_lahirPen = $data["tanggal_lahirPen"];
    $handphonePen = $data["handphonePen"];
    $pekerjaanPen = $data["pekerjaanPen"];
    $alamatPen = $data["alamatPen"];
    $tanggal_permohonan = $data["tanggal_permohonan"];
    $tanggal_deadline = $data["tanggal_deadline"];

    $query = "INSERT INTO permohonan VALUES('', '$ktpPem', '$namaPem', '$tanggal_lahirPem', '$handphonePem', '$pekerjaanPem', '$alamatPem', '$jenis_permohonan', '$jenis_sertifikat', '$sertifikat', '$tanah', '$bangunan', '$objek', '$nop', '$kelurahan', '$kecamatan', '$ktpPen', '$namaPen', '$tanggal_lahirPen', '$handphonePen', '$pekerjaanPen', '$alamatPen', '$tanggal_permohonan', '$tanggal_deadline')" or die(mysqli_error($conn));
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
};

function register($data) {
    global $conn;

    $nama = $data["nama"];
    $username = stripslashes($data["username"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO akun VALUES ('', '$nama', '$username', '$password')");
    return mysqli_affected_rows($conn);
}

function hapusUser($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM akun WHERE id_user = $id");
    return mysqli_affected_rows($conn);
}

function hapusPermohon($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM permohonan WHERE id_permohonan = $id");
    return mysqli_affected_rows($conn);
}