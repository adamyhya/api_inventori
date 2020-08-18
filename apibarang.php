<?php 
include "koneksi.php";
$action = $_GET['action'];
$callback = $_REQUEST['callback'];
$success = 'false';
if($action=="1"){
$rank = "SET @rank=0";
$query = "SELECT @rank:=@rank+1 as nomor ,tb_barang.id_barang, tb_barang.nama_barang , tb_kategori.nama_kategori ,tb_barang.jumlah_barang, tb_satuan.nama_satuan from tb_barang JOIN tb_kategori ON tb_barang.id_kategori = tb_kategori.id_kategori JOIN tb_satuan ON tb_barang.id_satuan = tb_satuan.id_satuan" or die("Cannot Access item");
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
elseif($action == "2"){
$records = json_decode($_REQUEST['records']);
$idk = $records->{"id_kategori"};
$ids = $records->{"id_satuan"};
$nb = $records->{"nama_barang"};
$jml = $records->{"jumlah_barang"};
$admin = $records->{"id_user"};
$isi = $nb." Sebanyak ".$jml;
$query = "INSERT INTO tb_barang (id_kategori, id_satuan, nama_barang, jumlah_barang) values ('$idk','$ids','$nb','$jml')";
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
elseif($action == "3"){
$records = json_decode($_REQUEST['records']);
$idbs = $records->{"id_barang"};
$nb = $records->{"nama_barang"};
$admin = $_GET['iduser'];
$query = "DELETE FROM tb_barang where id_barang = '$idbs'";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Menghapus','$nb',now(),'$admin','1')";
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
$idb = $records->{"id_barang"};
$nb = $records->{"nama_barang"};
$jml = $records->{"jumlah_barang"};
$idk = $records->{"id_kategori"};
$ids = $records->{"id_satuan"};
$oldnb = $records->{"old_nama_barang"};
$oldjml = $records->{"old_jumlah_barang"};
$isi = $oldnb." Sebanyak ".$oldjml." Menjadi ".$nb." Sebanyak ".$jml;
$admin = $records->{"id_user"};
$query = "UPDATE tb_barang set nama_barang = '$nb', jumlah_barang = '$jml', id_kategori = '$idk', id_satuan = '$ids' where id_barang = '$idb'";
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