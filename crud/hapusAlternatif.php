<?php

    include_once('../koneksi.php');

    // mengambil data id kriteria
    $id = $_GET['id'];

    // query hapus data
    $hapusAlternatif = mysqli_query($koneksi, "DELETE FROM alternatif WHERE id_alternatif = '$id';");

    // alert jika berhasil dihapus maka akan re direct ke halaman dasboard
    if( $hapusAlternatif > 0 ) {
    
        echo "
            <script>
                alert('Data Alternatif berhasil dihapus!');
                document.location.href = '../admin/indexAdmin.php';
            </script>
        ";
    
    } else {
        echo "
            <script>
                alert('Data Alternatif gagal dihapus!');
                document.location.href = '../admin/indexAdmin.php';
            </script>
        ";
    }


?>