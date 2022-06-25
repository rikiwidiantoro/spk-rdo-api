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
    // $kriterias = mysqli_query($koneksi, "SELECT * FROM kriteria");
    // $alternatifs = mysqli_query($koneksi, "SELECT * FROM alternatif");
    // $converts = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");

    // $convertss = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");
    // $convertsss = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");

    // $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC");
    

    // untuk pengkondisian tambah, update t.convert & t.rangking
    // $r = mysqli_query($koneksi, "SELECT * FROM rangking");
    // $w = mysqli_num_rows($alternatifs);
    // $ww = mysqli_num_rows($converts);
    // $www = mysqli_num_rows($r);
    // global $w;
    // global $ww;
    // global $www;


    $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC");
    $raking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC LIMIT 5");
    // $noo = mysqli_query($koneksi, "SELECT no_alternatif as no_al_rank FROM rangking");
    // $noa = mysqli_fetch_array($noo);

    
    // $bobot = [20,20,15,10,10,10,15];
    // $bobots = mysqli_query($koneksi, "SELECT bobot_kriteria");
    // echo $bobots;

    // $nMax = mysqli_query($koneksi, "SELECT max(kriteria1) as maxK1, max(kriteria2) as maxK2, max(kriteria3) as maxK3, max(kriteria7) as maxK7 FROM convert_alternatif");
    // $nMin = mysqli_query($koneksi, "SELECT min(kriteria4) as minK4, min(kriteria5) as minK5, min(kriteria6) as minK6 FROM convert_alternatif");
    // $max = mysqli_fetch_array($nMax);
    // $min = mysqli_fetch_array($nMin);

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
    <title>Hasil Perangkingan</title>

    <!-- css sendiri -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
        .pesan-update {
            font-style: italic;
            font-size: 13px;
        }
        footer {
            margin-top: 100px;
            padding: 20px 100px;
        }
        .footer-copyright {
            padding: 10px 85px;
            text-align: center;
        }
        footer a:hover {
            text-decoration: underline;
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
                    <li><a href="index.php">dasboard</a></li>
                    <li class="active"><a href="hasilRangkingUser.php">hasil perangkingan</a></li>
                    <li><a href="dataHistoryUser.php">data history</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- navbar -->


    <!-- sidenav -->
    <ul id="slide-out" class="sidenav">
        <li><h6 class="center">SPK Reksa Dana Obligasi</h6></li>
        <li><a href="index.php">Dasboard</a></li>
        <li class="active"><a href="hasilRangkingUser.php">Hasil Perangkingan</a></li>
        <li><a href="dataHistoryUser.php">Data History</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
    <!-- sidenav -->


    <!-- welcome -->
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Hasil Perangkingan</h4>
                <hr>
            </div>
        </div>
    </div>
    <!-- welcome -->


    <!-- tombol lihat hasil -->
    <br>
    <div class="hasil">
        <div class="container">
            <div class="row">
                <div class="col m12 center">
                    <a class="waves-effect waves-light btn-small grey darken-1"><i class="material-icons left">keyboard_arrow_down</i><span>Lihat</span> Hasil</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- tombol lihat hasil -->


    <!-- ranking 5 terbaik -->
    <div class="rank-lima">
        <div class="container">
            <div class="row">
                <div class="col m12">
                    <table>
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <!-- pengulangan nama kriteria dari tabel kriteria -->
                                <th>Nama Produk</th>
                                <th>Manajer Investasi</th>
                                <th>Nilai Preferensi</th>
                                <th>Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // $raking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC && ORDER BY nilai_preferensi LIMIT 5");
                                $j = 1;
                                foreach($raking as $rank) {
                                    echo "
                                        <tr>
                                            <td><b>". $rank['no_alternatif'] ."</b></td>
                                            <td>". $rank['nama_produk'] ."</td>
                                            <td>". $rank['kriteria1'] ."</td>
                                            <td>". $rank['nilai_preferensi'] ."</td>
                                            <td>". $j++ ."</td>
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
    <!-- ranking 5 terbaik -->


    <!-- tombol lihat hasil -->
    <br><br>
    <div class="lihat-hasil">
        <div class="container">
            <div class="row">
                <div class="col m12 center">
                    <a class="waves-effect waves-light btn-small grey darken-1 tambah-kriteria"><i class="material-icons left">keyboard_arrow_down</i><span>Lihat</span> Semua Hasil</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- tombol lihat hasil -->


    <!-- rangking -->
    <div class="hasil-rangking">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="../laporan/cetak.php" target="_blank" class="waves-effect waves-light btn-small grey darken-1 cetak"><i class="material-icons left">print</i>Cetak Hasil</a>
                </div>
            </div>
            <div class="row">
                <div class="col m12">
                    <table>
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <!-- pengulangan nama kriteria dari tabel kriteria -->
                                <th>Nama Produk</th>
                                <th>Manajer Investasi</th>
                                <th>Nilai Preferensi</th>
                                <th>Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC");
                                $i = 1;
                                foreach($rangking as $rank) {
                                    // for($i=1; $i<5;$i++) {
                                    //     global $i;
                                    // }
                                    // $i++;

                                    echo "
                                        <tr>
                                            <td><b>". $rank['no_alternatif'] ."</b></td>
                                            <td>". $rank['nama_produk'] ."</td>
                                            <td>". $rank['kriteria1'] ."</td>
                                            <td>". $rank['nilai_preferensi'] ."</td>
                                            <td>". $i++ ."</td>
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
    <!-- rangking -->


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // sidenav
            const sidenav = document.querySelectorAll('.sidenav');
            // inisialisasi
            M.Sidenav.init(sidenav);


            // display none = awalan kosong lali di klik menampilkan hasil perhitungan
            $('.tabel-perhitungan .matriksX').css('display', 'none');
            $('.tabel-perhitungan .rij').css('display', 'none');
            $('.tabel-perhitungan .nilaiPreferensi').css('display', 'none');

            $('.hasil-rangking').css('display', 'none');

            // $('.lihat-saw').click(function() {
            //     $('.tabel-perhitungan .matriksX').fadeToggle(1000);
            //     $('.tabel-perhitungan .rij').fadeToggle(2000);
            //     $('.tabel-perhitungan .nilaiPreferensi').fadeToggle(3000);

            //     // masih belum bisa
            //     // if(true) {
            //     //     $('.lihat-saw span').html("Sembunyikan");
            //     // } else if(true){
            //     //     $('.lihat-saw span').html("Lihat");
            //     // } else {
            //     //     $('.lihat-saw span').html("Sembunyikan");

            //     // }
            // });
            $('.rank-lima').css('display', 'none');
            $('.hasil').click(function() {
                $('.rank-lima').fadeIn(2000);
                $('.hasil span').html('');
            });
            $('.lihat-hasil').click(function() {
                $('.hasil-rangking').fadeToggle(2000);

                // masih belum bisa
                // if(true) {
                //     $('.lihat-hasil span').html("Sembunyikan");
                //     $('.solusi').css('display', 'none');
                // } else {
                //     $('.lihat-hasil span').html("Lihat");
                // }

                $('.lihat-hasil span').fadeToggle(1000);
            });
        })
    </script>

</body>
</html>

