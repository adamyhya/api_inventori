<?php 
include "koneksi.php";
$callback = $_REQUEST['callback'];
$output = array();
$success = 'false';
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
?>