<?php
include "koneksi.php";
$Q = mysqli_query($koneksi, "SELECT wisata.*, kategori.nama_kategori 
FROM wisata 
INNER JOIN kategori ON wisata.fk_id_k = kategori.id_kategori;");
if ($Q) {
        $posts = array();
        if (mysqli_num_rows($Q)) {
                while ($post = mysqli_fetch_assoc($Q)) {
                        $posts[] = $post;
                        print_r($obj);
                }
        }
        $data = json_encode(array('results' => $posts));
        echo $data;
}