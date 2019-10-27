<?php
include "../config.php";
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	// print_r($_POST);
	// $token = uniqid();
	//sob validation kora lagbe noyto response er object dhora jabe na -_-
	// $token = $data['token'];

	if (!empty($data['token'])) {
		$item_id = $data['item_id'];
		$item_name = $data['item_name'];
		$price = $data['price'];
		$category = $data['category'];
		$description = $data['description'];

		$iq = "UPDATE `items` SET `item_name`='$item_name',`price`='$price',`category`='$category',`description`='$description' WHERE item_id='$item_id'";
		if (mysqli_query($con, $iq)) {
			$data['code'] = 'item info  updated';
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
