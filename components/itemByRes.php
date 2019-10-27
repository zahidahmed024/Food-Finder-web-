<?php
include "../config.php";
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == "GET") {

	$query = "SELECT * FROM `items` where token='$token' ";

	$q = mysqli_query($con, $query);
	$count = mysqli_num_rows($q);
	if ($count > 0) {
		while ($row = mysqli_fetch_assoc($q)) {

			$data['items'][] = $row;

		}
		echo json_encode($data);

	} else {
		$data['error'] = "no data";
		echo json_encode($data);
	}

} else {

	$data['error'] = "invalid request";
	echo json_encode($data);

}

?>

