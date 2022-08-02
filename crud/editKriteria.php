<?php

    // session
    session_start();

    if( !isset($_SESSION['login']) ) {
        header("Location: ../index.php");
        exit;
    }
    // session

    include_once('../koneksi.php');

    // query data dari database
    $id = $_GET['id'];
    $tampilData = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE id_kriteria = '$id';");

    // looping query data
    while( $dataKriteria = mysqli_fetch_array($tampilData) ) {
        $nomor = $dataKriteria['no_kriteria'];
        $nama = $dataKriteria['nama_kriteria'];
        $costBenefit = $dataKriteria['cost_benefit'];
        $bobot = $dataKriteria['bobot_kriteria'];
    }


    // mengambil data dari form
    if( isset($_POST['submit']) ) {
        $id = $_POST['id'];
        $noKriteria = $_POST['noKriteria'];
        $namaKriteria = $_POST['namaKriteria'];
        $costBenefit = $_POST['costBenefit'];
        $bobot = $_POST['bobot'];


        // mengirim data baru ke database
        $editKriteria = mysqli_query($koneksi, "UPDATE kriteria SET no_kriteria = '$noKriteria', nama_kriteria = '$namaKriteria', cost_benefit = '$costBenefit', bobot_kriteria = '$bobot' WHERE id_kriteria = '$id';");

        // alert dan re direct
        echo "<script>alert('Data Kriteria berhasil di edit!'); document.location.href = '../admin/indexAdmin.php';</script>";
    }


?>


<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <!-- <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Edit Data Kriteria</title>

        <link rel="stylesheet" href="../responsive.css">
    </head>

    <body>

        <!-- navbar -->
        <div class="navbar-fixed">
            <nav class="grey darken-2">
                <div class="nav-wrapper container">
                    <a href="../admin/indexAdmin.php"><i class="material-icons left">keyboard_backspace</i>Kembali</a>
                    <a href="#" class="brand-logo center">SPK Reksa Dana Obligasi</a>
                </div>
            </nav>
        </div>
        <!-- navbar -->


        <!-- form -->
        <br>
        <div class="row center">
            <div class="col s4 offset-s4">
                <h4>Edit Kriteria</h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col m6 s10 offset-m3 offset-s1 center">
                <form action="" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>ID</td>
                            <td><input class="grey-text" type="text" name="id" value="<?= $id ?>" autocomplete="off" readonly=""></td>
                        </tr>
                        <tr>
                            <td>Nomor Kriteria</td>
                            <td><input type="text" name="noKriteria" value="<?= $nomor ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Nama Kriteria</td>
                            <td><input type="text" name="namaKriteria" value="<?= $nama ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Cost/Benefit</td>
                            <td><input type="text" name="costBenefit" value="<?= $costBenefit ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Bobot</td>
                            <td><input type="number" name="bobot" value="<?= $bobot ?>" autocomplete="off" min="0" max="100"></td>
                        </tr>
                    </table>
                    <br>
                    <button class="btn grey darken-2 waves-effect waves-light" type="submit" name="submit">Edit Data
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
        <!-- form -->


        <!--JavaScript at end of body for optimized loading-->
        <!-- <script type="text/javascript" src="js/materialize.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </body>
</html>