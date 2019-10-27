<?php
include "../config.php";
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$token = $data['token'];
	$lon = $data['lon'];
	$lat = $data['lat'];
	// print_r($_POST);
	// $token = uniqid();

	if (!empty($lon) && !empty($lat)) {
		$iq = "UPDATE info SET lat='$lat',lon='$lon' WHERE token='$token'";
		if (mysqli_query($con, $iq)) {
			$data['code'] = 'loc updated';
			echo json_encode($data);

		} else {
			$data['code'] = 'query not executed';
			echo json_encode($data);
		}

	} else {
		$data['code'] = 'argument missing';
		echo json_encode($data);
	}

} else {
	$data['code'] = 'invalid request';
	echo json_encode($data);
}

?>
