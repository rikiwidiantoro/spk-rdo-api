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
        $tahun = $_POST['tahun'];
        $bulan = $_POST['bulan'];
        $dataAlternatif = uploadAlternatif();
        $dataRanking = uploadRanking();
        


        // mengirim data ke database
        $tambahHistory = mysqli_query($koneksi, "INSERT INTO `data_history`(`id_history`, `tahun`, `bulan`, `data_alternatif`, `data_ranking`) VALUES('', '$tahun', '$bulan', '$dataAlternatif', '$dataRanking');");

        // alert dan re direct
        echo "<script>alert('Data History berhasil ditambahkan!'); document.location.href = '../admin/dataHistoryAdmin.php';</script>";
    }

    function uploadAlternatif() {
        $namaFile = $_FILES['dataAlternatif']['name'];
        $ukuranFile = $_FILES['dataAlternatif']['size'];
        $error = $_FILES['dataAlternatif']['error'];
        $tmpName = $_FILES['dataAlternatif']['tmp_name'];

        // cek apakah tidak ada file yang diupload
        if( $error === 4 ) {
            echo "
                    <script>
                        alert('pilih file terlebih dahulu!');
                    </script>
                ";
            return false;
        }

        // cek yang diupload apakah file atau bukan
        $ekstensiFileValid = ['pdf'];
        $ekstensiFile = explode('.', $namaFile);
        $ekstensiFile = strtolower(end($ekstensiFile));

        if( !in_array($ekstensiFile, $ekstensiFileValid) ) {
            echo "
                    <script>
                        alert('yang Anda upload bukan file pdf!');
                    </script>
                ";
        }

        // cek jika ukuran file-nya terlalu besar
        if( $ukuranFile > 100000 ) { // maks 100kb
            echo "
                    <script>
                        alert('ukuran file terlalu besar!');
                    </script>
                ";
        }

        // lolos pengecekan, file siap diupload
        // generate nama file baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiFile;
        
        move_uploaded_file($tmpName, '../laporan/data/2022/' . $namaFileBaru);
        return $namaFileBaru;
    }
    function uploadRanking() {
        $namaFile = $_FILES['dataRanking']['name'];
        $ukuranFile = $_FILES['dataRanking']['size'];
        $error = $_FILES['dataRanking']['error'];
        $tmpName = $_FILES['dataRanking']['tmp_name'];

        // cek apakah tidak ada file yang diupload
        if( $error === 4 ) {
            echo "
                    <script>
                        alert('pilih file terlebih dahulu!');
                    </script>
                ";
            return false;
        }

        // cek yang diupload apakah file atau bukan
        $ekstensiFileValid = ['pdf'];
        $ekstensiFile = explode('.', $namaFile);
        $ekstensiFile = strtolower(end($ekstensiFile));

        if( !in_array($ekstensiFile, $ekstensiFileValid) ) {
            echo "
                    <script>
                        alert('yang Anda upload bukan file pdf!');
                    </script>
                ";
        }

        // cek jika ukuran file-nya terlalu besar
        if( $ukuranFile > 100000 ) { // maks 100kb
            echo "
                    <script>
                        alert('ukuran file terlalu besar!');
                    </script>
                ";
        }

        // lolos pengecekan, file siap diupload
        // generate nama file baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiFile;
        
        move_uploaded_file($tmpName, '../laporan/data/2022/' . $namaFileBaru);
        return $namaFileBaru;
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
        <title>Tambah Data History</title>
        <link rel="stylesheet" href="../responsive.css">
    </head>

    <body>

        <!-- navbar -->
        <div class="navbar-fixed">
            <nav class="grey darken-2">
                <div class="nav-wrapper container">
                    <a href="../admin/dataHistoryAdmin.php"><i class="material-icons left">keyboard_backspace</i>Kembali</a>
                    <a href="#" class="brand-logo center">SPK Reksa Dana Obligasi</a>
                </div>
            </nav>
        </div>
        <!-- navbar -->


        <!-- form -->
        <br>
        <div class="row center">
            <div class="col m4 s10 offset-m4">
                <h4>Tambah Data History</h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col m6 s10 offset-m3 center">
                <form action="" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Tahun</td>
                            <td><input type="text" name="tahun" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td><input type="text" name="bulan" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Data Alternatif</td>
                            <td><input type="file" name="dataAlternatif" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Data Ranking</td>
                            <td><input type="file" name="dataRanking" autocomplete="off"></td>
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