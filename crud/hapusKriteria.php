<?php

    include_once('../koneksi.php');

    // mengambil data id kriteria
    $id = $_GET['id'];

    // query hapus data
    $hapusKriteria = mysqli_query($koneksi, "DELETE FROM kriteria WHERE id_kriteria = '$id';");

    // alert jika berhasil dihapus maka akan re direct ke halaman dasboard
    if( $hapusKriteria > 0 ) {
        echo "
            <script>
                alert('Data Kriteria berhasil dihapus!');
                document.location.href = '../admin/indexAdmin.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Kriteria gagal dihapus!');
                document.location.href = '../admin/indexAdmin.php';
            </script>
        ";
    }


?>