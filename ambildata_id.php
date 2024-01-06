<?php
include "koneksi.php";

$id = $_GET['id_wisata'];

$Q = mysqli_query($koneksi, "SELECT wisata.*, kategori.nama_kategori 
                              FROM wisata 
                              LEFT JOIN kategori ON wisata.fk_id_k = kategori.id_kategori 
                              WHERE wisata.id_wisata=" . $id) or die(mysqli_error($koneksi));

$posts = array();

if ($Q) {
    if (mysqli_num_rows($Q) > 0) {
        while ($post = mysqli_fetch_assoc($Q)) {
            $posts[] = $post;
        }
    } else {
        // Data tidak ditemukan
        $posts = array('message' => 'Data not found');
    }
} else {
    // Query tidak berhasil dieksekusi
    $posts = array('message' => 'Query failed');
}

$data = json_encode(array('results' => $posts));
