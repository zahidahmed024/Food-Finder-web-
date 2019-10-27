<?php
session_start();
if (!empty($_SESSION['uniq_id']) && !empty($_SESSION['name'])) {
	unset($_SESSION['uniq_id']);
	unset($_SESSION['name']);
	header('location:../vistor/homepage.php');
}

?>