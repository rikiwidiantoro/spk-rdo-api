<?php

    include_once('koneksi.php');

    // if( isset($_POST['submit']) ) {
    //     // mengambil data dari form
    //     $nama = $_POST['nama'];
    //     $username = $_POST['username'];
    //     $password = $_POST['password'];
    //     $konfirmasiPassword = $_POST['konfirmasiPassword'];
    //     echo $nama. '<br>';
    //     echo $username. '<br>';
    //     echo $password. '<br>';
    //     echo $konfirmasiPassword. '<br>';

    // }

    
    function registrasi($data) {
        global $koneksi;
        // Fungsi stripslashes pada php adalah untuk menghapus atau menghilangkan karakter backslashes tanda garis miring terbalik ("\") menggunakan stripslashes() sehingga tidak mengganggu query mysql yang dikirim.
        $nama = stripslashes($data['nama']);
        $username = strtolower(stripslashes($data['username']));
        // fungsi mysqli_real_escape_string untuk memberi backslash di beberapa kode untuk ditampilkan pada halaman, namun saat menyimpan menuju sql, kode akan tetap normal tanpa ada backslash.
        // atau memungkinkan user memasukkan password ada tanda kutip nya
        $password = mysqli_real_escape_string($koneksi, $data['password']);
        $konfirmasiPassword = mysqli_real_escape_string($koneksi, $data['konfirmasiPassword']);
        $waktuPendaftaran = stripslashes($data['waktuPendaftaran']);

        // cek username sudah ada atau belum
        $dataLogin = mysqli_query($koneksi, "SELECT username FROM login WHERE username = '$username'");
        if(mysqli_fetch_assoc($dataLogin)) {
            echo "
                <script>
                    alert('username sudah terdaftar sebelumnya!');
                </script>
            ";
            return false;
        }

        // cek konfirmasi password
        if($password !== $konfirmasiPassword) {
            echo "
                <script>
                    alert('konfirmasi password tidak sesuai!');
                </script>
            ";
            return false;
        }

        // enkripsi password
        $password = password_hash($konfirmasiPassword, PASSWORD_DEFAULT);

        // menambahkan user baru ke database
        mysqli_query($koneksi, "INSERT INTO login VALUES('', '$nama', '$username', '$password', '$waktuPendaftaran')");

        return mysqli_affected_rows($koneksi);

    }

    if( isset($_POST['registrasi']) ) {
        if( registrasi($_POST) > 0 ) {
            echo "
                <script>
                    alert('Akun Anda berhasil didaftarkan!');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            mysqli_error($koneksi);
        }
    }


    $tambah = strtotime('5 hours');
    $tglDaftar = Date('h:i a, d M Y', $tambah);

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
        <title>Registrasi Pengunjung</title>
        <link rel="stylesheet" href="responsive.css">

        <style>
            td input {
                margin-right: 100px !important;
            }
            .note {
                font-size: 11px;
                color: red;
            }
        </style>
    </head>

    <body>

        <!-- navbar -->
        <div class="navbar-fixed">
            <nav class="grey darken-2">
                <div class="nav-wrapper container">
                    <a href="index.php"><i class="material-icons left">keyboard_backspace</i>Kembali</a>
                    <a href="#" class="brand-logo center">SPK Reksa Dana Obligasi</a>
                </div>
            </nav>
        </div>
        <!-- navbar -->


        <!-- form -->
        <br>
        <div class="row center">
            <div class="col l4 m6 s10 offset-l4 offset-m3 offset-s1">
                <h5>Masukan data diri Anda dibawah!</h5>
                <hr>
                <p class="note">*note : jangan menggunakan tanda petik ('',"")!</p>
            </div>
        </div>
        <div class="row">
            <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 center">
                <form action="" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td><input type="text" name="nama" autocomplete="off" required></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><input type="text" name="username" autocomplete="off" required></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" name="password" autocomplete="off" required></td>
                        </tr>
                        <tr>
                            <td>Konfirmasi Password</td>
                            <td><input type="password" name="konfirmasiPassword" autocomplete="off" required></td>
                        </tr>
                        <tr>
                            <td>Waktu Pendaftaran</td>
                            <td><input type="text" name="waktuPendaftaran" value="<?php echo $tglDaftar; ?>" readonly=""></td>
                        </tr>
                    </table>
                    <br>
                    <button class="btn grey darken-2 waves-effect waves-light" type="submit" name="registrasi">Daftar
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