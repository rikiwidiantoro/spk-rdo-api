<?php

    // session
    session_start();

    if( !isset($_SESSION['login']) ) {
        header("Location: ../index.php");
        exit;
    }
    // session

    include_once('../koneksi.php');

    // mengambil data dari form
    if( isset($_POST['submit']) ) {
        $noAlternatif = $_POST['noAlternatif'];
        $namaProduk = $_POST['namaProduk'];
        $kriteria1 = $_POST['kriteria1'];
        $kriteria2 = $_POST['kriteria2'];
        $kriteria3 = $_POST['kriteria3'];
        $kriteria4 = $_POST['kriteria4'];
        $kriteria5 = $_POST['kriteria5'];
        $kriteria6 = $_POST['kriteria6'];
        $kriteria7 = $_POST['kriteria7'];


        // mengirim data ke database
        $tambahKriteria = mysqli_query($koneksi, "INSERT INTO `alternatif`(`id_alternatif`, `no_alternatif`, `nama_produk`, `kriteria1`, `kriteria2`, `kriteria3`, `kriteria4`, `kriteria5`, `kriteria6`, `kriteria7`) VALUES('', '$noAlternatif', '$namaProduk', '$kriteria1', '$kriteria2', '$kriteria3', '$kriteria4', '$kriteria5', '$kriteria6', '$kriteria7');");

        // alert dan re direct
        echo "<script>alert('Data Alternatif berhasil ditambahkan!'); document.location.href = '../admin/indexAdmin.php';</script>";
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
        <title>Tambah Data Alternatif</title>
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
                <h4>Tambah Alternatif</h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col s6 offset-s3 center">
                <form action="" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Nomor Alternatif</td>
                            <td><input type="text" name="noAlternatif" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td><input type="text" name="namaProduk" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Manajer Investasi</td>
                            <td><input type="text" name="kriteria1" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Total AUM</td>
                            <td><input type="text" name="kriteria2" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>CAGR 1 Tahun</td>
                            <td><input type="text" name="kriteria3" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Drawdown 1 Tahun</td>
                            <td><input type="text" name="kriteria4" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Expense Ratio</td>
                            <td><input type="text" name="kriteria5" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Minimal Pembelian</td>
                            <td><input type="text" name="kriteria6" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Lama Peluncuran</td>
                            <td><input type="text" name="kriteria7" autocomplete="off"></td>
                        </tr>
                    </table>
                    <br>
                    <button class="btn grey darken-2 waves-effect waves-light" type="submit" name="submit">Tambah Data
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
        <!-- form -->
        <br><br>


        <!--JavaScript at end of body for optimized loading-->
        <!-- <script type="text/javascript" src="js/materialize.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </body>
</html>