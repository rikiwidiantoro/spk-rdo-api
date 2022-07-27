<?php

    include_once('../koneksi.php');

    $bobotC1 = 0;
    $bobotC2 = 0;
    $bobotC3 = 0;
    $bobotC4 = 0;
    $bobotC5 = 0;
    $bobotC6 = 0;
    $bobotC7 = 0;

    $updateBobot1 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC1' WHERE no_kriteria = 'C1';");
    $updateBobot2 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC2' WHERE no_kriteria = 'C2';");
    $updateBobot3 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC3' WHERE no_kriteria = 'C3';");
    $updateBobot4 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC4' WHERE no_kriteria = 'C4';");
    $updateBobot5 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC5' WHERE no_kriteria = 'C5';");
    $updateBobot6 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC6' WHERE no_kriteria = 'C6';");
    $updateBobot7 = mysqli_query($koneksi, "UPDATE kriteria SET bobot_kriteria = '$bobotC7' WHERE no_kriteria = 'C7';");

    echo "<script>alert('Data Bobot Kriteria berhasil di Reset!'); document.location.href = '../user/index.php';</script>";
?>
