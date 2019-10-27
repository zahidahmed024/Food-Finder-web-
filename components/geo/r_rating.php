<?php
include "../../config.php";
session_start();
print_r($_GET);
if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$environment = $_GET['rating'];
	$service = $_GET['rating2'];
	$res_id = $_GET['res_id'];
	$visitor_id = $_SESSION['uniq_id'];

	$total = ($environment + $service) / 2;

	$query = "SELECT * FROM `res_rating` WHERE  visitor_id ='$visitor_id' and res_id='$res_id' ";
	if (mysqli_num_rows(mysqli_query($con, $query)) > 0) {
		$i_query = "UPDATE `res_rating` SET `environment`='$environment',`service`='$service' ,`total`='$total' WHERE res_id='$res_id' and visitor_id='$visitor_id' ";
		if (mysqli_query($con, $i_query)) {
			// header("location:javascript://history.go(-1)");
			header("location:restaurant.php?res_id=$res_id");
		}
	} else {
		// echo 'string  sss';
		$i_query = "INSERT INTO `res_rating`(`id`, `res_id`, `visitor_id`, `environment`, `service`,`total`) VALUES (null,'$res_id','$visitor_id','$environment','$service','$total')";
		if (mysqli_query($con, $i_query)) {
			// header("location:javascript://history.go(-1)");
			header("location:restaurant.php?res_id=$res_id");
		}
	}
}

?>