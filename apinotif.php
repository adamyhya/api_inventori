<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action == "1"){
$id_user = $_GET['iduser']; 
$a = '<p style="color:red">Menghapus</p>';
$b = '<p style="color:blue">Mengubah</p>';
$c = '<p style="color:green">Menambahkan</p>';
$d = '<p style="color:yellow">Mendaftarkan</p>';
$query = "SELECT notif.id_notif , ( CASE 
when notif.jenis = 'Menghapus' then '$a' when notif.jenis = 'Mengubah' then '$b' when notif.jenis = 'Menambahkan' then '$c' ELSE '$d'
END ) as jenis , notif.isi , DATE_FORMAT(notif.tgl,'%D %M% %Y') as tgl, tb_user.uname as admin , notif.status from notif join tb_user on tb_user.id_user = notif.admin where not admin = '$id_user' and status = '1' order by notif.tgl desc"  or die("Cannot Access item");
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
elseif(isset($_GET['id_notif'])){
$id_notif = $_GET['id_notif'];
$query = "UPDATE notif set status = '0' where id_notif = '$id_notif'";
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
elseif($action == "3"){
$records = json_decode($_REQUEST['records']);
$id_user = $_GET['iduser']; 
$query = "UPDATE notif set status = '0' where not admin = '$id_user'";
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

else{
	echo $callback . '({"Aksi Tidak Terdaftar!!!"'.$success.'});';	
}

?>