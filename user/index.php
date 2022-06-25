<!-- koneksi -->
<?php

    // session
    session_start();

    if( !isset($_SESSION['login']) ) {
        header("Location: ../index.php");
        exit;
    }
    // session

    include_once('../koneksi.php');
    

    $kriterias = mysqli_query($koneksi, "SELECT * FROM kriteria");
    $alternatifs = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY no_alternatif ASC");

    // query untuk greeting atau ucapan selamat datang di dasboard
    // $ucapan = mysqli_query($koneksi, "SELECT * FROM login WHERE username != 'admin'");
    // foreach($ucapan as $nama) {
    //     var_dump($nama['nama']);
    // }
    // var_dump($namaUser);
    // nama();
    // echo $namaUser;
    $user = $_SESSION['login'];
    // $tampilNamas = mysqli_query($koneksi, "SELECT * FROM login WHERE username='$user");
    // $tampilNama = mysqli_fetch_array($tampilNamas);
    // var_dump($user);
    
?>

<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <!-- <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dasboard</title>

    <!-- library fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

    <!-- data tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    
    <!-- css sendiri -->
    <style>
        .kriteria .tambah-kriteria {
            margin-top: 20px;
        }
        .alternatif .tambah-alternatif {
            margin-top: 20px;
        }
        .kriteria table thead th, .alternatif table th {
            text-align: center;
        }
        .kriteria table tbody a, .alternatif table tbody a, .kriteria .tambah-kriteria, .alternatif .tambah-alternatif {
            font-size: 11px;
        }
        .con {
            padding: 2% 5%;
        }
        .pesan-update {
            font-style: italic;
            font-size: 13px;
        }
        footer {
            margin-top: 20px;
            padding: 20px 100px;
        }
        .footer-copyright {
            padding: 10px 85px;
            text-align: center;
        }
        footer a:hover {
            text-decoration: underline;
        }

        /* data table */
        /* .dataTables_length label {
            height: 100px !important;
        }
        .dataTables_length label select {
            display: block !important;
        } */
        .dataTables_filter, .dataTables_length {
            display: none;
        }
        .sidenav h6 {
            margin: 20px auto;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <div class="navbar-fixed">
        <nav class="grey darken-2">
            <div class="nav-wrapper container">
                <a href="#" class="brand-logo">SPK Reksa Dana Obligasi</a>
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li class="active"><a href="index.php">dasboard</a></li>
                    <li><a href="hasilRangkingUser.php">hasil perangkingan</a></li>
                    <li><a href="dataHistoryUser.php">data history</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- navbar -->


    <!-- sidenav -->
    <ul id="slide-out" class="sidenav">
        <!-- <li><h6 class="center">SPK Reksa Dana Obligasi</h6></li> -->
        <li><h6 class="center"> Hi, <?= $user ?></h6></li>
        <li class="active"><a href="index.php">Dasboard</a></li>
        <li><a href="hasilRangkingUser.php">Hasil Perangkingan</a></li>
        <li><a href="dataHistoryUser.php">Data History</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
    <!-- sidenav -->


    <!-- welcome -->
    <div class="row container ucapanSelamat">
        <div class="col">
            <h4>Selamat Datang, <span><?= $user ?></span>!</h3>
            <hr>
        </div>
    </div>
    <!-- welcome -->


    <!-- tabel kriteria -->
    <div id="kriteria" class="kriteria">
        <div class="container">
            <div class="row">
                <div class="col m9">
                    <h5>Tabel Kriteria</h5>
                </div>
            </div>
            <div class="row">
                <div class="col m12">
                    <table id="tabelKriteria" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kriteria</th>
                                <th>Nama Kriteria</th>
                                <th>Cost/Benefit</th>
                                <th>Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($kriterias as $kriteria) {
                                    echo "
                                    <tr>
                                        <td class='center'>". $kriteria['no_kriteria'] ."</td>
                                        <td>". $kriteria['nama_kriteria'] ."</td>
                                        <td class='center'>". $kriteria['cost_benefit'] ."</td>
                                        <td class='center'>". $kriteria['bobot_kriteria']."</td>
                                    </tr>
                                    
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- tabel kriteria -->

    <hr>
    <!-- tabel alternatif -->
    <div id="alternatif" class="alternatif">
        <div class="con">
            <div class="row">
                <div class="col m9">
                    <h5>Tabel Alternatif</h5>
                </div>
            </div>
            <div class="row">
                <div class="col m12">
                    <table id="tabelAlternatif" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>Nama Produk</th>
                                <!-- pengulangan nama kriteria dari tabel kriteria -->
                                <?php
                                    foreach($kriterias as $kriteria) {
                                        echo "
                                            <th>". $kriteria['nama_kriteria'] ."</th>
                                        ";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($alternatifs as $alternatif) {
                                    echo "
                                    <tr>
                                        <td class='center'>". $alternatif['no_alternatif'] ."</td>
                                        <td>". $alternatif['nama_produk'] ."</td>
                                        <td>". $alternatif['kriteria1'] ."</td>
                                        <td class='center'>". $alternatif['kriteria2']." T</td>
                                        <td class='center'>". $alternatif['kriteria3']."%</td>
                                        <td class='center'>-". $alternatif['kriteria4']."%</td>
                                        <td class='center'>". $alternatif['kriteria5']."%</td>
                                        <td>Rp ". $alternatif['kriteria6']."</td>
                                        <td style='width:150px;'>". round($alternatif['kriteria7'] / 12, 0)." Tahun, ".$alternatif['kriteria7'] % 12 ." Bulan</td>
                                    </tr>
                                    
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <span class="pesan-update">*Data diperbaharui terakhir tanggal 20 Mei 2022</span>
        </div>
    </div>
    <!-- tabel alternatif -->


    <!-- footer -->
    <footer class="grey darken-2 white-text">
        <div class="row">
            <div class="col s7 offset-s1">
                <h6>Riki Widiantoro | Teknik Informatika</h6>
                <p>Website Sistem Pendukung Keputusan Rekomendasi Produk Reksa Dana Obligasi Terbaik dengan Metode Simple Additive Weighting (SAW)</p>
                <!-- <h6>&copy; 2022 | SKRIPSI</h6> -->
            </div>
            <div class="col s2 offset-s1">
                <h6>Kontak Developer :</h6>
                <div class="sosmed">
                    <p>
                        <a href="mailto:rikitoro12@gmail.com?subject=subject text" target="_blank" class="white-text"><i class="fa fa-envelope"></i> rikitoro12@gmail.com</a>
                    </p>
                    <p>
                        <a href="https://github.com/rikiwidiantoro" target="_blank" class="white-text"><i class="fab fa-github"></i> rikiwidiantoro </a>
                    </p>
                    <p>
                        <a href="https://rikiwidiantoro.github.io/" target="_blank" class="white-text"><i class="fas fa-blog"></i> rikiwidiantoro.github.io</a>
                    </p>
                </div>
                
            </div>
        </div>
    </footer>
    <div class="footer-copyright grey darken-3 white-text">
        &copy; 2022 | SKRIPSI
    </div>
    <!-- footer -->


    <!--JavaScript at end of body for optimized loading-->
    <!-- <script type="text/javascript" src="js/materialize.min.js"></script> -->
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- library jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- library data table -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        // window.addEventListener('load', function() {
        //     let namaUser = prompt('Ketikan nama Anda!');
        //     console.log(namaUser);
            
        // });
        $(document).ready(function() {

            // popup untuk ucapan selamat datang
            // let namaUser = prompt('Ketikan nama Anda!');
            // $('.ucapanSelamat h4 span').html(namaUser);
            

            $('#tabelAlternatif').DataTable({
                // paging: false
                // dom: '<"top"i>rt<"bottom"flp><"clear">',
            });
            $('#tabelKriteria').DataTable({
                // paging: false
            });


            // sidenav
            const sidenav = document.querySelectorAll('.sidenav');
            // inisialisasi
            M.Sidenav.init(sidenav);
        });
    </script>

</body>
</html>

