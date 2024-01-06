<?php include "header.php"; ?>

<main id="main">
  <section class="price-area section">
    <section class="about-info-area section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-body">
                <div class="title text-center">
                <h1 class="mb-10">Data Wisata Kuliner</h1></div>
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable">
                    <thead>
                      <tr>
                        <th>NO</th>
                        <th>Nama Wisata</th>
                        <th>Alamat</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      include "koneksi.php"; // Assuming you have a proper connection file

                      $data = file_get_contents('http://localhost/SIG-WISATA/ambildata.php');
                      $no = 1;

                      if (json_decode($data)) {
                        $obj = json_decode($data);

                        foreach ($obj->results as $item) {
                      ?>
                          <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $item->nama_wisata; ?></td>
                            <td><?php echo $item->alamat; ?></td>
                            <td>
                              <?php
                              $kategori_id = $item->fk_id_k;
                              $kategori_result = mysqli_query($koneksi, "SELECT kategori.nama_kategori FROM kategori WHERE id_kategori = $kategori_id");
                              $kategori_data = mysqli_fetch_array($kategori_result);
                              echo $kategori_data['nama_kategori'];
                              ?>
                            </td>
                            <td>
                              <a href="detail.php?id_wisata=<?php echo $item->id_wisata; ?>" class="btn btn-primary">
                                <i class="fa fa-map-marker"></i> Detail dan Lokasi</a>
                            </td>
                          </tr>
                      <?php
                          $no++;
                        }
                      } else {
                        echo "Data tidak ada.";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
</main>

<?php include "footer.php"; ?>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Initialize DataTables -->
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "order": [
        [0, "asc"]
      ], // Default sorting by the first column in ascending order
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data yang ditemukan",
        "info": "Halaman _PAGE_ dari _PAGES_",
        "infoEmpty": "Tidak ada data yang tersedia",
        "infoFiltered": "(disaring dari total _MAX_ data)",
        "paginate": {
          "first": "Pertama",
          "previous": "Sebelumnya",
          "next": "Berikutnya",
          "last": "Terakhir"
        }
      }
    });
  });
</script>
