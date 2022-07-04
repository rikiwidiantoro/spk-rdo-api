<?php
    // session
    session_start();

    if( !isset($_SESSION['login']) ) {
        header("Location: ../index.php");
        exit;
    }
    // session

    // koneksi
    include_once('../koneksi.php');

    $dataHistoris = mysqli_query($koneksi, "SELECT * FROM data_history");


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
    <title>Data History</title>

    <!-- data tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <!-- css sendiri -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="../responsive.css">
    <style>
        .data-history table a {
            color: #26a69a;
        }
        footer {
            margin-top: 20px;
        }
        .footer-copyright {
            padding: 10px 85px;
            text-align: center;
        }
        footer a:hover, .data-history .row1 a:hover, .data-history table a:hover {
            text-decoration: underline;
        }
        /* data table */
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
                    <li><a href="index.php">dasboard</a></li>
                    <li><a href="hasilRangkingUser.php">hasil perangkingan</a></li>
                    <li class="active"><a href="dataHistoryUser.php">data history</a></li>
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
        <li><a href="hasilRangkingUser.php">Hasil Perangkingan</a></li>
        <li class="active"><a href="dataHistoryUser.php">Data History</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
    <!-- sidenav -->


    <!-- welcome -->
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Data History</h4>
                <hr>
            </div>
        </div>
    </div>
    
    <!-- welcome -->


    <!-- data history -->
    <div class="data-history">
        <div class="container">
            <br>
            <div class="row">
                <div class="col s12">
                    <table id="tabelDataHistory" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>Data Perangkingan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nomor = 1;
                                foreach($dataHistoris as $data) {
                                    echo "
                                        <tr>
                                            <td>".$nomor++."</td>
                                            <td>".$data['tahun']."</td>
                                            <td>".$data['bulan']."</td>
                                            <td><a href='../laporan/data/2022/".$data['data_ranking']."' target='_blank'><i class='material-icons left'>file_download</i> Data Ranking</a></td>
                                        </tr>
                                    ";
                                }
                            ?>
                            <!-- <td>Mei</td>
                            <td>
                                <a href="../laporan/dataPDF/2022/Daftar Rangking Mei 2022.pdf" target="_blank"><i class="material-icons left">file_download</i>Data Ranking Mei 2022</a>
                            </td> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br>
    <!-- data history -->



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
    <!-- library data table -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // $('.mei').css('display', 'none');
            // $('.data-mei').click(function() {
            //     $('.mei').fadeToggle(2000);
            // });
            // console.log('ok');
            $('#tabelDataHistory').DataTable();


            // sidenav
            const sidenav = document.querySelectorAll('.sidenav');
            // inisialisasi
            M.Sidenav.init(sidenav);
        });
    </script>

</body>
</html>