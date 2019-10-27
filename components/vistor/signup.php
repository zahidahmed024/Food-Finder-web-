<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>food tracer</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.lineicons.com/1.0.0/LineIcons.min.css">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css" />
	<link rel="stylesheet" type="text/css" href="style/signup.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="images/logos.svg" width="130" height="60" class="d-inline-block align-top" alt="">
  </a>
</nav>
<div class="container-fluid bg">
	<div class="container">
		<h1 align="center" style="color: red"><?php session_start();
if (!empty($_SESSION['Message'])) {
	echo $_SESSION['Message'];
	unset($_SESSION['Message']);
}
?></h1>
	    <div class="row">
		<div class="container bd col-md-4">
		        <div class="card regform wow bounce animated b" data-wow-delay="0.05s">
		            <div class="card-body regform">
		               <div class="myform form ">
                        <div class="logo mb-3">
                           <div class="col-md-12 text-center">
                              <h1 class="sign">Signup</h1>
                           </div>
                        </div>
                        <form action="registration.php" method="post">
                           <div class="form-group">
                              <label for="exampleInputEmail1">First Name</label>
                              <input type="text"  name="name" class="form-control" id="firstname" aria-describedby="emailHelp" placeholder="length should be 3-25" required="">
                           </div>

                           <div class="form-group">
                              <label for="exampleInputEmail1">Email address</label>
                              <input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email"
                              required>
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Password</label>
                              <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="length should be 5-10" required>
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Repeat Password</label>
                              <input type="password" name="re_password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Repeat Password" required>
                           </div>
                           <div class="col-md-12 text-center mb-3">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Sign Up</button>
                           </div>

                            </form>
		            </div>
		        </div>
		    </div>
	</div>
	</div>
</div>
</div>

</body>
</html>