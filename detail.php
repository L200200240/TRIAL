<?php include "header.php"; ?>

<?php
$id = isset($_GET['id_wisata']) ? intval($_GET['id_wisata']) : 0;

if ($id <= 0) {
    die("Invalid or missing ID parameter");
}

include_once "ambildata_id.php";
$obj = json_decode($data);

if ($obj === null && json_last_error() !== JSON_ERROR_NONE) {
    die("Error decoding JSON data");
}

$id_wisata = "";
$nama_wisata = "";
$alamat = "";
$deskripsi = "";
$lat = "";
$long = "";
$id_kategori = "";
$nomor = "";
$foto = "";

// Memeriksa apakah ada hasil dalam objek $obj
if (!empty($obj->results)) {
    // Mengambil elemen terakhir dari array
    $item = end($obj->results);
    
    $id_wisata = $item->id_wisata;
    $nama_wisata = $item->nama_wisata;
    $alamat = $item->alamat;
    $deskripsi = $item->deskripsi;
    $lat = $item->latitude;
    $long = $item->longitude;
    $id_kategori = $item->fk_id_k;
    $nomor = $item->nomor;
    $foto = !empty($item->foto) ? $item->foto : $foto;
}

$title = "Detail dan Lokasi : " . $nama_wisata;
?>

<main id="main">
    <!-- Start about-info Area -->
    <section class="price-area section">
        <section class="about-info-area section">
            <div class="title text-center">
                <h1 class="mb-10">Data Wisata Kuliner</h1>
                <br>
            </div>
            <div class="container" style="padding-top: 10px;">
                <div class="row">
                  <div class="col-md-7" data-aos="fade-up" data-aos-delay="200">
                    <div class="panel panel-info panel-dashboard">
                      <div class="panel-body">
                        <div class="panel-heading centered">
                            <h2 class="panel-title"><strong><?php echo $nama_wisata ?></strong></h2>
                        </div>
                        <table class="table">
                          <tr>
                            <th>Detail</th>
                          </tr>
                          <tr>
                            <td>Deskripsi</td>
                            <td>
                              <h5><?php echo $deskripsi ?></h5>
                            </td>
                          </tr>
                          <tr>
                            <td>Alamat</td>
                            <td>
                              <h5><?php echo $alamat ?></h5>
                            </td>
                          </tr>
                          <tr>
                            <td>Kategori Kuliner</td>
                            <td>
                              <h5><?php echo $item->nama_kategori ?></h5>
                            </td>
                          </tr>
                          <tr>
                            <td>Kontak Resto</td>
                            <td>
                              <?php if (!empty($nomor)) : ?>
                                <h4><a class="btn btn-sm btn-primary" href="https://wa.me/<?php echo $nomor ?>?text=Halo%20saya%20butuh%20informasi%20lebih%20lanjut" target="_blank">Chat Whatsapp &nbsp;&nbsp;<i class="fa fa-whatsapp"></i></a></h4>
                              <?php else : ?>
                                <h5>Tidak ada kontak resto</h5>
                              <?php endif; ?>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5" data-aos="zoom-in">
                    <div class="panel panel-info panel-dashboard">
                      <div class="panel-heading centered">
                        <h2 class="panel-title"><strong>Lokasi</strong></h2>
                        <h5 id="distance-info"></h5>
                      </div>
                      <div class="panel-body">
                        <div id="map-canvas" style="width:100%;height:300px;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12" data-aos="fade-up" data-aos-delay="200">
                            <?php
                            if (!empty($foto)) {
                                echo "<img src='admin/assets/img/{$foto}' alt='{$nama_wisata}' style='max-width: 300px; max-height: 300px;' />";
                            } else {
                                echo "Tidak ada foto.";
                            }
                            ?>
                  </div>
                </div>
              </div>
            </section>
          </section>
          <!-- End about-info Area -->
        </main>
        <!-- Sertakan pustaka Leaflet.js -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script>
          var map = L.map('map-canvas').setView([<?php echo $lat ?>, <?php echo $long ?>], 16);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);

          // Tambahkan marker jika terdapat koordinat
            <?php if (!empty($lat) && !empty($long)) : ?>
              var marker = L.marker([<?php echo $lat ?>, <?php echo $long ?>]).addTo(map)
                .bindPopup('<h5><?php echo $nama_wisata ?></h5><div class="navigation-buttons"><button onclick="openGoogleMaps()">Open GMaps</button></div>', {
                maxWidth: 'auto'  // Set maxWidth to 'auto' for responsive sizing
            });

            function openGoogleMaps() {
                var address = "<?php echo urlencode($alamat); ?>";
                window.open('https://www.google.com/maps?q=' + address, '_blank');
            }

              //function openGojek() {
              //  window.open('https://www.gojek.com', '_blank');
              //}

              //function openGrab() {
              //  window.open('https://www.grab.com', '_blank');
              //}
              marker.openPopup();
          <?php endif; ?>

          // Fungsi untuk menghitung jarak antara dua titik koordinat
          function calculateDistance(lat1, lon1, lat2, lon2) {
            var R = 6371; // Radius bumi dalam kilometer
            var dLat = (lat2 - lat1) * (Math.PI / 180);
            var dLon = (lon2 - lon1) * (Math.PI / 180);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c; // Jarak dalam kilometer
            return distance.toFixed(2);
          }

          // Dapatkan koordinat lokasi pengguna
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
              var userLat = position.coords.latitude;
              var userLon = position.coords.longitude;

              // Hitung jarak dan tampilkan informasi
              var distance = calculateDistance(userLat, userLon, <?php echo $lat ?>, <?php echo $long ?>);
              document.getElementById('distance-info').innerHTML = 'Jarak dari lokasi Anda: ' + distance + ' km';
            });
          }
        </script>
        <!-- Bagian Footer -->
        <?php include "footer.php"; ?>
