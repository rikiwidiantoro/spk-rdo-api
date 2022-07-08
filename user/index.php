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
    // $alternatifs = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY no_alternatif ASC");

    $join = mysqli_query($koneksi, "SELECT * FROM fetch_api INNER JOIN alternatif USING (id_api)");

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



    
    // api
    // $contents = file_get_contents('https://bibit-reksadana.vercel.app/api/?types=fixed_income&buy_from_bibit=true&per_page=35');
    $contents = file_get_contents('https://bibit-reksadana.vercel.app/api/?types=fixed_income&buy_from_bibit=true&per_page=35');
    $contents = utf8_encode($contents);
    $result = json_decode($contents, 1);

    // var_dump($result);
    $results = $result['data'];


    // mengambil jumlah data pada tabel fetch_api
    $fetchs = mysqli_query($koneksi, "SELECT * FROM fetch_api");
    $idd = mysqli_num_rows($fetchs);
    global $idd;


    // new
    foreach($results as $hasil) {
        // inisialisasi
        $totalId = 32;
        $id = $hasil['id'];
        $namaProduk = $hasil['name'];

        // kriteria
        $totalAum = round($hasil['aum']['value'] / 1000000000, 2); // miliyar
        $cagr = round($hasil['cagr']['1y'] * 100, 2);
        $drawdown = round($hasil['maxdrawdown']['1y'] * 100, 2);
        $expenseRatio = round($hasil['expenseratio']['percentage'] * 100, 2);
        $minBuy = $hasil['minbuy'];

        if($totalId == $idd) {
            // echo '1';
            $updateTabelFetchAPI = mysqli_query($koneksi, "UPDATE fetch_api SET namaProduk = '$namaProduk', aum = '$totalAum', cagr = '$cagr', drawdown = '$drawdown', expense = '$expenseRatio', minbuy = '$minBuy' WHERE id_api = '$id';");
        }

    }

    
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
    <link rel="stylesheet" href="../responsive.css">
    <style>
        .reload {
            margin-top: 40px;
            margin-right: -10px;
        }
        .ket p {
            margin-top: 35px;
            text-align: right;
        }
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
        .pesan-update, .ket p {
            font-style: italic;
            font-size: 13px;
        }
        footer {
            margin-top: 20px;
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
        .alternatif .alternatiff{
            overflow-x: auto;
        }
        
        @media screen and (min-width: 1000px) {
            .alternatif table td, .alternatif table th, .alternatifi table td, .alternatifi table th {
                font-size: 14px;
            }
            .kriteria table {
                font-size: 14px;
            }
            .con {
                padding: 2% 4%;
            }
            .con table{
                margin-left: 0px;
            }
            /* table {
                display: block;
                max-width: -moz-fit-content;
                max-width: fit-content;
                margin: 0 auto;
                overflow-x: auto;
                white-space: nowrap;
            } */
        }
        @media screen and (min-width: 601px) and (max-width: 1000px) {
            .alternatif table td, .alternatif table th, .alternatifi table td, .alternatifi table th {
                font-size: 12px;
            }
            .kriteria table {
                font-size: 12px;
            }
            .con {
                padding: 1% 2%;
            }
            .con table{
                margin-left: -10px;
            }
            /* #tabelAlternatif {
                display: block;
                max-width: -moz-fit-content;
                max-width: fit-content;
                margin: 0 auto;
                overflow-x: auto;
                white-space: nowrap;
            } */
        }
        @media screen and (max-width: 600px) {
            .alternatif table td, .alternatif table th, .alternatifi table td, .alternatifi table th {
                font-size: 10px;
            }
            .kriteria table {
                font-size: 10px;
            }
            .con {
                padding: 0% 1%;
            }
            .con table{
                margin-left: -20px;
            }
            /* #tabelAlternatif {
                display: block;
                max-width: -moz-fit-content;
                max-width: fit-content;
                margin: 0 auto;
                overflow-x: auto;
                white-space: nowrap;
            } */
        }

        /* @media screen and (max-width: 400px) {
            .alternatif table td, .alternatif table th, .alternatifi table td, .alternatifi table th {
                font-size: 10px;
            }
            .con {
                padding: 0% 1%;
            }
            .con table{
                margin-left: -20px;
            }
            #tabelAlternatif {
                display: block;
                max-width: -moz-fit-content;
                max-width: fit-content;
                margin: 0 auto;
                overflow-x: auto;
                white-space: nowrap;
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
    <div class="row container ucapanSelamat welcome">
        <div class="col">
            <h4>Selamat Datang, <span><?= $user ?></span>!</h3>
            <hr>
        </div>
        <div class="col l5 m12 s12 offset-l1">
            <div class="row">
                <div class="col l6 m8 s12 offset-l2 ket">
                    <p>klik refresh 2X untuk mengambil data terbaru dari Bibit</p>
                </div>
                <div class="col l4 m6 s8">
                    <button class="waves-effect right waves-light btn-small grey darken-1 reload" onClick="window.location.reload();"><i class="material-icons left">refresh</i>Refresh Data</button>
                </div>
            </div>
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
            <div class="row alternatiff">
                <div class="col m12">
                    <table id="tabelAlternatif" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
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
                                foreach($join as $fetch) {

                                    // membedakan mata uang usd dan rupiah
                                    if($fetch['namaProduk'] === 'BNP Paribas Prima USD Kelas RK1' || $fetch['namaProduk'] === 'Manulife USD Fixed Income Kelas A' || $fetch['namaProduk'] === 'Schroder USD Bond Fund') {
                                        $mataUang = 'USD';
                                    } else {
                                        $mataUang = 'Rp';
                                    }

                                    // lama peluncuran
                                    $tanggal = new DateTime($fetch['lama_peluncuran']);
                                    // tanggal hari ini
                                    $today = new DateTime('today');
                                    // tahun
                                    $y = $today->diff($tanggal)->y;
                                    // bulan
                                    $m = $today->diff($tanggal)->m;

                                    echo "
                                    <tr>
                                        <td class='center'>". $fetch['no_alternatif'] ."</td>
                                        <td>". $fetch['namaProduk'] ."</td>
                                        <td>". $fetch['mi'] ."</td>
                                        <td class='center'>". $fetch['aum'] ." B</td>
                                        <td class='center'>". $fetch['cagr'] ."%</td>
                                        <td class='center'>". $fetch['drawdown'] ."%</td>
                                        <td class='center'>". $fetch['expense'] ."%</td>
                                        <td>". $mataUang ." ". $fetch['minbuy'] ."</td>
                                        <td style='width:150px;'>". $y ." Tahun, ". $m ." Bulan</td>
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
    </div>
    <!-- tabel alternatif -->


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
            

            $('#tabelAlternatif').DataTable();
            $('#tabelKriteria').DataTable();


            // sidenav
            const sidenav = document.querySelectorAll('.sidenav');
            // inisialisasi
            M.Sidenav.init(sidenav);
        });
    </script>

</body>
</html>

