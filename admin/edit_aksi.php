<?php
// koneksi database
include '../koneksi.php';

// menangkap data yang dikirim dari form
$id = $_POST['id_wisata'];
$nama = $_POST['nama_wisata'];
$alamat = $_POST['alamat'];
$deskripsi = $_POST['deskripsi'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$fk_id_k = $_POST['fk_id_k'];
$nomor = $_POST['nomor'];

// Ambil data foto lama
$query = mysqli_query($koneksi, "SELECT foto FROM wisata WHERE id_wisata='$id'");
$data = mysqli_fetch_array($query);
$fotoLama = isset($data['foto']) ? $data['foto'] : '';

// Tangkap checkbox hapus
$hapusFoto = isset($_POST['hapus_foto']) ? $_POST['hapus_foto'] : 0;

// Jika checkbox hapus dicentang
if ($hapusFoto == 1) {
    // Hapus foto lama jika ada
    if (!empty($fotoLama)) {
        $pathFotoHapus = "assets/img/$fotoLama";
        if (file_exists($pathFotoHapus)) {
            unlink($pathFotoHapus);
        }

        // Update nama file foto di database menjadi kosong
        mysqli_query($koneksi, "UPDATE wisata SET foto='' WHERE id_wisata='$id'");
    }
}

// Mengelola foto yang baru diunggah hanya jika checkbox "Ganti" dicentang atau input file tidak kosong
if ($hapusFoto == 1 || !empty($_FILES['foto']['name'])) {
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmpFoto = $_FILES['foto']['tmp_name'];
        $namaFileBaru = uniqid() . "_" . $foto;

        // Pindahkan foto baru ke folder tujuan
        if (move_uploaded_file($tmpFoto, "assets/img/" . $namaFileBaru)) {
            // Hapus foto lama jika ada
            if (!empty($fotoLama)) {
                $pathFotoHapus = "assets/img/$fotoLama";
                if (file_exists($pathFotoHapus)) {
                    unlink($pathFotoHapus);
                }
            }

            // Update nama file foto di database
            mysqli_query($koneksi, "UPDATE wisata SET foto='$namaFileBaru' WHERE id_wisata='$id'");
        } else {
            echo "Gagal mengunggah foto.";
        }
    }
}

// Update data lain ke database
mysqli_query($koneksi, "UPDATE wisata SET nama_wisata='$nama', alamat='$alamat', deskripsi='$deskripsi', latitude='$latitude', longitude='$longitude', fk_id_k='$fk_id_k', nomor='$nomor'  WHERE id_wisata='$id'");

// Mengalihkan halaman kembali ke tampil_data.php
header("location:tampil_data.php");
?>
