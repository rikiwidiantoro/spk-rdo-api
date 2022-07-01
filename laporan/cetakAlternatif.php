<?php

    require_once('../koneksi.php');

    $tglUpdate = '20 May 2022';
    $tambah = strtotime('5 hours');
    $tglDownload = Date('h:i a, d M Y', $tambah);
    // $tglDownload = Date('H:i:s, d M Y', mktime(0, 0, 0, 1, 1, 1998));

    require('fpdf.php');
    $pdf = new FPDF('L','mm','A4');
    $pdf->SetMargins(5,10); 

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(280,15,'DAFTAR DATA ALTERNATIF REKSA DANA OBLIGASI',0,1,'C');
    
    
    $pdf->SetFont('Arial','I',10);
    $pdf->Cell(60,7,'Tanggal download data : '.$tglDownload,0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(60,7,'Keterangan Total AUM : T = Trillion = Triliun',0,1);
    $pdf->Cell(60,5,'',0,1); 

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(17,10,'Alternatif',1,0,'C');
    $pdf->Cell(73,10,'Nama Produk',1,0,'C');
    $pdf->Cell(65,10,'Manajer Investasi',1,0,'C');
    $pdf->Cell(20,10,'Total AUM',1,0,'C');
    $pdf->Cell(15,10,'CAGR',1,0,'C');
    $pdf->Cell(17,10,'Drawdown',1,0,'C');
    $pdf->Cell(25,10,'Expense Ratio',1,0,'C');
    $pdf->Cell(25,10,'Min. Pembelian',1,0,'C');
    $pdf->Cell(30,10,'Lama Peluncuran',1,1,'C');



    $rangking = mysqli_query($koneksi, "SELECT * FROM fetch_api INNER JOIN alternatif USING (id_api)");
    $pdf->SetFont('Arial','',9);
    while($data = mysqli_fetch_array($rangking)) {

        // membedakan mata uang usd dan rupiah
        if($data['namaProduk'] === 'BNP Paribas Prima USD Kelas RK1' || $data['namaProduk'] === 'Manulife USD Fixed Income Kelas A' || $data['namaProduk'] === 'Schroder USD Bond Fund') {
            $mataUang = 'USD';
        } else {
            $mataUang = 'Rp';
        }

        // lama peluncuran
        $tanggal = new DateTime($data['lama_peluncuran']);
        // tanggal hari ini
        $today = new DateTime('today');
        // tahun
        $y = $today->diff($tanggal)->y;
        // bulan
        $m = $today->diff($tanggal)->m;
        
        $pdf->Cell(17,9,$data['no_alternatif'],1,0,'C');
        $pdf->Cell(73,9,$data['namaProduk'],1,0);
        $pdf->Cell(65,9,$data['mi'],1,0);
        $pdf->Cell(20,9,$data['aum']." T",1,0,'C');
        $pdf->Cell(15,9,$data['cagr']."%",1,0,'C');
        $pdf->Cell(17,9,$data['drawdown']."%",1,0,'C');
        $pdf->Cell(25,9,$data['expense']."%",1,0,'C');
        $pdf->Cell(25,9,$mataUang ." ".$data['minbuy'],1,0,'R');
        $pdf->Cell(30,9,$y." Tahun, ".$m." Bulan",1,1,'C');
    }

    $pdf->SetTitle('Daftar Data Alternatif');
    $waktu = Date('d M Y', $tambah);
    $pdf->Output('I','Data Alternatif '. $waktu .'.pdf');

?>