<?php
#this is Login form page , if user is already logged in then we will not allow user to access this page by executing isset($_SESSION["uid"])
#if below statment return true then we will send user to their profile.php page
if (isset($_SESSION["uid"])) {
	header("location:profile.php");
}
//in action.php page if user click on "ready to checkout" button that time we will pass data in a form from action.php page
if (isset($_POST["login_user_with_product"])) {
	//this is product list array
	$product_list = $_POST["product_id"];
	//here we are converting array into json format because array cannot be store in cookie
	$json_e = json_encode($product_list);
	//here we are creating cookie and name of cookie is product_list
	setcookie("product_list",$json_e,strtotime("+1 day"),"/","","",TRUE);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="author" content="@timooz">
   
  <!-- js -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/all.js"></script>
  <script src="main.js"></script>

   <!-- css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">  
  <link rel="stylesheet"  href="assets/css/style.css">
  <link rel="stylesheet"  href="assets/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>Cart</title>

  </head>
  
  <body>
  <div class="wait overlay">
    <div class="loader"></div>
  </div>

   <!-- Navbar -->
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
      <a class="navbar-brand" href="#" style="margin-right: 50px">Maugu Store</a>

    <!-- Toggler/collapsibe Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="collapse">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link"  href="index.php" style="margin-right: 30px"><span class="fa fa-home"></span>&nbsp;Home</a>
        </li>
          <li class="nav-item">
              <a class="nav-link"  href="index.php" style="margin-right: 60px"><span class="fa fa-clone"></span>&nbsp;Products</a>
          </li>
         </ul>
      </div>
  </nav>
	<p><br/></p>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="signup_msg">
				<!--Alert from signup form-->
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-header" style="text-align: center; background: #235b97">Customer Login Form</div>
					<div class="card-body">
						<!--User Login Form-->
						<form onsubmit="return false" id="login">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" required/>
							<label for="email">Password</label>
							<input type="password" class="form-control" name="password" id="password" required/>
							<p><br/></p>
							<a href="#" style="color:#333; list-style:none;">Forgotten Password</a><input type="submit" class="btn btn-success" style="float:right;" Value="Login">
							<!--If user dont have an account then he/she will click on create account button-->
							<div><a href="customer_registration.php?register=1" class="text-info">Create a new account?</a></div>						
						</form>
				</div>
				<div class="card-footer"><div id="e_msg"></div></div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</body>
</html>

