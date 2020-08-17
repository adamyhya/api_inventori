<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action=="1"){ //barang keluar
if(isset($_GET['tgl'])){
$tgl = $_GET['tgl'];	
$query = 'SELECT 
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
LEFT JOIN tb_user ON tb_user.id_user = tb_barang_keluar.id_pengguna where year(tb_barang_keluar.tgl_keluar) = '.$tgl.' order by tb_barang_keluar.tgl_keluar desc' or die("Cannot Access item");
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
}
elseif($action == "2"){
$query = 'SELECT year(tgl_keluar) as tahun from tb_barang_keluar group by year(tgl_keluar) order by year(tgl_keluar) desc';
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
elseif($action == "3"){
if(isset($_GET['tahun'])){
	$tahun = $_GET['tahun'];
$query = 'SELECT DATE_FORMAT(tgl_keluar,"%M") as bulan from tb_barang_keluar where year(tgl_keluar) = '.$tahun.' group by month(tgl_keluar) order by month(tgl_keluar) desc';
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
}
elseif($action=="4"){ //barang masuk
if(isset($_GET['tgl'])){
$tgl = $_GET['tgl'];	
$query = 'SELECT 
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
LEFT JOIN tb_user ON tb_user.id_user = tb_barang_masuk.id_pengguna where year(tb_barang_masuk.tgl_masuk) = '.$tgl.' order by tb_barang_masuk.tgl_masuk desc' or die("Cannot Access item");
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
}
elseif($action == "5"){
$query = 'SELECT year(tgl_masuk) as tahun from tb_barang_masuk group by year(tgl_masuk) order by year(tgl_masuk) desc';
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
elseif($action == "6"){
if(isset($_GET['tahun'])){
	$tahun = $_GET['tahun'];
$query = 'SELECT DATE_FORMAT(tgl_masuk,"%M") as bulan from tb_barang_masuk where year(tgl_masuk) = '.$tahun.' group by month(tgl_masuk) order by month(tgl_masuk) desc';
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
}
elseif($action == '7'){
$records = json_decode($_REQUEST['records']);
$idbm = $records->{"id_brg_masuk"};
$query = "DELETE FROM tb_barang_masuk where id_brg_masuk = '$idbm'";
if($conn->query($query) == TRUE){
$success = 'true';
}
else{
$success = 'false';
$error = $conn->error;
}
if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();	
}
