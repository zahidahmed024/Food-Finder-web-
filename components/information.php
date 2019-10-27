<?php
include "../config.php";
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');
// header("Accept : application/json	");
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	// print_r($_POST);
	// $token = uniqid();
	//sob validation kora lagbe noyto response er object dhora jabe na -_-
	// $token = $data['token'];

	if (!empty($data['token'])) {
		$restaurant_name = $data['restaurant_name'];
		$description = $data['description'];
		$starting_time = $data['starting_time'];
		$ending_time = $data['ending_time'];
		$contact = $data['contact'];
		$token = $data['token'];

		$iq = "UPDATE info SET restaurant_name='$restaurant_name',description='$description',starting_time='$starting_time',ending_time='$ending_time',contact='$contact' WHERE token='$token'";
		if (mysqli_query($con, $iq)) {
			$data['code'] = 'info  updated';
			echo json_encode($data);

		} else {
			$data['code'] = 'query not executed';
			echo json_encode($data);
		}

	} else {
		$data['code'] = 'token missing';
		echo json_encode($data);
	}

} else {
	$data['code'] = 'invalid request';
	echo json_encode($data);
}

?>
