<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:../index.php');
} else {
    include "../koneksi.php";
?>

    <!DOCTYPE html>
    <html lang="en">

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

                    <?php
                    $id = $_GET['id_wisata'];
                    $query = mysqli_query($koneksi, "select * from wisata where id_wisata='$id'");
                    $data  = mysqli_fetch_array($query);

                    //var_dump($data);
                    ?>

                <?php } ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Detail Wisata <?php echo $data['nama_wisata']; ?></h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Wisata</h6>
                        </div>
                        <div class="card-body">

                            <!-- </div> -->
                            <div class="panel-body">
                                <table id="example" class="table table-hover table-bordered">
                                    <tr>
                                        <td width="250">Nama Wisata</td>
                                        <td width="550"><?php echo $data['nama_wisata']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td><?php echo $data['deskripsi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Latitude</td>
                                        <td><?php echo $data['latitude']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Longitude</td>
                                        <td><?php echo $data['longitude']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td><?php
                                            $id_kategori = $data['fk_id_k'];
                                            $query_kategori = mysqli_query($koneksi, "SELECT nama_kategori FROM kategori WHERE id_kategori='$id_kategori'");
                                            $data_kategori  = mysqli_fetch_array($query_kategori);
                                            echo $data_kategori['nama_kategori'];
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kontak Resto</td>
                                        <td><?php echo $data['nomor']; ?></td>
                                    </tr>
                                    <tr>
                                    <td>Foto</td>
                                    <td>
                                    <?php
                                        $foto = $data['foto']; // Mengambil satu foto saja
                                        if (!empty($foto)) {
                                            echo "<img src='assets/img/{$foto}' alt='' style='max-width: 500px; max-height: 400px; margin-top: 10px;' />";
                                        } else {
                                            echo "Tidak ada foto.";
                                        }
                                    ?>
                                    </td>
                                </tr>
                                </table>
                                <div class="container-fluid">
                                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                        <a href="tampil_data.php" class="btn btn-sm btn-secondary">Kembali</a>
                                    </div>
                                </div>
                            </div>
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