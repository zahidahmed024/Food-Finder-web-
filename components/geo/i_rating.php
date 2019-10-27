<?php
include "../../config.php";
session_start();
print_r($_GET);
if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$taste = $_GET['rating'];
	$com_price = $_GET['rating2'];
	$item_id = $_GET['item_id'];
	$res_id = $_GET['res_id'];
	$visitor_id = $_SESSION['uniq_id'];

	// echo $visitor_id;

	$query = "SELECT * FROM `item_rating` WHERE  visitor_id ='$visitor_id' and item_id='$item_id' ";
	if (mysqli_num_rows(mysqli_query($con, $query)) > 0) {
		$i_query = "UPDATE `item_rating` SET `com_price`='$com_price',`taste`='$taste' WHERE item_id='$item_id' and visitor_id='$visitor_id' ";
		if (mysqli_query($con, $i_query)) {
			// header("location:javascript://history.go(-1)");
			header("location:item.php?item_id=$item_id&&res_id=$res_id");
		}
	} else {
		echo 'string  sss';
		$i_query = "INSERT INTO `item_rating`(`id`, `item_id`, `visitor_id`, `com_price`, `taste`) VALUES (null,'$item_id','$visitor_id','$com_price','$taste')";
		if (mysqli_query($con, $i_query)) {
			// header("location:javascript://history.go(-1)");
			header("location:item.php?item_id=$item_id&&res_id=$res_id");
		}
	}
}

?>