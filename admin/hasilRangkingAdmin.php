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
    $alternatifs = mysqli_query($koneksi, "SELECT * FROM alternatif");
    $converts = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");

    $convertss = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");
    $convertsss = mysqli_query($koneksi, "SELECT * FROM convert_alternatif");

    // $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC");
    

    // untuk pengkondisian tambah, update t.convert & t.rangking
    $r = mysqli_query($koneksi, "SELECT * FROM rangking");
    $w = mysqli_num_rows($alternatifs);
    $ww = mysqli_num_rows($converts);
    $www = mysqli_num_rows($r);
    global $w;
    global $ww;
    global $www;


    $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC");
    // $noo = mysqli_query($koneksi, "SELECT no_alternatif as no_al_rank FROM rangking");
    // $noa = mysqli_fetch_array($noo);

    $bobots = mysqli_query($koneksi, "SELECT bobot_kriteria FROM kriteria");
    // $bb = mysqli_fetch_array($bobots);
    // var_dump($bb[1]);
    // echo $bobots;
    // var_dump($bb[5]);


    $bobot = array();
    foreach($bobots as $bo) {
        // var_dump($bo['bobot_kriteria']);
        // $bbot = $bo['bobot_kriteria'];
        // echo $bbot . '<br>';

        array_push($bobot, $bo['bobot_kriteria']);
        
    }
    // echo $bobot[0] . '<br>';
    // echo $bobot[1] . '<br>';
    // echo $bobot[2] . '<br>';
    // echo $bobot[3] . '<br>';
    // echo $bobot[4] . '<br>';
    // echo $bobot[5] . '<br>';
    // echo $bobot[6] . '<br>';


    
    // $bobot = [20,20,15,10,10,10,15]; // bobot sebelumnya

    $nMax = mysqli_query($koneksi, "SELECT max(kriteria1) as maxK1, max(kriteria2) as maxK2, max(kriteria3) as maxK3, max(kriteria7) as maxK7 FROM convert_alternatif");
    $nMin = mysqli_query($koneksi, "SELECT min(kriteria4) as minK4, min(kriteria5) as minK5, min(kriteria6) as minK6 FROM convert_alternatif");
    $max = mysqli_fetch_array($nMax);
    $min = mysqli_fetch_array($nMin);

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
                    <li><a href="indexAdmin.php">dasboard</a></li>
                    <li class="active"><a href="hasilRangkingAdmin.php">hasil perangkingan</a></li>
                    <li><a href="dataHistoryAdmin.php">data history</a></li>
                    <li><a href="dataPengunjung.php">data pengunjung</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- navbar -->


    <!-- sidenav -->
    <ul id="slide-out" class="sidenav">
        <li><h6 class="center">SPK Reksa Dana Obligasi</h6></li>
        <li><a href="indexAdmin.php">Dasboard</a></li>
        <li class="active"><a href="hasilRangkingAdmin.php">Hasil Perangkingan</a></li>
        <li><a href="dataHistoryAdmin.php">Data History</a></li>
        <li><a href="dataPengunjung.php">Data Pengunjung</a></li>
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
    <div class="lihat-saw">
        <div class="container">
            <div class="row">
                <div class="col m12 center">
                    <a class="waves-effect waves-light btn-small grey darken-1"><i class="material-icons left">keyboard_arrow_down</i><span>Lihat</span> SAW</a>
                </div>
            </div>
        </div>
    </div>
    <!-- tombol lihat hasil -->


    <!-- tabel perhitungan -->
    <div class="tabel-perhitungan">
        <!-- matriks X -->
        <div class="matriksX">
            <div class="container">
                <div class="row">
                    <div class="col m12">
                        <h5>Tabel Matriks X</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col m12">
                        <table>
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    <th>Manajer Investasi</th>
                                    <!-- pengulangan nama kriteria dari tabel kriteria -->
                                    <?php
                                        foreach($kriterias as $kriteria) {
                                            echo "
                                                <th>". $kriteria['no_kriteria'] ."</th>
                                            ";
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($alternatifs as $alternatif) {
                                        // kriteria1 = manajer investasi = x1
                                        if( $alternatif['kriteria1'] == "Sucor Asset Management" || $alternatif['kriteria1'] == "Trimegah Asset Management" ) {
                                            $x1 = 5;
                                        } else if( $alternatif['kriteria1'] == "Asset Management Sinarmas" || $alternatif['kriteria1'] == "Eastpring Investments" ) {
                                            $x1 = 4;
                                        } else {
                                            $x1 = 3;
                                        }
                
                                        // kriteria2 = total AUM = x2
                                        if( $alternatif['kriteria2'] > 1 ) {
                                            $x2 = 5;
                                        } else if( $alternatif['kriteria2'] >= 0.50001 && $alternatif['kriteria2'] <= 1 ) {
                                            $x2 = 4;
                                        } else if( $alternatif['kriteria2'] >= 0.20001 && $alternatif['kriteria2'] <= 0.500 ) {
                                            $x2 = 3;
                                        } else if( $alternatif['kriteria2'] >= 0.050 && $alternatif['kriteria2'] <= 0.200 ) {
                                            $x2 = 2;
                                        } else if( $alternatif['kriteria2'] < 0.050 ) {
                                            $x2 = 1;
                                        }
                
                                        // kriteria3 = CAGR 1 tahun = x3
                                        if( $alternatif['kriteria3'] > 8 ) {
                                            $x3 = 5;
                                        } else if( $alternatif['kriteria3'] >= 6.01 && $alternatif['kriteria3'] <= 8 ) {
                                            $x3 = 4;
                                        } else if( $alternatif['kriteria3'] >= 4.01 && $alternatif['kriteria3'] <= 6 ) {
                                            $x3 = 3;
                                        } else if( $alternatif['kriteria3'] >= 2 && $alternatif['kriteria3'] <= 4 ) {
                                            $x3 = 2;
                                        } else if( $alternatif['kriteria3'] < 2 ) {
                                            $x3 = 1;
                                        }
                
                                        // kriteria4 = dropdown 1 tahun = x4
                                        if( $alternatif['kriteria4'] > 5 ) {
                                            $x4 = 1;
                                        } else if( $alternatif['kriteria4'] >= 3.01 && $alternatif['kriteria4'] <= 5 ) {
                                            $x4 = 2;
                                        } else if( $alternatif['kriteria4'] >= 2.01 && $alternatif['kriteria4'] <= 3 ) {
                                            $x4 = 3;
                                        } else if( $alternatif['kriteria4'] >= 1 && $alternatif['kriteria4'] <= 2 ) {
                                            $x4 = 4;
                                        } else if( $alternatif['kriteria4'] < 1 ) {
                                            $x4 = 5;
                                        }
                
                                        // kriteria5 = expense ratio = x5
                                        if( $alternatif['kriteria5'] > 2 ) {
                                            $x5 = 1;
                                        } else if( $alternatif['kriteria5'] >= 1.51 && $alternatif['kriteria5'] <= 2 ) {
                                            $x5 = 2;
                                        } else if( $alternatif['kriteria5'] >= 1.01 && $alternatif['kriteria5'] <= 1.5 ) {
                                            $x5 = 3;
                                        } else if( $alternatif['kriteria5'] >= 0.5 && $alternatif['kriteria5'] <= 1 ) {
                                            $x5 = 4;
                                        } else if( $alternatif['kriteria5'] < 0.5 ) {
                                            $x5 = 5;
                                        }
                
                                        // kriteria6 = minimal pembelian = x6
                                        if( $alternatif['kriteria6'] > 5000000 ) {
                                            $x6 = 2;
                                        } else if( $alternatif['kriteria6'] >= 901000 && $alternatif['kriteria6'] <= 5000000 ) {
                                            $x6 = 3;
                                        } else if( $alternatif['kriteria6'] >= 100000 && $alternatif['kriteria6'] <= 900000 ) {
                                            $x6 = 4;
                                        } else if( $alternatif['kriteria6'] < 100000 ) {
                                            $x6 = 5;
                                        }
                
                                        // kriteria7 = lama peluncuran = x7
                                        if( $alternatif['kriteria7'] > 120 ) {
                                            $x7 = 5;
                                        } else if( $alternatif['kriteria7'] >= 91 && $alternatif['kriteria7'] <= 120 ) {
                                            $x7 = 4;
                                        } else if( $alternatif['kriteria7'] >= 61 && $alternatif['kriteria7'] <= 96 ) {
                                            $x7 = 3;
                                        } else if( $alternatif['kriteria7'] >= 24 && $alternatif['kriteria7'] <= 60 ) {
                                            $x7 = 2;
                                        } else if( $alternatif['kriteria7'] < 24 ) {
                                            $x7 = 1;
                                        }
                
                
                                        echo "
                                            <tr>
                                                <td><b>". $alternatif['no_alternatif'] ."</b></td>
                                                <td>". $alternatif['kriteria1'] ."</td>
                                                <td>". $x1 ."</td>
                                                <td>". $x2 ."</td>
                                                <td>". $x3 ."</td>
                                                <td>". $x4 ."</td>
                                                <td>". $x5 ."</td>
                                                <td>". $x6 ."</td>
                                                <td>". $x7 ."</td>
                                            </tr>
                                        ";

                                        $iii = $alternatif['no_alternatif']; //id alternatif tabel alternatif
                                        // global $iii;
                                        // while($d = mysqli_fetch_array($conver)) { // id alternatif tabel convert alternatif
                                        //     // echo $d['idd'];
                                        // };
                                        if($w == $ww) {
                                            // echo '1';
                                            $updateTabelConvert = mysqli_query($koneksi, "UPDATE convert_alternatif SET kriteria1 = '$x1', kriteria2 = '$x2', kriteria3 = '$x3', kriteria4 = '$x4', kriteria5 = '$x5', kriteria6 = '$x6', kriteria7 = '$x7' WHERE no_alternatif = '$iii';");
                                        } 
                                        // else if($w > $ww) {
                                        //     $tambahDataTabelConvert = mysqli_query($koneksi, "INSERT INTO `convert_alternatif`(`id_matrik_x`, `no_alternatif`, `kriteria1`, `kriteria2`, `kriteria3`, `kriteria4`, `kriteria5`, `kriteria6`, `kriteria7`) VALUES('', '$iii', '$x1', '$x2', '$x3', '$x4', '$x5', '$x6', '$x7') WHERE no_alternatif = '$iii';");
                                        // }
                                        // else if($w < $ww) {
                                        //     $hapusDataTabelConvert = mysqli_query($koneksi, "DELETE FROM convert_alternatif WHERE no_alternatif = '$iii'");
                                        // }
                                    }
                                    if($w > $ww) {
                                        $tambahDataTabelConvert = mysqli_query($koneksi, "INSERT INTO `convert_alternatif`(`id_matrik_x`, `no_alternatif`, `kriteria1`, `kriteria2`, `kriteria3`, `kriteria4`, `kriteria5`, `kriteria6`, `kriteria7`) VALUES('', '$iii', '$x1', '$x2', '$x3', '$x4', '$x5', '$x6', '$x7');");
                                        //  WHERE no_alternatif = '$iii'
                                    } else if($w < $ww) {
                                        $hapusDataTabelConvert = mysqli_query($koneksi, "DELETE FROM convert_alternatif WHERE no_alternatif = '$iii'");
                                    }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- matriks X -->
        <!-- rij -->
        <br>
        <div class="rij">
            <div class="container">
                <div class="row">
                    <div class="col m12">
                        <h5>Tabel R</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col m12">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <!-- pengulangan nama kriteria dari tabel kriteria -->
                                    <?php
                                        foreach($kriterias as $kriteria) {
                                            echo "
                                                <th>". $kriteria['no_kriteria'] ."</th>
                                            ";
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($alternatifs as $alternatif) {
                                        // kriteria1 = manajer investasi = x1
                                        if( $alternatif['kriteria1'] == "Sucor Asset Management" || $alternatif['kriteria1'] == "Trimegah Asset Management" ) {
                                            $x1 = 5;
                                        } else if( $alternatif['kriteria1'] == "Asset Management Sinarmas" || $alternatif['kriteria1'] == "Eastpring Investments" ) {
                                            $x1 = 4;
                                        } else {
                                            $x1 = 3;
                                        }
                
                                        // kriteria2 = total AUM = x2
                                        if( $alternatif['kriteria2'] > 1 ) {
                                            $x2 = 5;
                                        } else if( $alternatif['kriteria2'] >= 0.50001 && $alternatif['kriteria2'] <= 1 ) {
                                            $x2 = 4;
                                        } else if( $alternatif['kriteria2'] >= 0.20001 && $alternatif['kriteria2'] <= 0.500 ) {
                                            $x2 = 3;
                                        } else if( $alternatif['kriteria2'] >= 0.050 && $alternatif['kriteria2'] <= 0.200 ) {
                                            $x2 = 2;
                                        } else if( $alternatif['kriteria2'] < 0.050 ) {
                                            $x2 = 1;
                                        }
                
                                        // kriteria3 = CAGR 1 tahun = x3
                                        if( $alternatif['kriteria3'] > 8 ) {
                                            $x3 = 5;
                                        } else if( $alternatif['kriteria3'] >= 6.01 && $alternatif['kriteria3'] <= 8 ) {
                                            $x3 = 4;
                                        } else if( $alternatif['kriteria3'] >= 4.01 && $alternatif['kriteria3'] <= 6 ) {
                                            $x3 = 3;
                                        } else if( $alternatif['kriteria3'] >= 2 && $alternatif['kriteria3'] <= 4 ) {
                                            $x3 = 2;
                                        } else if( $alternatif['kriteria3'] < 2 ) {
                                            $x3 = 1;
                                        }
                
                                        // kriteria4 = dropdown 1 tahun = x4
                                        if( $alternatif['kriteria4'] > 5 ) {
                                            $x4 = 1;
                                        } else if( $alternatif['kriteria4'] >= 3.01 && $alternatif['kriteria4'] <= 5 ) {
                                            $x4 = 2;
                                        } else if( $alternatif['kriteria4'] >= 2.01 && $alternatif['kriteria4'] <= 3 ) {
                                            $x4 = 3;
                                        } else if( $alternatif['kriteria4'] >= 1 && $alternatif['kriteria4'] <= 2 ) {
                                            $x4 = 4;
                                        } else if( $alternatif['kriteria4'] < 1 ) {
                                            $x4 = 5;
                                        }
                
                                        // kriteria5 = expense ratio = x5
                                        if( $alternatif['kriteria5'] > 2 ) {
                                            $x5 = 1;
                                        } else if( $alternatif['kriteria5'] >= 1.51 && $alternatif['kriteria5'] <= 2 ) {
                                            $x5 = 2;
                                        } else if( $alternatif['kriteria5'] >= 1.01 && $alternatif['kriteria5'] <= 1.5 ) {
                                            $x5 = 3;
                                        } else if( $alternatif['kriteria5'] >= 0.5 && $alternatif['kriteria5'] <= 1 ) {
                                            $x5 = 4;
                                        } else if( $alternatif['kriteria5'] < 0.5 ) {
                                            $x5 = 5;
                                        }
                
                                        // kriteria6 = minimal pembelian = x6
                                        if( $alternatif['kriteria6'] > 5000000 ) {
                                            $x6 = 2;
                                        } else if( $alternatif['kriteria6'] >= 901000 && $alternatif['kriteria6'] <= 5000000 ) {
                                            $x6 = 3;
                                        } else if( $alternatif['kriteria6'] >= 100000 && $alternatif['kriteria6'] <= 900000 ) {
                                            $x6 = 4;
                                        } else if( $alternatif['kriteria6'] < 100000 ) {
                                            $x6 = 5;
                                        }
                
                                        // kriteria7 = lama peluncuran = x7
                                        if( $alternatif['kriteria7'] > 120 ) {
                                            $x7 = 5;
                                        } else if( $alternatif['kriteria7'] >= 91 && $alternatif['kriteria7'] <= 120 ) {
                                            $x7 = 4;
                                        } else if( $alternatif['kriteria7'] >= 61 && $alternatif['kriteria7'] <= 96 ) {
                                            $x7 = 3;
                                        } else if( $alternatif['kriteria7'] >= 24 && $alternatif['kriteria7'] <= 60 ) {
                                            $x7 = 2;
                                        } else if( $alternatif['kriteria7'] < 24 ) {
                                            $x7 = 1;
                                        }
                                        echo "
                                            <tr>
                                                <td><b>". $alternatif['no_alternatif'] ."</b></td>
                                                <td>". round($x1 / $max['maxK1'],2)  ."</td>
                                                <td>". round($x2 / $max['maxK2'],2)  ."</td>
                                                <td>". round($x3 / $max['maxK3'],2)  ."</td>
                                                <td>". round($min['minK4'] / $x4,2)  ."</td>
                                                <td>". round($min['minK5'] / $x5,2)  ."</td>
                                                <td>". round($min['minK6'] / $x6,2)  ."</td>
                                                <td>". round($x7 / $max['maxK7'],2)  ."</td>
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
        <!-- rij -->
        <!-- rij -->
        <br>
        <div class="nilaiPreferensi">
            <div class="container">
                <div class="row">
                    <div class="col m12">
                        <h5>Tabel V</h5>
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
                                    <th>Nilai Preferensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($alternatifs as $alternatif) {
                                        // kriteria1 = manajer investasi = x1
                                        if( $alternatif['kriteria1'] == "Sucor Asset Management" || $alternatif['kriteria1'] == "Trimegah Asset Management" ) {
                                            $x1 = 5;
                                        } else if( $alternatif['kriteria1'] == "Asset Management Sinarmas" || $alternatif['kriteria1'] == "Eastpring Investments" ) {
                                            $x1 = 4;
                                        } else {
                                            $x1 = 3;
                                        }
                
                                        // kriteria2 = total AUM = x2
                                        if( $alternatif['kriteria2'] > 1 ) {
                                            $x2 = 5;
                                        } else if( $alternatif['kriteria2'] >= 0.50001 && $alternatif['kriteria2'] <= 1 ) {
                                            $x2 = 4;
                                        } else if( $alternatif['kriteria2'] >= 0.20001 && $alternatif['kriteria2'] <= 0.500 ) {
                                            $x2 = 3;
                                        } else if( $alternatif['kriteria2'] >= 0.050 && $alternatif['kriteria2'] <= 0.200 ) {
                                            $x2 = 2;
                                        } else if( $alternatif['kriteria2'] < 0.050 ) {
                                            $x2 = 1;
                                        }
                
                                        // kriteria3 = CAGR 1 tahun = x3
                                        if( $alternatif['kriteria3'] > 8 ) {
                                            $x3 = 5;
                                        } else if( $alternatif['kriteria3'] >= 6.01 && $alternatif['kriteria3'] <= 8 ) {
                                            $x3 = 4;
                                        } else if( $alternatif['kriteria3'] >= 4.01 && $alternatif['kriteria3'] <= 6 ) {
                                            $x3 = 3;
                                        } else if( $alternatif['kriteria3'] >= 2 && $alternatif['kriteria3'] <= 4 ) {
                                            $x3 = 2;
                                        } else if( $alternatif['kriteria3'] < 2 ) {
                                            $x3 = 1;
                                        }
                
                                        // kriteria4 = dropdown 1 tahun = x4
                                        if( $alternatif['kriteria4'] > 5 ) {
                                            $x4 = 1;
                                        } else if( $alternatif['kriteria4'] >= 3.01 && $alternatif['kriteria4'] <= 5 ) {
                                            $x4 = 2;
                                        } else if( $alternatif['kriteria4'] >= 2.01 && $alternatif['kriteria4'] <= 3 ) {
                                            $x4 = 3;
                                        } else if( $alternatif['kriteria4'] >= 1 && $alternatif['kriteria4'] <= 2 ) {
                                            $x4 = 4;
                                        } else if( $alternatif['kriteria4'] < 1 ) {
                                            $x4 = 5;
                                        }
                
                                        // kriteria5 = expense ratio = x5
                                        if( $alternatif['kriteria5'] > 2 ) {
                                            $x5 = 1;
                                        } else if( $alternatif['kriteria5'] >= 1.51 && $alternatif['kriteria5'] <= 2 ) {
                                            $x5 = 2;
                                        } else if( $alternatif['kriteria5'] >= 1.01 && $alternatif['kriteria5'] <= 1.5 ) {
                                            $x5 = 3;
                                        } else if( $alternatif['kriteria5'] >= 0.5 && $alternatif['kriteria5'] <= 1 ) {
                                            $x5 = 4;
                                        } else if( $alternatif['kriteria5'] < 0.5 ) {
                                            $x5 = 5;
                                        }
                
                                        // kriteria6 = minimal pembelian = x6
                                        if( $alternatif['kriteria6'] > 5000000 ) {
                                            $x6 = 2;
                                        } else if( $alternatif['kriteria6'] >= 901000 && $alternatif['kriteria6'] <= 5000000 ) {
                                            $x6 = 3;
                                        } else if( $alternatif['kriteria6'] >= 100000 && $alternatif['kriteria6'] <= 900000 ) {
                                            $x6 = 4;
                                        } else if( $alternatif['kriteria6'] < 100000 ) {
                                            $x6 = 5;
                                        }
                
                                        // kriteria7 = lama peluncuran = x7
                                        if( $alternatif['kriteria7'] > 120 ) {
                                            $x7 = 5;
                                        } else if( $alternatif['kriteria7'] >= 91 && $alternatif['kriteria7'] <= 120 ) {
                                            $x7 = 4;
                                        } else if( $alternatif['kriteria7'] >= 61 && $alternatif['kriteria7'] <= 96 ) {
                                            $x7 = 3;
                                        } else if( $alternatif['kriteria7'] >= 24 && $alternatif['kriteria7'] <= 60 ) {
                                            $x7 = 2;
                                        } else if( $alternatif['kriteria7'] < 24 ) {
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

                                        
                                        $no_al = $alternatif['no_alternatif'];
                                        $namaProduk = $alternatif['nama_produk'];
                                        $kriteria1 = $alternatif['kriteria1'];
                                        
                                        // $updateNilaiPreferensi = mysqli_query($koneksi, "UPDATE rangking SET nilai_preferensi = '$nilaiPreferensi' WHERE no_alternatif = '$no_al';");
                                        // $w = mysqli_num_rows($alternatifs);
                                        // var_dump($ww);
                                        // var_dump($no_al);

                                        // if($w == $ww){
                                        //     $updateNilaiPreferensi = mysqli_query($koneksi, "UPDATE rangking SET nilai_preferensi = '$nilaiPreferensi' WHERE no_alternatif = '$no_al';");
                                        // } else {
                                        //     $tambahDataNilaiPreferensi = mysqli_query($koneksi, "INSERT INTO `rangking`(`id_rank`, `no_alternatif`, `nama_produk`, `kriteria1`, `nilai_preferensi`) VALUES('', '$no_al', '$namaProduk', '$nilaiPreferensi');");
                                        // }

                                        // jika ada nomor alternatif makan update data jika tidak ada maka tambah data ke t.rangking


                                        echo "
                                            <tr>
                                                <td><b>". $alternatif['no_alternatif'] ."</b></td>
                                                <td>". $alternatif['kriteria1'] ."</td>
                                                <td>". $nilaiPreferensi ."</td>
                                            </tr>
                                        ";
                                        // echo $nilaiPreferensi;
                                        // echo '<br>';
                                        if($w == $www) {
                                            // echo '1';
                                            $updateNilaiPreferensi = mysqli_query($koneksi, "UPDATE rangking SET nilai_preferensi = '$nilaiPreferensi' WHERE no_alternatif = '$no_al';");
                                        } 
                                        // else if($w < $www) {
                                        //     $hapusDataNilaiPreferensi = mysqli_query($koneksi, "DELETE FROM rangking WHERE no_alternatif = '$no_al'");
                                        //     echo $w;
                                        //     echo '==';
                                        //     echo $www;
                                        //     echo '===';
                                        //     echo $no_al;
                                        // }
                                    }
                                    if($w > $www) {
                                        $tambahDataNilaiPreferensi = mysqli_query($koneksi, "INSERT INTO `rangking`(`id_rank`, `no_alternatif`, `nama_produk`, `kriteria1`, `nilai_preferensi`) VALUES('', '$no_al', '$namaProduk', '$kriteria1', '$nilaiPreferensi');");
                                        //  WHERE no_alternatif = '$no_al'
                                    } else if($w < $www) {
                                        $hapusDataNilaiPreferensi = mysqli_query($koneksi, "DELETE FROM rangking WHERE no_alternatif = '$no_al'");
                                        // echo $w;
                                        // echo '==';
                                        // echo $www;
                                        // echo '===';
                                        // echo $no_al;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- rij -->
    </div>
    <!-- tabel perhitungan -->
    

    <!-- tombol lihat hasil -->
    <br>
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

            $('.lihat-saw').click(function() {
                $('.tabel-perhitungan .matriksX').fadeToggle(1000);
                $('.tabel-perhitungan .rij').fadeToggle(2000);
                $('.tabel-perhitungan .nilaiPreferensi').fadeToggle(3000);

                // masih belum bisa
                // if(true) {
                //     $('.lihat-saw span').html("Sembunyikan");
                // } else if(true){
                //     $('.lihat-saw span').html("Lihat");
                // } else {
                //     $('.lihat-saw span').html("Sembunyikan");

                // }
                $('.lihat-saw span').fadeToggle(1000);
            });
            $('.lihat-hasil').click(function() {
                $('.hasil-rangking').fadeToggle(2000);

                // masih belum bisa
                // if(true) {
                //     $('.lihat-hasil span').html("Sembunyikan");
                // } else {
                //     $('.lihat-hasil span').html("Lihat");
                // }
                $('.lihat-hasil span').fadeToggle(1000);
            });
        })
    </script>

</body>
</html>

