<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sig_map4";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_error($koneksi));
}

// Ambil kata kunci pencarian dari parameter GET
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Buat query pencarian dengan parameter LIKE
$query = "SELECT * FROM wisata WHERE nama_wisata LIKE '%$keyword%'";
$result = mysqli_query($koneksi, $query);

// Format hasil query menjadi GeoJSON
$features = array();

while ($row = mysqli_fetch_assoc($result)) {
  $feature = array(
    'type' => 'Feature',
    'geometry' => array(
      'type' => 'Point',
      'coordinates' => array(floatval($row['longitude']), floatval($row['latitude']))
    ),
    'properties' => array(
      'id_wisata' => $row['id_wisata'],
      'name' => $row['nama_wisata'],
      // Tambahkan properti lain sesuai kebutuhan
    )
  );

  array_push($features, $feature);
}

$geojson = array(
  'type' => 'FeatureCollection',
  'features' => $features
);

// Tampilkan sebagai JSON
header('Content-Type: application/json');
echo json_encode($geojson);

// Tutup koneksi ke database
mysqli_close($koneksi);
?>
