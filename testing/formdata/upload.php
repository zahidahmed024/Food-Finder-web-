<?php
include "../../config.php";
$target_dir = $_POST['folder'] . '/';
$token = $_POST['token'];
$ch = $_POST['cat'];
// echo $target_dir;
if (!is_dir($target_dir)) {
	mkdir($target_dir, 0755);
}
$target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake imagee

// echo $_FILES["image"]["size"];
if (isset($_POST["submit"])) {
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if ($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}
// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}
// Check file size
if ($_FILES["image"]["size"] > 5000000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif") {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
		$lastfile = "https://zahid8164.000webhostapp.com/zahid_api/components/uploadImage/" . $target_file;
		if ($ch = "item") {
			$item_name = $_POST['item_name'];
			$price = $_POST['price'];
			$category = $_POST['category'];
			$description = $_POST['description'];

			$iq = "INSERT INTO `items`(`id`, `token`, `item_name`, `image`, `price`, `category`, `description`) VALUES (null,'$token','$item_name','$lastfile','$price','$category','$description')";
			mysqli_query($con, $iq);
		}
		if ($ch = "cover") {
			$uq = "UPDATE `info` SET `image`='$lastfile' WHERE token ='$token'";
			mysqli_query($con, $uq);
		}

	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}

// ?>