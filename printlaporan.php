<?php
include "lib/fpdf.php";
include "koneksi.php";
$action = $_GET['action'];
if($action == '1'){
if(isset($_GET['tahun'])){

$tahun = $_GET['tahun'];

date_default_timezone_set('Asia/Jakarta');// change according timezone

$currentTime = date( 'd-m-Y h:i:s A', time () );


$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(0.5,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
//$pdf->Image('logo.jpeg',8,-0.1,15,3);
$pdf->SetX(4);
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(28,3.3,"Daftar Barang Masuk",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,-3,"Printed On : ".date("D-d/M/Y"),0,0,'C');

$pdf->ln(-2);
$qry = mysqli_query($conn,'SELECT COUNT(id_brg_masuk) as total,DATE_FORMAT(tgl_masuk,"%M") as bulan, month(tgl_masuk) as angka from tb_barang_masuk where year(tgl_masuk) = '.$tahun.' group by month(tgl_masuk) order by month(tgl_masuk) desc');

while($r=mysqli_fetch_array($qry)){
$angka = $r['angka'];
$pdf->SetFont('Arial','B',9);
$pdf->Cell(4,3,'Bulan : '.$r['bulan'].' | Total : '.$r['total'],0,1,'C',0);
$pdf->ln(-1);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Satuan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Nama Jurusan', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Keterangan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Admin', 1, 1, 'C');
$pdf->SetFont('Arial','',9);
$query=mysqli_query($conn,'SELECT 
tb_barang.nama_barang,
tb_barang.id_barang,
tb_barang.jumlah_barang,
tb_kategori.nama_kategori,
tb_barang_masuk.jumlah_barang_masuk,
tb_satuan.nama_satuan,
DATE_FORMAT(tb_barang_masuk.tgl_masuk,"%D %M% %Y") as tgl_masuk,
tb_jurusan.nama_jurusan,
tb_user.nama_user,
tb_barang_masuk.keterangan,
tb_barang_masuk.id_brg_masuk 
FROM tb_barang_masuk 
LEFT JOIN tb_barang ON tb_barang.id_barang = tb_barang_masuk.id_barang 
LEFT JOIN tb_kategori ON tb_kategori.id_kategori = tb_barang.id_kategori 
LEFT JOIN tb_satuan ON tb_satuan.id_satuan = tb_barang.id_satuan 
LEFT JOIN tb_jurusan ON tb_jurusan.id_jurusan = tb_barang_masuk.id_jurusan 
LEFT JOIN tb_user ON tb_user.id_user = tb_barang_masuk.id_pengguna where year(tb_barang_masuk.tgl_masuk) = '.$tahun.' and month(tb_barang_masuk.tgl_masuk) = '.$angka.' order by tb_barang_masuk.tgl_masuk desc');
$no = 1;
while($lihat=mysqli_fetch_array($query)){

	$pdf->Cell(1, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(7, 0.8, $lihat['nama_barang'], 1, 0,'C');
	
	$pdf->Cell(1.5, 0.8, $lihat['jumlah_barang_masuk'],1, 0, 'C');
	$pdf->Cell(2, 0.8, $lihat['nama_satuan'],1, 0, 'C');
	$pdf->Cell(4, 0.8, $lihat['nama_jurusan'],1, 0, 'C');
	$pdf->Cell(3, 0.8, date("d-M-Y",strtotime($lihat['tgl_masuk'])),1, 0, 'C');
	$pdf->Cell(5, 0.8, $lihat['keterangan'],1, 0, 'C');
	$pdf->Cell(4, 0.8, $lihat['nama_user'], 1, 1,'C');

	$no++;
}
}

$pdf->Output("daftar_barang_masuk.pdf","I");
header('Content-Type: application/pdf');
header('Content-disposition: attachment; filename=daftar_barang_masuk.pdf');
}
}
if($action == '2'){
if(isset($_GET['tahun'])){

$tahun = $_GET['tahun'];

date_default_timezone_set('Asia/Jakarta');// change according timezone

$currentTime = date( 'd-m-Y h:i:s A', time () );


$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(0.5,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
//$pdf->Image('logo.jpeg',8,-0.1,15,3);
$pdf->SetX(4);
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(28,3.3,"Daftar Barang Keluar",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,-3,"Printed On : ".date("D-d/M/Y"),0,0,'C');

$pdf->ln(-2);
$qry = mysqli_query($conn,'SELECT COUNT(id_brg_keluar) as total,DATE_FORMAT(tgl_keluar,"%M") as bulan, month(tgl_keluar) as angka from tb_barang_keluar where year(tgl_keluar) = '.$tahun.' group by month(tgl_keluar) order by month(tgl_keluar) desc');

while($r=mysqli_fetch_array($qry)){
$angka = $r['angka'];
$pdf->SetFont('Arial','B',9);
$pdf->Cell(4,3,'Bulan : '.$r['bulan'].' | Total : '.$r['total'],0,1,'C',0);
$pdf->ln(-1);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Satuan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Nama Jurusan', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Keterangan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Admin', 1, 1, 'C');
$pdf->SetFont('Arial','',9);
$query=mysqli_query($conn,'SELECT 
tb_barang.nama_barang,
tb_barang.id_barang,
tb_barang.jumlah_barang,
tb_kategori.nama_kategori,
tb_barang_keluar.jumlah_barang_keluar,
tb_satuan.nama_satuan,
DATE_FORMAT(tb_barang_keluar.tgl_keluar,"%D %M% %Y") as tgl_keluar,
tb_jurusan.nama_jurusan,
tb_user.nama_user,
tb_barang_keluar.keterangan,
tb_barang_keluar.id_brg_keluar 
FROM tb_barang_keluar 
LEFT JOIN tb_barang ON tb_barang.id_barang = tb_barang_keluar.id_barang 
LEFT JOIN tb_kategori ON tb_kategori.id_kategori = tb_barang.id_kategori 
LEFT JOIN tb_satuan ON tb_satuan.id_satuan = tb_barang.id_satuan 
LEFT JOIN tb_jurusan ON tb_jurusan.id_jurusan = tb_barang_keluar.id_jurusan 
LEFT JOIN tb_user ON tb_user.id_user = tb_barang_keluar.id_pengguna where year(tb_barang_keluar.tgl_keluar) = '.$tahun.' and month(tb_barang_keluar.tgl_keluar) = '.$angka.' order by tb_barang_keluar.tgl_keluar desc');
$no = 1;
while($lihat=mysqli_fetch_array($query)){

	$pdf->Cell(1, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(7, 0.8, $lihat['nama_barang'], 1, 0,'C');
	
	$pdf->Cell(1.5, 0.8, $lihat['jumlah_barang_keluar'],1, 0, 'C');
	$pdf->Cell(2, 0.8, $lihat['nama_satuan'],1, 0, 'C');
	$pdf->Cell(4, 0.8, $lihat['nama_jurusan'],1, 0, 'C');
	$pdf->Cell(3, 0.8, date("d-M-Y",strtotime($lihat['tgl_keluar'])),1, 0, 'C');
	$pdf->Cell(5, 0.8, $lihat['keterangan'],1, 0, 'C');
	$pdf->Cell(4, 0.8, $lihat['nama_user'], 1, 1,'C');

	$no++;
}
}

$pdf->Output("daftar_barang_keluar.pdf","I");
header('Content-Type: application/pdf');
header('Content-disposition: attachment; filename=daftar_barang_keluar.pdf');
}
}

?>