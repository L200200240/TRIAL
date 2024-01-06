<?php include "header.php"; ?>
<!-- Sertakan pustaka Leaflet.js -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- Leaflet Search JS -->
<script src="https://unpkg.com/leaflet-search@2.9.7/dist/leaflet-search.min.js"></script>
<!-- Leaflet Control Layers JS -->
<script src="https://unpkg.com/leaflet-control-layers@1.7.1/dist/leaflet.control-layers.min.js"></script>
<!-- Sertakan pustaka jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Leaflet Legend JS -->
<script src="https://unpkg.com/leaflet-legend@1.0.3/dist/leaflet-legend.min.js"></script>
<!-- Leaflet Routing JS -->
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<!--Geolocation Javascript Library-->
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>

<main id="main">
  <!-- Start about-info Area -->
  <section class="price-area section">
    <!-- Bagian Peta Lokasi Wisata -->
    <section id="peta_wisata" class="about-info-area section">
      <div class="container">
        <!-- Judul Peta Lokasi Wisata -->
        <div class="title text-center">
          <h1 class="mb-10">Peta Lokasi Wisata Kuliner</h1>
          <br>
        </div>
        <div id="map" style="width:100%;height:480px;"></div>
        <script>
        
        // Inisialisasi peta dengan pusat di Kota Surakarta
        var map = L.map('map').setView([-7.565071, 110.825651], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Surakarta'
        }).addTo(map);

        var geoJsonLayer = L.geoJSON().addTo(map);

        // Load data GeoJSON untuk WisKul
        $.getJSON('GIS SOC.geojson', function (data) {
          L.geoJSON(data, {
            style: function (feature) {
              return { fillColor: 'green', color: 'black', weight: 2 };
            },
            onEachFeature: function (feature, layer) {
              layer.bindPopup('<h5>' + feature.properties.name + '</h5>' +
                  '<a href=\"detail.php?id_wisata=' + feature.properties.id_wisata + '\">Detail Wisata</a>');
            }
          }).addTo(geoJsonLayer);
        });

        // Menambahkan fitur pencarian
        var searchControl = new L.Control.Search({
          layer: geoJsonLayer,
          propertyName: 'name',
          marker: false,
          moveToLocation: function (latlng, title, map) {
            map.setView(latlng, 15);
          },
          filterData: function(text, records) {
            // Fungsi ini akan dipanggil saat melakukan pencarian
            // Kirim permintaan ke server untuk mencari data wisata berdasarkan kata kunci
            $.ajax({
              url: 'search.php',
              type: 'GET',
              dataType: 'json',
              data: {
                keyword: text // Menggunakan 'text' sebagai kata kunci pencarian
              },
              success: function(data) {
                // Hapus popup sebelumnya jika ada
                map.closePopup();

                // Tampilkan semua hasil pencarian
                data.features.forEach(function(feature) {
                  var marker = L.geoJSON(feature, {
                    style: function (feature) {
                      return { fillColor: 'green', color: 'black', weight: 2 };
                    },
                    onEachFeature: function (feature, layer) {
                      layer.bindPopup('<h5>' + feature.properties.name + '</h5>' +
                          '<a href=\"detail.php?id_wisata=' + feature.properties.id_wisata + '\">Detail Wisata</a>');
                    }
                  }).addTo(geoJsonLayer);
                });

                // Zoom ke layer GeoJSON
                if (geoJsonLayer.getLayers().length > 0) {
                  map.fitBounds(geoJsonLayer.getBounds());
                }
              }
            });
          }

        });

        searchControl.on('search:locationfound', function (e) {
          e.layer.openPopup();
        });

        map.addControl(searchControl);

        // Menambahkan layer control untuk pilihan peta
        var baseMaps = {
          'Light Mode': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Surakarta'
          }),
          'Dark Mode': L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://stadiamaps.com/">StadiaMaps</a>, &copy; <a href="https://openmaptile s.org/">OpenMapTiles</a>'
          })
          // Tambahkan peta tambahan sesuai kebutuhan
        };

        var overlayMaps = {
          'WisKul': geoJsonLayer,
          //'Jalan': jalanLayer,
          //'Sungai': geoJsonLayer
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);
        
        /*Plugin Geolocation*/
        var locateControl = L.control.locate({
        position: "topleft",
        drawCircle: true,
        follow: true,
        setView: true,
        keepCurrentZoomLevel: false,
        markerStyle: {
            weight: 1,
            opacity: 0.8,
            fillOpacity: 0.8,
        },
        circleStyle:{
            weight: 1,
            clickable: false,
        },
        icon: "fa fa-crosshairs",
        metric: true,
        strings: {
        title: "Click for Your Location",
        outsideMapBoundsMsg: "Not available"
        },
        onLocationError: function(err) {
          console.error("Error getting location:", err.message);
        },
        onLocationOutsideMapBounds: function(context) {
          console.warn("Location outside map bounds:", context.options.strings.outsideMapBoundsMsg);
        }
      }).addTo(map);
        </script>
      </div>
    </section>
  </section>
    <!-- End about-info Area -->
</main>

<!-- Bagian Footer -->
<?php include "footer.php"; ?>