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
    $tampilData = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif = '$id';");

    // looping query data
    while( $dataAlternatif = mysqli_fetch_array($tampilData) ) {
        $nomor = $dataAlternatif['no_alternatif'];
        $nama = $dataAlternatif['nama_produk'];
        $kriteria1 = $dataAlternatif['kriteria1'];
        $kriteria2 = $dataAlternatif['kriteria2'];
        $kriteria3 = $dataAlternatif['kriteria3'];
        $kriteria4 = $dataAlternatif['kriteria4'];
        $kriteria5 = $dataAlternatif['kriteria5'];
        $kriteria6 = $dataAlternatif['kriteria6'];
        $kriteria7 = $dataAlternatif['kriteria7'];
    }


    // mengambil data dari form
    if( isset($_POST['submit']) ) {
        $id = $_POST['id'];
        $noAlternatif = $_POST['noAlternatif'];
        $namaProduk = $_POST['namaProduk'];
        $kriteria1 = $_POST['kriteria1'];
        $kriteria2 = $_POST['kriteria2'];
        $kriteria3 = $_POST['kriteria3'];
        $kriteria4 = $_POST['kriteria4'];
        $kriteria5 = $_POST['kriteria5'];
        $kriteria6 = $_POST['kriteria6'];
        $kriteria7 = $_POST['kriteria7'];


        // mengirim data baru ke database
        $editKriteria = mysqli_query($koneksi, "UPDATE alternatif SET no_alternatif = '$noAlternatif', nama_produk = '$namaProduk', kriteria1 = '$kriteria1', kriteria2 = '$kriteria2', kriteria3 = '$kriteria3', kriteria4 = '$kriteria4', kriteria5 = '$kriteria5', kriteria6 = '$kriteria6', kriteria7 = '$kriteria7' WHERE id_alternatif = '$id';");

        // alert dan re direct
        echo "<script>alert('Data Alternatif berhasil di edit!'); document.location.href = '../admin/indexAdmin.php';</script>";
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
                <h4>Edit Alternatif</h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col s6 offset-s3 center">
                <form action="" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>ID</td>
                            <td><input class="grey-text" type="text" name="id" value="<?= $id ?>" autocomplete="off" readonly=""></td>
                        </tr>
                        <tr>
                            <td>Nomor Alternatif</td>
                            <td><input type="text" name="noAlternatif" value="<?= $nomor ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td><input type="text" name="namaProduk" value="<?= $nama ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Manajer Investasi</td>
                            <td><input type="text" name="kriteria1" value="<?= $kriteria1 ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Total AUM</td>
                            <td><input type="text" name="kriteria2" value="<?= $kriteria2 ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>CAGR 1 Tahun</td>
                            <td><input type="text" name="kriteria3" value="<?= $kriteria3 ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Drawdown 1 Tahun</td>
                            <td><input type="text" name="kriteria4" value="<?= $kriteria4 ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Expense Ratio</td>
                            <td><input type="text" name="kriteria5" value="<?= $kriteria5 ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Minimal Pembelian</td>
                            <td><input type="text" name="kriteria6" value="<?= $kriteria6 ?>" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Lama Peluncuran</td>
                            <td><input type="text" name="kriteria7" value="<?= $kriteria7 ?>" autocomplete="off"></td>
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