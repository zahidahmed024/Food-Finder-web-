<?php
session_start();
include "../../config.php";
// print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['email']) && !empty($_POST['password'])) {
		$email = test_input($_POST['email']);
		$password = test_input($_POST['password']);

		$query = "SELECT * FROM `visitor` WHERE email='$email' and password='$password' ";
		if ($result = mysqli_query($con, $query)) {
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$_SESSION['uniq_id'] = $row['uniq_id'];
				$_SESSION['name'] = $row['name'];
				header('location:../geo/testing.php');
			} else {
				$_SESSION['Message'] = "invalid email/password";
				header('location:homepage.php');
			}
		} else {
			$_SESSION['Message'] = "enternal problem";
			header('location:homepage.php');
		}
	} else {
		$_SESSION['Message'] = "Opps something going wrong!";
		header('location:homepage.php');
	}

} else {
	$_SESSION['Message'] = "Opps something going wrong!";
	header('location:homepage.php');
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>