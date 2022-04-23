<?php
include '../koneksi.php';

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$deskripsi = $_POST['desc'];

	$sql = "INSERT INTO kritik (deskripsi) VALUES ('$deskripsi')";

	if(mysqli_query($con,$sql)){
		echo "Berhasil";
	}else{
		echo "Gagal";
	}

	mysqli_close($con);
}

