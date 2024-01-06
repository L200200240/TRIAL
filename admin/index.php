<?php
// Memulai sesi PHP
session_start();

// Memeriksa apakah status login sudah diatur dalam sesi
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Jika tidak, redirect ke halaman login dengan pesan tidak login
    header("location:../tampil_data.php?pesan=belum_login");
    exit; // Pastikan untuk keluar setelah me-redirect.
}

// Menggunakan file koneksi.php untuk menghubungkan ke database
include "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php
// Memasukkan file header.php yang mungkin berisi elemen-elemen head HTML
include "header.php";
?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php
        // Memasukkan file menu_sidebar.php yang mungkin berisi sidebar HTML
        include "menu_sidebar.php";
        ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php
                // Memasukkan file menu_topbar.php yang mungkin berisi topbar HTML
                include "menu_topbar.php";
                ?>
                <center><img src="img/logo1.png" alt="Surakarta" width="150px"> </center>
                <br>
                <h2>
                    <center><b>SISTEM INFORMASI GEOGRAFIS </b> </center>
                </h2>
                <h2>
                    <center><b>OBJEK WISATA KABUPATEN SURAKARTA </b> </center>
                </h2>
                <h2>
                    <center><a href="../index.php"><button class="btn btn-primary" type="button">Lihat Web</button></a></center>
                </h2>
            </div>
            <!-- End of Main Content -->
            <?php
            // Memasukkan file footer.php yang mungkin berisi elemen footer HTML
            include "footer.php";
            ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>

</html>
