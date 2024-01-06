<!DOCTYPE html>
<html lang="en">
<!-- Script Leaflet dan Control Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<!-- Leaflet.Draggable -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-draggable/dist/leaflet.draggable.css" />
<script src="https://unpkg.com/leaflet-draggable/dist/leaflet.draggable.js"></script>

<?php include "header.php"; ?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "menu_sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include "menu_topbar.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tambah Data Tempat Wisata</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
                        </div>
                        <div class="card-body">

                            <!-- Main content -->
                            <form class="form-horizontal style-form" style="margin-top: 10px;" action="tambah_aksi.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Nama Wisata</label>
                                    <div class="col-sm-6">
                                        <input name="nama_wisata" type="text" class="form-control" placeholder="Nama Wisata" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Deskripsi</label>
                                    <div class="col-sm-6">
                                        <input name="deskripsi" class="form-control" type="text" placeholder="Deskripsi" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Alamat</label>
                                    <div class="col-sm-6">
                                        <input name="alamat" class="form-control" type="text" placeholder="Alamat" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Latitude</label>
                                    <div class="col-sm-6">
                                        <input name="latitude" id="latitude" class="form-control" type="text" placeholder="-7.3811577" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Longitude</label>
                                    <div class="col-sm-6">
                                        <input name="longitude" id="longitude" class="form-control" type="text" placeholder="109.2550945" required />
                                    </div>
                                </div>
                                <div id="map" style="height: 300px; margin-bottom: 20px;"></div>

                                <script>
                                    var map = L.map('map').setView([-7.565071, 110.825651], 16);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                                    // Inisialisasi marker dengan opsi draggable
                                    var marker = L.marker([-7.565071, 110.825651], { draggable: 'true' }).addTo(map);

                                    var geocoder = L.Control.geocoder({
                                        geocoder: L.Control.Geocoder.nominatim()
                                    }).addTo(map);

                                    // Menangkap hasil geokoding dan mengisi input latitude dan longitude
                                    geocoder.on('markgeocode', function (e) {
                                        var latlng = e.geocode.center;
                                        document.getElementById('latitude').value = latlng.lat;
                                        document.getElementById('longitude').value = latlng.lng;

                                        // Mengatur posisi marker sesuai dengan hasil geokoding
                                        marker.setLatLng(latlng);
                                    });

                                    // Menangkap perubahan posisi marker setelah digeser
                                    marker.on('dragend', function (event) {
                                        var marker = event.target;
                                        var position = marker.getLatLng();

                                        // Mengisi input latitude dan longitude setelah marker digeser
                                        document.getElementById('latitude').value = position.lat;
                                        document.getElementById('longitude').value = position.lng;
                                    });

                                    // Menangkap klik pada peta untuk menempatkan marker
                                    map.on('click', function (e) {
                                        var clickedLatLng = e.latlng;

                                        // Mengatur posisi marker sesuai dengan lokasi yang diklik
                                        marker.setLatLng(clickedLatLng);

                                        // Mengisi input latitude dan longitude sesuai dengan lokasi yang diklik
                                        document.getElementById('latitude').value = clickedLatLng.lat;
                                        document.getElementById('longitude').value = clickedLatLng.lng;
                                    });
                                </script>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Kategori</label>
                                    <div class="col-sm-6">
                                        <!-- Ganti input teks dengan dropdown -->
                                        <select name="fk_id_k" class="form-control" required>
                                            <option value="101">Rumah Makan</option>
                                            <option value="102">Restoran</option>
                                            <option value="103">Warung Makan</option>
                                            <option value="104">Cafe</option>
                                            <option value="105">Coffee Shop</option>
                                            <!-- Tambahkan opsi sesuai dengan kategori yang ada -->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Kontak Resto</label>
                                    <div class="col-sm-6">
                                        <input name="nomor" class="form-control" type="text" placeholder="+6281234567890"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-4 control-label">Foto</label>
                                    <div class="col-sm-6">
                                        <input name="foto" type="file" accept="image/jpeg, image/jpg, image/png" class="form-control-file" />
                                        <small class="form-text text-danger">File harus dalam format jpg, jpeg, atau png.</small>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label class="col-sm-2 col-sm-4 control-label"></label>
                                    <div class="col-sm-8">
                                        <input type="submit" value="Simpan" class="btn btn-sm btn-primary" />
                                    </div>
                                </div>
                                <div style="margin-top: 20px;"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <?php include "footer.php"; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>

</html>
