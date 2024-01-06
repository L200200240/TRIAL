<?php
// koneksi database
include '../koneksi.php';

// menangkap data yang dikirim dari form
$nama = $_POST['nama_wisata'];
$alamat = $_POST['alamat'];
$deskripsi = $_POST['deskripsi'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$nomor = $_POST['nomor'];
$fk_id_k = $_POST['fk_id_k'];

// mengambil data foto
$foto = $_FILES['foto']['name'];
$tmpFoto = $_FILES['foto']['tmp_name'];

// Set folder tujuan penyimpanan foto
$folderTujuan = "assets/img/";

// Ganti nama file sementara
$namaFileBaru = uniqid() . "_" . $foto;

// Pastikan folder tujuan ada, jika tidak, buat folder
if (!file_exists($folderTujuan)) {
    mkdir($folderTujuan, 0777, true);
}

// Pindahkan foto baru ke folder tujuan
if (move_uploaded_file($tmpFoto, $folderTujuan . $namaFileBaru)) {
    // Masukkan foto ke kolom 'foto' dalam tabel 'wisata'
    $queryInsertFoto = "INSERT INTO wisata (nama_wisata, alamat, deskripsi, latitude, longitude, fk_id_k, nomor, foto) VALUES ('$nama', '$alamat', '$deskripsi', '$latitude', '$longitude', '$fk_id_k', '$nomor', '$namaFileBaru')";
    mysqli_query($koneksi, $queryInsertFoto);
} else {
    echo "Gagal mengunggah foto.";
}

//menginput data ke database
//mysqli_query($koneksi, "insert into wisata values('','$nama','$alamat','$deskripsi','$latitude','$longitude')");

// mengalihkan halaman kembali ke tampil_data.php
header("location:tampil_data.php");
?>