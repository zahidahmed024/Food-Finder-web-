<?php
include "../../config.php";
session_start();
print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['name'])) {
		if (strlen($_POST['name']) > 3 && strlen($_POST['name']) < 25) {
			if (!empty($_POST['password'])) {
				if ($_POST['password'] == $_POST['re_password']) {
					if (strlen($_POST['password']) > 4 && strlen($_POST['password']) < 10) {
						if (!empty($_POST['email'])) {
							$name = test_input($_POST["name"]);
							$email = test_input($_POST["email"]);
							$password = test_input($_POST["password"]);

							$query = "SELECT `id`, `uniq_id`, `name`, `email`, `password`, `token`, `v_id` FROM `visitor` WHERE email='$email'";

							if (mysqli_num_rows(mysqli_query($con, $query)) > 0) {
								$_SESSION['Message'] = "email already registered";
								header('location:signup.php');
							} else {
								$uniq_id = uniqid();
								$token = uniqid();
								$v_id = 0;
								$in_query = "INSERT INTO `visitor`(`id`, `uniq_id`, `name`, `email`, `password`, `token`, `v_id`) VALUES (null,'$uniq_id','$name','$email','$password','$token','$v_id')";
								if (mysqli_query($con, $in_query)) {
									// echo "hoise";
									$_SESSION['Message'] = "signup successfull";
									header('location:homepage.php');
								} else {
									$_SESSION['Message'] = "enternal error";
									header('location:registration.php');
								}

								// echo "gsdfsdf";
								// echo $name;
								// echo $email;
								// echo $password;
								// echo $v_id;
							}

						} else {
							$_SESSION['Message'] = "Email Required";
							header('location:signup.php');
						}
					} else {
						$_SESSION['Message'] = "password should be 5-10";
						header('location:signup.php');
					}
				} else {
					$_SESSION['Message'] = "Password does not match";
					header('location:signup.php');
				}
			} else {
				$_SESSION['Message'] = "Password can't be empty";
				header('location:signup.php');
			}
		} else {
			$_SESSION['Message'] = "User name must be 3 - 25";
			header('location:signup.php');
		}
	} else {
		$_SESSION['Message'] = "user name can't be empty";
		header('location:signup.php');
	}
} else {
	$_SESSION['Message'] = "Opps something going wrong!";
	header('location:registration.php');
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>