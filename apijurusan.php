<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action == '1'){
$rank = "SET @rank=0";
$query = "SELECT @rank:=@rank+1 as nomor, id_jurusan, nama_jurusan from tb_jurusan" or die("Cannot Access item");
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
$nmj = $records->{"nama_jurusan"};
$query = "INSERT INTO tb_jurusan (nama_jurusan) values ('$nmj')";
$isi = "Jurusan ".$nmj;
$admin = $records->{"id_user"};
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
$idj = $records->{"id_jurusan"};
$nmj = $records->{"nama_jurusan"};
$query = "DELETE FROM tb_jurusan where id_jurusan = '$idj'";
$isi = "Jurusan ".$nmj;
$admin = $_GET['iduser'];
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
$idk = $records->{"id_jurusan"};
$nk = $records->{"nama_jurusan"};
$oldnk = $records->{"old_nama_jurusan"};
$query = "UPDATE tb_jurusan set nama_jurusan = '$nk' where id_jurusan = '$idk'";
$isi = "Jurusan ".$oldnk." Menjadi ".$nk;
$admin = $records->{"id_user"};
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