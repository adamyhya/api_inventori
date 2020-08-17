<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action == '1'){
$rank = 'SET @rank=0';
$query = 'SELECT @rank:=@rank+1 as nomor, id_user, uname, pwd, nama_user, IF(akses = 1, "Admin", "Staff") as akses, kontak, DATE_FORMAT(tgl_buat,"%D %M% %Y") as tgl_buat from tb_user' or die("Cannot Access item");
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
$nmu = $records->{"nama_user"};
$un = $records->{"uname"};
$pw = $records->{"pwd"};
$akses = $records->{"akses"};
$kt = $records->{"kontak"};
if($akses == "1"){
	$akses = "Admin";
}
else{
	$akses = "Staff";
}
$admin = "admayahya";
$isi = $nmu." Sebagai ".$akses;
$query = "INSERT INTO tb_user (nama_user, uname, pwd, akses, kontak, tgl_buat) values ('$nmu','$un',md5('$pw'),'$akses','$kt', NOW())";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Mendaftarkan','$isi',now(),'$admin','1')";
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
$idj = $records->{"id_user"};
$nmu = $records->{"nama_user"};
$admin = "adamyahya";
$isi = "Data Pengguna ".$nmu;
$query = "DELETE FROM tb_user where id_user = '$idj'";
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
$idk = $records->{"id_user"};
$nk = $records->{"nama_user"};
$un = $records->{"uname"};
$pw = $records->{"pwd"};
$akses = $records->{"akses"};
$kontak = $records->{"kontak"};
$admin = "adamyahya";
$isi = "Data Pengguna ".$nk;
$query = "UPDATE tb_user set nama_user = '$nk', uname = '$un', pwd = md5('$pw'), akses = '$akses', kontak = '$kontak' where id_user = '$idk'";
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