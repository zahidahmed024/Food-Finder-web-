<?php
include "../config.php";
header("Content-type: application/json");
// $data = json_decode(file_get_contents("php://input"), true);
if ($_SERVER['REQUEST_METHOD'] == "GET") {

	$token = $_GET['token'];

	$query = "SELECT * FROM `info` WHERE token='$token' ";
	$q = mysqli_query($con, $query);
	while ($row = mysqli_fetch_assoc($q)) {
		$data = $row;
	}
	echo json_encode($data);
} else {

	$data['error'] = "invalid request";
	echo json_encode($data);

}

?>