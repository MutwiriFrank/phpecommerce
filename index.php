<?php
session_start();
if(isset($_SESSION["uid"])){
	header("location:profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="user-scalable=1, width=device-width, initial-scale=1, maximum-scale=2.0">
<meta name="author" content="@timooz">
   
  <!-- js -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/all.js"></script>
  <script src="main.js"></script>

   <!-- css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">  
  <link rel="stylesheet"  href="assets/css/style.css">
  <link rel="stylesheet"  href="assets/css/all.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<title>Maugu Store</title>
		
<script type="text/javascript">
	  function searcDh(){
  			$("#get_product").html("<h3>Loading...</h3>");
		var keyword = $("#search").val();
		if(keyword != ""){
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{search:1,keyword:keyword},
			success	:	function(data){ 
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
  }
}

</script>
	</head>
	<body>
		<div class="wait overlay">
			<div class="loader"></div>
		</div>

    <!-- Navbar -->
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
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
     		    <li class="nav-item">
     		    	<form class="form-inline" action="">
     		    		<input class="form-control" type="text" id="search" placeholder="Search" onkeypress="searcDh()" style="width: 68%; margin-right: 13px;">
         				<button class="btn btn-primary" type="submit" id="search_btn"><span class="fa fa-search"></span></button>
        			</form>
      			</li>
      		</ul>
      			<ul class="navbar-nav ml-auto">
    			<li class="nav-item dropdown order-1">
    				<a href="#" class="nav-link" data-toggle="dropdown"><span class="fa fa-shopping-cart"></span>&nbsp;Cart<span class="badge badge-danger">0</span></a>
    				<ul class="dropdown-menu dropdown-menu-right mt-2" style="width:400px;">
						<div class="card">
							<div class="card-header bg-success">
								<div class="row">
									<div class="col-md-3">Sl.No</div>
									<div class="col-md-3">Product Image</div>
									<div class="col-md-3">Product Name</div>
									<div class="col-md-3">Price in Ksh.</div>
								</div>
							</div>
							<div class="card-body">
								<div id="cart_product">
								<!--<div class="row">
									<div class="col-md-3">Sl.No</div>
									<div class="col-md-3">Product Image</div>
									<div class="col-md-3">Product Name</div>
									<div class="col-md-3">Price in Ksh.</div>
								</div>-->
								</div>
							</div>
							<div class="card-footer"></div>
						</div>
					</ul>
				</li>
				
				<li class="nav-item dropdown order-1">
    				<a href="#" class="nav-link" data-toggle="dropdown"><span class="fa fa-user"></span>&nbsp;Signup</a>
						<div class="dropdown-menu dropdown-menu-right mt-2" style="width:320px;">
							<div class="card">
								<div class="card-header text-white" style="text-align: center; background: #235b97">Sign Up</div>
								<div class="card-body">

									<form id="signup_form" onsubmit="return false" action="profile.php">
									<div class="row">
										<div class="col-md-6">
											<label for="f_name">First Name</label>
											<input type="text" id="f_name" name="f_name" class="form-control">
										</div>

										<div class="col-md-6">
											<label for="f_name">Last Name</label>
											<input type="text" id="l_name" name="l_name"class="form-control">
										</div>
										</div>
							
										<div class="row">
											<div class="col-md-12">
												<label for="email">Email</label>
												<input type="text" id="email" name="email"class="form-control">
											</div>
										</div>
									<div class="row">
										<div class="col-md-12">
											<label for="password">Password</label>
											<input type="password" id="password" name="password"class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<label for="repassword">Confirm Password</label>
											<input type="password" id="repassword" name="repassword"class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<label for="mobile">Mobile</label>
											<input type="text" id="mobile" name="mobile"class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<label for="address1">Address Line 1</label>
											<input type="text" id="address1" name="address1"class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<label for="address2">Address Line 2</label>
											<input type="text" id="address2" name="address2"class="form-control">
										</div>
									</div>
									<p><br/></p>
									<div class="row">
										<div class="col-md-12">
											<input style="width:100%;" value="Sign Up" type="submit" id="signup_button"class="btn btn-success btn-lg">
										</div>
									</div>
						
							</form>
						</div>
						  <div class="card-footer"></div>
						</div>
						</div>
					</li>

				<li class="nav-item dropdown order-1">
					<a href="#" class="nav-link" data-toggle="dropdown"><i class="fa fa-user"></i>&nbsp;Login</a>
						<div class="dropdown-menu dropdown-menu-right mt-2" style="width:320px;">
							<div class="card">
								<div class="card-header text-white" style="text-align: center; background: #235b97">Login</div>
								<div class="card-body">
									<form onsubmit="return false" id="login">
										<label for="email">Email</label>
										<input type="email" class="form-control" name="email" id="email" required/>
										<label for="email">Password</label>
										<input type="password" class="form-control" name="password" id="password" required/>
										<p><br/></p>
										<a href="#" data-toggle="modal" data-target="#modalPassword" style="color:blue; list-style:none;">Forgotten Password?</a><input type="submit" class="btn btn-success" style="float:right;">
									</form>
								</div>
								<div class="card-footer bg-default" id="e_msg"></div>
							</div>
						</div>
					</li>
			</ul>
  		</div>
	</nav>

	<div id="modalPassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Forgot password</h3>
                <button type="button" class="close font-weight-light" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Reset your password..</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>			

	<p><br/></p>
	<p><br/></p>

	<div class="d-flex justify-content-center mt-3"> 
	<ul class="pagination pagination-sm">
			<li class="page-item"><a class="page-link" href="#"><<</a></li>
			</ul>   
			  <ul class="pagination pagination-sm" id="pagenoup">
			    <li class="page-item"><a class="page-link" href="#">1</a></li>
		      </ul>
			    <ul class="pagination pagination-sm">
			    <li class="page-item"><a class="page-link" href="#">>></a></li>
			  </ul>
			  <div><span id="result"></span></div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-2 col-xs-12">
				<div id="get_category">
				</div>
				<!--<div class="nav nav-pills nav-stacked">
					<li class="active"><a href="#"><h4>Categories</h4></a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
				</div> -->
				<div id="get_brand">
				</div>
				<!--<div class="nav nav-pills nav-stacked">
					<li class="active"><a href="#"><h4>Brand</h4></a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
				</div> -->
			</div>
			<div class="col-md-8 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-xs-12" id="product_msg">
					</div>
				</div>
				<div class="card" id="scroll">
					<div class="card-header" style="background: #9ebdc8">Products</div>
					<div class="card-body">
						<div id="get_product" class="card-group">
							<!--Here we get product jquery Ajax Request-->
						</div>
						<!--<div class="col-md-4">
							<div class="card">
								<div class="card-header">Samsung Galaxy</div>
								<div class="card-body">
									<img src="images/nokia.jpg"/>
								</div>
								
								<div class="card-footer">
									<div class="card-heading">Ksh.500.00
										<button style="float:right;" class="btn btn-danger btn-xs">AddToCart</button>
									</div>
								</div>
							</div>
						</div> -->						
					</div>
					<div class="card-footer" style="text-align: center; background: #9ebdc8;">&copy; 2019 </div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
		<div class="d-flex justify-content-center mt-3"> 
	<ul class="pagination pagination-sm">
			<li class="page-item"><a class="page-link" href="#"><<</a></li>
			</ul>   
			  <ul class="pagination pagination-sm" id="pagenodn">
			    <li class="page-item"><a class="page-link" href="#">1</a></li>
		      </ul>
			    <ul class="pagination pagination-sm">
			    <li class="page-item"><a class="page-link" href="#">>></a></li>
			  </ul>
	</div>

</body>

</html>

