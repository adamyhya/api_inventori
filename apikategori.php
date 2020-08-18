<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action == '1'){
$rank = "SET @rank=0";
$query = "SELECT @rank:=@rank+1 as nomor, id_kategori, nama_kategori from tb_kategori" or die("Cannot Access item");
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
elseif($action == '2'){
$records = json_decode($_REQUEST['records']);
$idj = $records->{"id_kategori"};
$nmj = $records->{"nama_kategori"};
$isi = "Kategori ".$nmj;
$admin = $records->{"id_user"};
$query = "INSERT INTO tb_kategori (id_kategori, nama_kategori) values ('$idj','$nmj')";
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
elseif ($action == '3') {
$records = json_decode($_REQUEST['records']);
$idj = $records->{"id_kategori"};
$nmk = "Kategori ".$records->{"nama_kategori"};
$admin = $_GET['iduser'];
$query = "DELETE FROM tb_kategori where id_kategori = '$idj'";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Menghapus','$nmk',now(),'$admin','1')";
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
$idk = $records->{"id_kategori"};
$nk = $records->{"nama_kategori"};
$oldnk = $records->{"old_nama_kategori"};
$admin = $records->{"id_user"};
$isi = "Kategori ".$oldnk." Menjadi ".$nk;
$query = "UPDATE tb_kategori set nama_kategori = '$nk' where id_kategori = '$idk'";
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