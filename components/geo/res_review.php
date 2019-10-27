<?php
include '../../config.php';
if (!empty($_POST['r_cmnt'])) {
	$r_cmnt = $_POST['r_cmnt'];
	$res_id = $_POST['res_id'];
	$visitor_id = $_POST['visitor_id'];
	$sub_review = "INSERT INTO `res_review`(`id`, `res_id`, `visitor_id`, `cmnt`) VALUES (null,'$res_id','$visitor_id','$r_cmnt')";
	if (mysqli_query($con, $sub_review)) {
		header("location:restaurant.php?res_id=$res_id");
	}

} else {

	header("location:javascript://history.go(-1)");
}
?>