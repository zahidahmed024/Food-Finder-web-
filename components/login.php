<?php
include "../config.php";
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$email = $data['email'];
	$password = $data['password'];
	if (!empty($email) && !empty($password)) {
		$iq = "SELECT * FROM `user` WHERE email='$email' and password ='$password'";
		if ($result = mysqli_query($con, $iq)) {

			if (mysqli_num_rows($result) > 0) {
				$data['success'] = mysqli_fetch_assoc($result);
				echo json_encode($data);
			} else {
				$data['failed'] = 'wrong username and password';
				echo json_encode($data);
			}

		} else {
			$data['failed'] = 'query not worked';
			echo json_encode($data);
		}
	} else {
		$data['failed'] = 'missing arguments';
		echo json_encode($data);
	}

} else {
	$data['failed'] = 'invalid request';
	echo json_encode($data);
}

?>
