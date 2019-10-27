<?php
session_start();
?>
<?php
if (!empty($_SESSION['uniq_id'])) {
	?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> food tracer </title>
<script src="lib/vue.js" type="text/javascript"></script>
<script src="lib/googleMap.js" type="text/javascript"></script>
<script src="lib/lodash.js" type="text/javascript"></script>
<script src="lib/axios.js" type="text/javascript"></script>



<script src="bootstrap4/jquery/jquery.js"  crossorigin="anonymous"></script>
<script src="bootstrap4/cloudjs/cloud.js" crossorigin="anonymous"></script>
<script src="bootstrap4/js/bootstrap.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css">
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
<link rel="stylesheet" href="style/style.css">



<style type="text/css">
  /*body{
    background-color: red;
    margin: 0 auto;
    padding: 0;
    width: 100%;
  }*/
  /*.nav{
    overflow: hidden;
    background-color: blue;
}*/
</style>
</head>
<body>

<!-- ------------------------div starts---------------------- -->
<div id="test2">


<nav class="mb-1 navbar navbar-expand-lg navbar-dark info-color">
  <a class="navbar-brand" href="http://localhost/pro/zahid_api/components/geo/testing.php">
    <img src="logos.svg" width="150" height="50" class="d-inline-block align-top" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">
        <a style="color:black "class="nav-link dropdown-toggle cl" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-user"></i><?php
if (!empty($_SESSION['name'])) {
		echo $_SESSION['name'];

	}
	?></a>
        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
          <!-- <a class="dropdown-item" href="#">My account</a> -->
          <a class="dropdown-item" href="logout.php">Log out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>


<?php } else {
	header('location:../vistor/homepage.php');
}
?>
