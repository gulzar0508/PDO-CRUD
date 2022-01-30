<?php
$NO_REDIRECT = 1;
include "includes/common.php";

$message = "";
if(isset($_GET['err']))
{
	$message = NotifyThis("Invalid email or password", "error");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
		<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-5 mx-auto">
					<div id="first">
						<div class="myform form ">
							<?php echo $message; ?>
							<div class="logo mb-3">
								<div class="col-md-12 text-center">
									<h1>Login</h1>
								</div>
							</div>
							<form action="auth.php" method="post" name="login">
								<input type="hidden" name="mode" id="mode" value="REGISTER" /	>
								<div class="form-group">
									<label for="exampleInputEmail1">Email address</label>
									<input type="email" name="txtemail" autofocus="true" class="form-control" id="txtemail" aria-describedby="emailHelp" placeholder="Enter email">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Password</label>
									<input type="password" name="txtpassword" id="txtpassword"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
								</div>
								<div class="col-md-12 text-center ">
									<button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
								</div>
								<div class="form-group">
									<p class="text-center">Don't have account? <a href="javascript:;"  id="signup">Sign up here</a></p>
								</div>
							</form>
						</div>
					</div>
					<div id="second">
						<div class="myform form ">
							<div class="logo mb-3">
								<div class="col-md-12 text-center">
									<h1 >Signup</h1>
								</div>
							</div>
							<form action="register.php" name="registration" method="post">
								<input type="hidden" name="mode" id="mode" value="REGISTER" /	>
								<div class="form-group">
									<label for="exampleInputEmail1">Full Name</label>
									<input type="text"  name="firstname" class="form-control" id="firstname" aria-describedby="emailHelp" placeholder="Enter fullname">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Email address</label>
									<input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Password</label>
									<input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
								</div>
								<div class="col-md-12 text-center mb-3">
									<button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Sign Up</button>
								</div>
								<div class="col-md-12 ">
									<div class="form-group">
										<p class="text-center"><a href="javascript:;"  id="signin">Already have an account?</a></p>
									</div>
								</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>
		<script type="text/javascript" src="assets/js/common.js"></script>
	</body>
</html>