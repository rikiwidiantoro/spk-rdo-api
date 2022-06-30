<?php
// error_reporting(0);
    require_once('../koneksi.php');

    $tglUpdate = '20 May 2022';
    $tambah = strtotime('5 hours');
    $tglDownload = Date('h:i a, d M Y', $tambah);
    // $tglDownload = Date('H:i:s, d M Y', mktime(0, 0, 0, 1, 1, 1998));

    require('fpdf.php');
    $pdf = new FPDF('P','mm','A4');
    $pdf->SetMargins(25,10); 

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(160,20,'DAFTAR HASIL PERANGKINGAN REKSA DANA OBLIGASI',0,1,'C');
    
    
    $pdf->SetFont('Arial','I',10);
    // untuk history rekap data
    // $pdf->Cell(60,7,'Tanggal update data : '.$tglUpdate,0,1);
    // untuk history rekap data

    // $pdf->Cell(60,7,'Tanggal update data : '.$tglUpdate,0,1);
    $pdf->Cell(60,7,'Tanggal download : '.$tglDownload,0,1);

    $pdf->Cell(60,7,'',0,1);; 

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(20,10,'Alternatif',1,0,'C');
    $pdf->Cell(90,10,'Nama Produk',1,0,'C');
    $pdf->Cell(30,10,'Nilai Preferensi',1,0,'C');
    $pdf->Cell(20,10,'Ranking',1,1,'C');



    $rangking = mysqli_query($koneksi, "SELECT * FROM rangking ORDER BY nilai_preferensi DESC");
    $i=0;
    $pdf->SetFont('Arial','',10);
    while($data = mysqli_fetch_array($rangking)) {
        
        $pdf->Cell(20,9,'A'.$data['id_api'],1,0,'C');
        $pdf->Cell(90,9,$data['nama_produk'],1,0);
        $pdf->Cell(30,9,$data['nilai_preferensi'],1,0,'C');
        $pdf->Cell(20,9,$i+=1,1,1,'C');
    }
    $pdf->SetTitle('Daftar Ranking');
    $waktu = Date('d M Y', $tambah);
    $pdf->Output('I','Daftar Ranking '. $waktu .'.pdf');

?>