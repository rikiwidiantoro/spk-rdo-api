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

    // neww
    $bobots = mysqli_query($koneksi, "SELECT bobot_kriteria FROM kriteria");
    


    $bobot = array();
    foreach($bobots as $bo) {
        array_push($bobot, $bo['bobot_kriteria']);
        
    }

    // total bobot
    $totalBobot = $bobot[0] + $bobot[1] + $bobot[2] + $bobot[3] + $bobot[4] + $bobot[5] + $bobot[6];

    
    $nMax = mysqli_query($koneksi, "SELECT max(kriteria1) as maxK1, max(kriteria2) as maxK2, max(kriteria3) as maxK3, max(kriteria7) as maxK7 FROM convert_alternatif");
    $nMin = mysqli_query($koneksi, "SELECT min(kriteria4) as minK4, min(kriteria5) as minK5, min(kriteria6) as minK6 FROM convert_alternatif");
    $max = mysqli_fetch_array($nMax);
    $min = mysqli_fetch_array($nMin);


    // untuk pengkondisian tambah, update t.convert & t.rangking
    $converts = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");
    $r = mysqli_query($koneksi, "SELECT * FROM rangking");
    $ww = mysqli_num_rows($converts);
    $www = mysqli_num_rows($r);
    global $ww;
    global $www;


    // new
    $totalId = 32;
    $joins = mysqli_query($koneksi, "SELECT * FROM fetch_api INNER JOIN alternatif USING (id_api)");
    
    // convert-alternatif
    foreach($joins as $join) {
        // kriteria1 = manajer investasi = x1
        if( $join['mi'] == "Sucorinvest Asset Management, PT" || $join['mi'] == "Trimegah Asset Management, PT" ) {
            $x1 = 5;
        } else if( $join['mi'] == "Sinarmas Asset Management, PT" || $join['mi'] == "Eastspring Investments Indonesia, PT" ) {
            $x1 = 4;
        } else {
            $x1 = 3;
        }

        // kriteria2 = total AUM = x2
        if( $join['aum'] > 1000 ) {
            $x2 = 5;
        } else if( $join['aum'] >= 500.01 && $join['aum'] <= 1000 ) {
            $x2 = 4;
        } else if( $join['aum'] >= 200.01 && $join['aum'] <= 500 ) {
            $x2 = 3;
        } else if( $join['aum'] >= 50 && $join['aum'] <= 200 ) {
            $x2 = 2;
        } else if( $join['aum'] < 50 ) {
            $x2 = 1;
        }

        // kriteria3 = CAGR 1 tahun = x3
        if( $join['cagr'] > 8 ) {
            $x3 = 5;
        } else if( $join['cagr'] >= 6.01 && $join['cagr'] <= 8 ) {
            $x3 = 4;
        } else if( $join['cagr'] >= 4.01 && $join['cagr'] <= 6 ) {
            $x3 = 3;
        } else if( $join['cagr'] >= 2 && $join['cagr'] <= 4 ) {
            $x3 = 2;
        } else if( $join['cagr'] < 2 ) {
            $x3 = 1;
        }

        // kriteria4 = dropdown 1 tahun = x4
        if( $join['drawdown'] < -5 ) {
            $x4 = 1;
        } else if( $join['drawdown'] <= -3.01 && $join['drawdown'] >= -5 ) {
            $x4 = 2;
        } else if( $join['drawdown'] <= -2.01 && $join['drawdown'] >= -3 ) {
            $x4 = 3;
        } else if( $join['drawdown'] <= -1 && $join['drawdown'] >= -2 ) {
            $x4 = 4;
        } else if( $join['drawdown'] <= 0 && $join['drawdown'] > -1 ) {
            $x4 = 5;
        }

        // kriteria5 = expense ratio = x5
        if( $join['expense'] > 2 ) {
            $x5 = 1;
        } else if( $join['expense'] >= 1.51 && $join['expense'] <= 2 ) {
            $x5 = 2;
        } else if( $join['expense'] >= 1.01 && $join['expense'] <= 1.5 ) {
            $x5 = 3;
        } else if( $join['expense'] >= 0.5 && $join['expense'] <= 1 ) {
            $x5 = 4;
        } else if( $join['expense'] < 0.5 ) {
            $x5 = 5;
        }

        // kriteria6 = minimal pembelian = x6
        if( $join['minbuy'] > 5000000 || $join['minbuy'] == 5000 ) {
            $x6 = 2;
        } else if( $join['minbuy'] >= 901000 && $join['minbuy'] <= 5000000 || $join['minbuy'] == 100 ) {
            $x6 = 3;
        } else if( $join['minbuy'] >= 100000 && $join['minbuy'] <= 900000 ) {
            $x6 = 4;
        } else if( $join['minbuy'] < 100000 ) {
            $x6 = 5;
        }

        // kriteria7 = lama peluncuran = x7
        // lama peluncuran
        $tanggal = new DateTime($join['lama_peluncuran']);
        // tanggal hari ini
        $today = new DateTime('today');
        // tahun
        $y = $today->diff($tanggal)->y;
        // bulan
        $m = $today->diff($tanggal)->m;

        $hasilBulan = ($y*12) + $m;

        if( $hasilBulan > 120 ) {
            $x7 = 5;
        } else if( $hasilBulan >= 97 && $hasilBulan <= 120 ) {
            $x7 = 4;
        } else if( $hasilBulan >= 61 && $hasilBulan <= 96 ) {
            $x7 = 3;
        } else if( $hasilBulan >= 24 && $hasilBulan <= 60 ) {
            $x7 = 2;
        } else if( $hasilBulan < 24 ) {
            $x7 = 1;
        }

        // $totalId = 10;
        $iii = $join['id_api']; //id alternatif tabel alternatif
        
        if($totalId == $ww) {
            // echo '1';
            $updateTabelConvert = mysqli_query($koneksi, "UPDATE convert_alternatif SET kriteria1 = '$x1', kriteria2 = '$x2', kriteria3 = '$x3', kriteria4 = '$x4', kriteria5 = '$x5', kriteria6 = '$x6', kriteria7 = '$x7' WHERE id_api = '$iii';");
        } 
    }



    $joinsss = mysqli_query($koneksi, "SELECT * FROM fetch_api INNER JOIN alternatif USING (id_api)");
    // ranking nilai v
    foreach($joinsss as $join) {
        // kriteria1 = manajer investasi = x1
        if( $join['mi'] == "Sucorinvest Asset Management, PT" || $join['mi'] == "Trimegah Asset Management, PT" ) {
            $x1 = 5;
        } else if( $join['mi'] == "Sinarmas Asset Management, PT" || $join['mi'] == "Eastspring Investments Indonesia, PT" ) {
            $x1 = 4;
        } else {
            $x1 = 3;
        }

        // kriteria2 = total AUM = x2
        if( $join['aum'] > 1000 ) {
            $x2 = 5;
        } else if( $join['aum'] >= 500.01 && $join['aum'] <= 1000 ) {
            $x2 = 4;
        } else if( $join['aum'] >= 200.01 && $join['aum'] <= 500 ) {
            $x2 = 3;
        } else if( $join['aum'] >= 50 && $join['aum'] <= 200 ) {
            $x2 = 2;
        } else if( $join['aum'] < 50 ) {
            $x2 = 1;
        }

        // kriteria3 = CAGR 1 tahun = x3
        if( $join['cagr'] > 8 ) {
            $x3 = 5;
        } else if( $join['cagr'] >= 6.01 && $join['cagr'] <= 8 ) {
            $x3 = 4;
        } else if( $join['cagr'] >= 4.01 && $join['cagr'] <= 6 ) {
            $x3 = 3;
        } else if( $join['cagr'] >= 2 && $join['cagr'] <= 4 ) {
            $x3 = 2;
        } else if( $join['cagr'] < 2 ) {
            $x3 = 1;
        }

        // kriteria4 = dropdown 1 tahun = x4
        if( $join['drawdown'] < -5 ) {
            $x4 = 1;
        } else if( $join['drawdown'] <= -3.01 && $join['drawdown'] >= -5 ) {
            $x4 = 2;
        } else if( $join['drawdown'] <= -2.01 && $join['drawdown'] >= -3 ) {
            $x4 = 3;
        } else if( $join['drawdown'] <= -1 && $join['drawdown'] >= -2 ) {
            $x4 = 4;
        } else if( $join['drawdown'] <= 0 && $join['drawdown'] > -1 ) {
            $x4 = 5;
        }

        // kriteria5 = expense ratio = x5
        if( $join['expense'] > 2 ) {
            $x5 = 1;
        } else if( $join['expense'] >= 1.51 && $join['expense'] <= 2 ) {
            $x5 = 2;
        } else if( $join['expense'] >= 1.01 && $join['expense'] <= 1.5 ) {
            $x5 = 3;
        } else if( $join['expense'] >= 0.5 && $join['expense'] <= 1 ) {
            $x5 = 4;
        } else if( $join['expense'] < 0.5 ) {
            $x5 = 5;
        }

        // kriteria6 = minimal pembelian = x6
        if( $join['minbuy'] > 5000000 || $join['minbuy'] == 5000 ) {
            $x6 = 2;
        } else if( $join['minbuy'] >= 901000 && $join['minbuy'] <= 5000000 || $join['minbuy'] == 100 ) {
            $x6 = 3;
        } else if( $join['minbuy'] >= 100000 && $join['minbuy'] <= 900000 ) {
            $x6 = 4;
        } else if( $join['minbuy'] < 100000 ) {
            $x6 = 5;
        }

        // kriteria7 = lama peluncuran = x7
        // lama peluncuran
        $tanggal = new DateTime($join['lama_peluncuran']);
        // tanggal hari ini
        $today = new DateTime('today');
        // tahun
        $y = $today->diff($tanggal)->y;
        // bulan
        $m = $today->diff($tanggal)->m;

        $hasilBulan = ($y*12) + $m;

        if( $hasilBulan > 120 ) {
            $x7 = 5;
        } else if( $hasilBulan >= 97 && $hasilBulan <= 120 ) {
            $x7 = 4;
        } else if( $hasilBulan >= 61 && $hasilBulan <= 96 ) {
            $x7 = 3;
        } else if( $hasilBulan >= 24 && $hasilBulan <= 60 ) {
            $x7 = 2;
        } else if( $hasilBulan < 24 ) {
            $x7 = 1;
        }

        $nilaiPreferensi = round(
            (($x1 / $max['maxK1']) * $bobot[0]) +
            (($x2 / $max['maxK2']) * $bobot[1]) +
            (($x3 / $max['maxK3']) * $bobot[2]) +
            (($min['minK4'] / $x4) * $bobot[3]) +
            (($min['minK5'] / $x5) * $bobot[4]) +
            (($min['minK6'] / $x6) * $bobot[5]) +
            (($x7 / $max['maxK7']) * $bobot[6]),2
        );

        
        $iiii = $join['id_api'];
        // $totalId = 10;
        $no_al = $join['no_alternatif'];
        $namaProduk = $join['namaProduk'];
        $kriteria1 = $join['mi'];
        
        // echo (int)$nilaiPreferensi;

        if($totalId == $www) {
            // echo '1';
            $updateNilaiPreferensi = mysqli_query($koneksi, "UPDATE rangking SET nama_produk = '$namaProduk', no_alternatif = '$no_al', kriteria1 = '$kriteria1', nilai_preferensi = '$nilaiPreferensi' WHERE id_api = '$iiii';");
        }
    }


    $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi + 0 DESC");
    $raking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi + 0 DESC LIMIT 5");


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
    <link rel="stylesheet" href="../responsive.css">
    <style>
        .reload {
            margin-top: 40px;
            margin-right: -50px;
        }
        .ket p {
            margin-top: 35px;
            text-align: right;
        }
        .pesan-update, .ket p {
            font-style: italic;
            font-size: 13px;
        }
        footer {
            margin-top: 100px;
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
        /* @media screen and (min-width: 1024px) {
            .rank-lima table, .hasil-rangking table {
                font-size: 14px;
            }
        }
        @media screen and (min-width: 768px) and (max-width: 1023px) {
            .rank-lima table, .hasil-rangking table {
                font-size: 12px;
            }
        }
        @media screen and (max-width: 767px) {
            .rank-lima table, .hasil-rangking table {
                font-size: 10px;
            }
        } */
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
    <div class="container welcome">
        <div class="row">
            <div class="col">
                <h4>Hasil Perangkingan</h4>
                <hr>
            </div>
            <div class="col m5 s12 offset-m2">
                <div class="row">
                    <div class="col m7 offset-m1 ket">
                        <p>klik refresh 3X untuk hasil perhitungan berdasarkan data terbaru dari Bibit</p>
                    </div>
                    <div class="col m4">
                        <button class="waves-effect right waves-light btn-small grey darken-1 reload" onClick="window.location.reload();"><i class="material-icons left">refresh</i>Refresh Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- welcome -->


    <!-- tombol lihat hasil -->
    <br>
    <div class="hasil">
        <div class="container">
            <div class="row">
                <div class="col m12 s12 center">
                    <a class="waves-effect waves-light btn-small grey darken-1"><i class="material-icons left">keyboard_arrow_down</i><span>Lihat</span> Hasil</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- tombol lihat hasil -->


    <!-- ranking 5 terbaik -->
    <div class="rank-lima">
        <?php if($totalBobot == 100) { ?>
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
                                            <td>". $rank['nilai_preferensi'] ."%</td>
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
        <?php } else { ?>
            <h6 class='center' rowspan='5'><b>Jumlah Bobot pada tabel kriteria harus 100%, Jumlah Bobot saat ini <?= $totalBobot ?>%, <br> Mohon untuk mengubah jumlah bobot menjadi 100%!</b></h6>
        <?php } ?>
    </div>
    <!-- ranking 5 terbaik -->


    <!-- tombol lihat hasil -->
    <br><br>
    <div class="lihat-hasil">
        <div class="container">
            <div class="row">
                <div class="col m12 s12 center">
                    <a class="waves-effect waves-light btn-small grey darken-1 tambah-kriteria"><i class="material-icons left">keyboard_arrow_down</i><span>Lihat</span> Semua Hasil</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- tombol lihat hasil -->


    <!-- rangking -->
    <div class="hasil-rangking">
        <?php if($totalBobot == 100) { ?>
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
                                            <td>". $rank['nilai_preferensi'] ."%</td>
                                            <td>". $i++ ."</td>
                                        </tr>
                                    ";
                                    
                                }
                            ?>
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <span class="pesan-update">*Data up to date karena menggunakan Public API dari Bibit.</span>
        </div>
        <?php } else { ?>
            <h6 class='center' rowspan='5'><b>Jumlah Bobot pada tabel kriteria harus 100%, Jumlah Bobot saat ini <?= $totalBobot ?>%, <br> Mohon untuk mengubah jumlah bobot menjadi 100%!</b></h6>
        <?php } ?>
    </div>
    <!-- rangking -->


    <!-- footer -->
    <footer class="grey darken-2 white-text">
        <div class="row">
            <div class="col l7 m12 s12 offset-l1">
                <h6>Riki Widiantoro | Teknik Informatika</h6>
                <p>Website Sistem Pendukung Keputusan Rekomendasi Produk Reksa Dana Obligasi Terbaik dengan Metode Simple Additive Weighting (SAW)</p>
                <!-- <h6>&copy; 2022 | SKRIPSI</h6> -->
            </div>
            <div class="col l2 m12 s12 offset-l1">
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

