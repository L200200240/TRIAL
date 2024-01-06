<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@1.15.1/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder@1.15.1/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-draggable@1.0.5/dist/leaflet.draggable.css" />
<script src="https://unpkg.com/leaflet-draggable@1.0.5/dist/leaflet.draggable.js"></script>
<!-- Add the Leaflet Control Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

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
                        <h1 class="h3 mb-0 text-gray-800">Edit Data Tempat Wisata</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
                        </div>
                        <div class="card-body">

                            <?php
                            include '../koneksi.php';
                            $id = $_GET['id_wisata'];
                            $query = mysqli_query($koneksi, "select * from wisata where id_wisata='$id'");
                            $data  = mysqli_fetch_array($query);
                            ?>

                            <!-- Form Edit Data -->
                            <div class="panel-body">
                                <form class="form-horizontal style-form" style="margin-top: 20px;" action="edit_aksi.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validateForm();">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">ID Wisata</label>
                                        <div class="col-sm-8">
                                            <input name="id_wisata" type="text" id="id_wisata" class="form-control" value="<?php echo $data['id_wisata']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Nama Wisata</label>
                                        <div class="col-sm-8">
                                            <input name="nama_wisata" type="text" id="nama_wisata" class="form-control" value="<?php echo $data['nama_wisata']; ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Deskripsi</label>
                                        <div class="col-sm-8">
                                            <input name="deskripsi" class="form-control" id="deskripsi" type="text" value="<?php echo $data['deskripsi']; ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Alamat</label>
                                        <div class="col-sm-8">
                                            <input name="alamat" class="form-control" id="alamat" type="text" value="<?php echo $data['alamat']; ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Latitude</label>
                                        <div class="col-sm-8">
                                        <input name="latitude" class="form-control" id="latitude" type="text" value="<?php echo $data['latitude']; ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Longitude</label>
                                        <div class="col-sm-8">
                                        <input name="longitude" class="form-control" id="longitude" type="text" value="<?php echo $data['longitude']; ?>" required />
                                        </div>
                                    </div>
                                    <div id="map" style="height: 400px;"></div>
                                    <script>
                                        var initialLatitude = <?php echo $data['latitude']; ?>;
                                        var initialLongitude = <?php echo $data['longitude']; ?>;

                                        var map = L.map('map').setView([initialLatitude, initialLongitude], 16);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                                        // Initialize marker with draggable option
                                        var marker = L.marker([initialLatitude, initialLongitude], { draggable: 'true' }).addTo(map);

                                        // Function to update inputs when marker is dragged
                                        function updateMarkerPosition(event) {
                                            var marker = event.target;
                                            var position = marker.getLatLng();

                                            document.getElementById('latitude').value = position.lat;
                                            document.getElementById('longitude').value = position.lng;
                                        }

                                        // Capture marker position changes after dragging
                                        marker.on('dragend', function (event) {
                                            updateMarkerPosition(event);
                                        });

                                        // Capture clicks on the map to place the marker
                                        map.on('click', function (e) {
                                            var clickedLatLng = e.latlng;

                                            marker.setLatLng(clickedLatLng);
                                            updateMarkerPosition({ target: marker }); // Manually call the update function
                                        });
                                    </script>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-4 control-label">Kategori</label>
                                        <div class="col-sm-6">
                                            <!-- Ganti input teks dengan dropdown -->
                                            <select name="fk_id_k" class="form-control" required>
                                            <option value="101" <?php echo ($data['fk_id_k'] == 101) ? 'selected' : ''; ?>>Rumah Makan</option>
                                            <option value="102" <?php echo ($data['fk_id_k'] == 102) ? 'selected' : ''; ?>>Restoran</option>
                                            <option value="103" <?php echo ($data['fk_id_k'] == 103) ? 'selected' : ''; ?>>Warung Makan</option>
                                            <option value="104" <?php echo ($data['fk_id_k'] == 104) ? 'selected' : ''; ?>>Cafe</option>
                                            <option value="105" <?php echo ($data['fk_id_k'] == 105) ? 'selected' : ''; ?>>Coffee Shop</option>
                                                <!-- Tambahkan opsi sesuai dengan kategori yang ada -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Kontak Resto</label>
                                        <div class="col-sm-8">
                                            <input name="nomor" class="form-control" id="nomor" type="text" value="<?php echo $data['nomor']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Foto</label>
                                        <div class="col-sm-8">
                                            <!-- Input file untuk foto -->
                                            <input name="foto" type="file" accept="image/jpeg, image/jpg, image/png" class="form-control-file" id="foto" />
                                            <small class="form-text text-danger">File harus dalam format jpg, jpeg, atau png.</small>
                                            <?php
                                            // Menampilkan foto lama dan pilihan untuk menghapus
                                            $fotoLama = isset($data['foto']) ? $data['foto'] : '';

                                            if (!empty($fotoLama)) {
                                                echo "<div>";
                                                echo "<img src='assets/img/$fotoLama' alt='' style='max-width: 400px; max-height: 400px; margin-top: 10px;' />";
                                                echo "<input type='checkbox' name='hapus_foto' value='1' id='hapus_foto'> Ganti";
                                                echo "</div>";
                                            } else {
                                                echo "<p>Tidak ada foto.</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label class="col-sm-2 col-sm-2 control-label"></label>
                                        <div class="col-sm-8">
                                            <input type="submit" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
                                            <a href="tampil_data.php" class="btn btn-sm btn-danger">Batal</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- End Form Edit Data -->

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
    <script>
    function validateForm() {
        var checkbox = document.getElementById("hapus_foto");
        var fotoInput = document.getElementById("foto");

        // Jika checkbox tidak dicentang dan input file terisi
        if (!checkbox.checked && fotoInput.files.length > 0) {
            console.log("Alert: Anda harus mencentang 'Ganti' jika ingin mengganti foto.");
            alert("Anda harus mencentang 'Ganti' jika ingin mengganti foto.");
            return false;
        }

        return true;
    }
    </script>

</body>

</html>
