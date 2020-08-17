<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action == '1'){
$rank = "SET @rank=0";
$query = "SELECT @rank:=@rank+1 as nomor, id_satuan, nama_satuan from tb_satuan" or die("Cannot Access item");
$result = mysqli_query($conn, $rank);
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
elseif($action == '2')
{
$records = json_decode($_REQUEST['records']);
$nmj = $records->{"nama_satuan"};
$query = "INSERT INTO tb_satuan (nama_satuan) values ('$nmj')";
$isi = "Satuan ".$nmj;
$admin = "adamyahya";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Menambahkan','$isi',now(),'$admin','1')";
if($conn->query($query) == TRUE && $conn->query($query1) == TRUE){
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
elseif($action == '3'){
$records = json_decode($_REQUEST['records']);
$idj = $records->{"id_satuan"};
$nmj = $records->{"nama_satuan"};
$query = "DELETE FROM tb_satuan where id_satuan = '$idj'";
$isi = "Satuan ".$nmj;
$admin = "adamyahya";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Menghapus','$isi',now(),'$admin','1')";
if($conn->query($query) == TRUE && $conn->query($query1) == TRUE){
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
elseif ($action == '4') {
$records = json_decode($_REQUEST['records']);
$ids = $records->{"id_satuan"};
$ns = $records->{"nama_satuan"};
$oldns = $records->{"old_nama_satuan"};
$query = "UPDATE tb_satuan set nama_satuan = '$ns' where id_satuan = '$ids'";
$isi = "Satuan ".$oldns." Menjadi ".$ns;
$admin = "adamyahya";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Mengubah','$isi',now(),'$admin','1')";
if($conn->query($query) == TRUE && $conn->query($query1) == TRUE){
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
else{
	echo $callback . '({"Aksi Tidak Terdaftar!!!"'.$success.'});';	
}
?>