<?php 
include "koneksi.php";
$callback = $_REQUEST['callback'];
$output = array();
$action = $_REQUEST['action'];
if($action == '1'){
$success = 'false';
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
LEFT JOIN tb_user ON tb_user.id_user = tb_barang_keluar.id_pengguna where year(tb_barang_keluar.tgl_keluar) = year(now()) order by tb_barang_keluar.tgl_keluar desc' or die("Cannot Access item");
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
$idb = $records->{"id_barang"};
$jmlk = $records->{"jumlah_barang_keluar"};
$ket = $records->{"keterangan"};
$jur = $records->{"id_jurusan"};
$pgn = $records->{"id_pengguna"};
$nb = $records->{"nama_barang"};
$admin = $records->{"id_user"};
$isi = "Barang Keluar ".$nb." Sebanyak ".$jmlk;
$query = "INSERT INTO tb_barang_keluar (id_barang, jumlah_barang_keluar, keterangan, id_jurusan, id_pengguna, tgl_keluar) values ('$idb','$jmlk','$ket','$jur','$pgn',NOW())";
$query1 = "INSERT INTO notif (id_notif,jenis,isi,tgl,admin,status) values ('','Menambahkan','$isi',now(),'$admin','1')";
$query3 = "SELECT jumlah_barang from tb_barang where id_barang = '$idb'";
$res = $conn->query($query3);
while($r=mysqli_fetch_array($res)){
	$jmlb = $r['jumlah_barang'];
	$jmlb = $jmlb - $jmlk;
}
$query4 = "UPDATE tb_barang set jumlah_barang = '$jmlb' where id_barang = '$idb'";
if($conn->query($query) == TRUE && $conn->query($query1) == TRUE && $conn->query($query4) == TRUE){
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
$idbm = $records->{"id_brg_keluar"};
$jmlk = $records->{"jumlah_barang_keluar"};
$nb = $records->{"nama_barang"};
$admin = $_GET['iduser'];
$isi = "Barang Keluar ".$nb." Sebanyak ".$jmlk;
$query = "DELETE FROM tb_barang_keluar where id_brg_keluar = '$idbm'";
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
$idbm = $records->{"id_brg_keluar"};
$jml = $records->{"jumlah_barang_keluar"};
$ket = $records->{"keterangan"};
$idj = $records->{"id_jurusan"};
$query = "UPDATE tb_barang_keluar set jumlah_barang_keluar = '$jml', keterangan = '$ket', id_jurusan = '$idj' where id_brg_keluar = '$idbm'";
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

}
?>