<?php
header("Content-type: application/json");
// header("Accept : application/json");
header('Access-Control-Allow-Origin:*');
include "../config.php";
$data = json_decode(file_get_contents("php://input"), true);
// print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$name = $data['name'];
	$email = $data['email'];
	$password = $data['password'];
	$password_confirmation = $data['password_confirmation'];
	$token = uniqid();
	if (!empty($name) && !empty($email) && !empty($password) && !empty($password_confirmation)) {
		if ($password != $password_confirmation) {
			$data['response'] = 'password doesnt match';
			echo json_encode($data);
		} else {
			$iq = "INSERT INTO `user`(`id`, `name`, `email`, `password`, `token`) VALUES (null,'$name','$email','$password','$token')";
			if (mysqli_query($con, $iq)) {
				// $data['response'] = 'user inserted';
				// echo json_encode($data);
				$info = "INSERT INTO `info`(`id`, `token`, `restaurant_name`, `description`, `image`, `lon`, `lat`, `starting_time`, `ending_time`, `contact`) VALUES (null,'$token','not_set','not_set','not_set','not_set','not_set','not_set','not_set','not_set')";

				if (mysqli_query($con, $info)) {
					// update res_rating set raters = concat(raters,',ahmed,') WHERE id=1
					//
					$rating = "INSERT INTO `res_rating`(`id`, `res_id`, `environment`, `service`, `raters`) VALUES (null,'$token','','','')";

					if (mysqli_query($con, $rating)) {
						$data['response'] = 'user inserted';
						echo json_encode($data);

					} else {
						$data['response'] = 'not inserted';
						echo json_encode($data);

					}

				}
			} else {
				$data['response'] = 'user not inserted';
				echo json_encode($data);
			}
		}

	} else {
		$data['response'] = 'missing arguments';
		echo json_encode($data);
	}

} else {
	$data['response'] = 'invalid request';
	echo json_encode($data);
}

?>
