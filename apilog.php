<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action == "1"){
$tahun = $_GET['tahun'];
$query = 'SELECT DATE_FORMAT(tgl,"%M") as bulan from notif where year(tgl) = '.$tahun.' group by month(tgl) order by month(tgl) desc';

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
elseif($action == "2"){
$query = 'SELECT year(tgl) as tahun from notif group by year(tgl) order by year(tgl) desc';
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
$tahun = $_GET['tahun']; 
$a = '<p style="color:red">Menghapus</p>';
$b = '<p style="color:blue">Mengubah</p>';
$c = '<p style="color:green">Menambahkan</p>';
$d = '<p style="color:yellow">Mendaftarkan</p>';
$query = "SELECT notif.id_notif , ( CASE 
when notif.jenis = 'Menghapus' then '$a'
when notif.jenis = 'Mengubah' then '$b'
when notif.jenis = 'Menambahkan' then '$c'
ELSE '$d'
END ) as jenis , notif.isi , DATE_FORMAT(notif.tgl,'%D %M% %Y') as tgl, tb_user.uname as admin , notif.status from notif join tb_user on tb_user.id_user = notif.admin where year(tgl) = '$tahun' order by notif.tgl desc"  or die("Cannot Access item");
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
	
		echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
$conn->close();
}

?>