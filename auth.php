<?php 
include "koneksi.php";
$callback = $_REQUEST['callback'];
$success = 'false';
$uname = $_GET['uname'];
$pwd = $_GET['pwd'];
$query = "SELECT * from tb_user where uname = '$uname' and pwd=md5('$pwd')"  or die("Cannot Access item");
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
?>