<?php

session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
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
  <script src="assets/js/main.js"></script>
  <script src="assets/js/all.js"></script>
  <script src="main.js"></script>
  <title>Navbar</title>
   <!-- css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">  
  <link rel="stylesheet"  href="assets/css/style.css">
  <link rel="stylesheet"  href="assets/css/all.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  <

</head>

<body>
	<div class="wait overlay">
		<div class="loader"></div>
	</div>
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between flex-nowrap flex-row fixed-top">

  <button class="navbar-toggler align-self-start" type="button"> 
    <span class="navbar-toggler-icon"></span>
  </button>

        <a href="index.php" class="navbar-brand float-left"><span class="fa fa-home"></span>&nbsp;Maugu Store</a>
        

 <!-- Collapse Navbar -->
  <div class="collapse navbar-collapse bg-dark p-3 p-lg-0 mt-5 mt-lg-0 d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-end mobileMenu" id="navbarSupportedContent">
  </div>
<ul class="nav navbar-nav flex-row float-right">
           <li class="nav-item dropdown order-1">
				<a href="#" class="nav-link" data-toggle="dropdown"><span class="fa fa-user"></span>&nbsp;<?php echo "Hi,".$_SESSION["name"]; ?></a>
					<ul class="dropdown-menu dropdown-menu-right mt-2">
						<li><a href="cart.php" style="text-decoration:none; color:blue;"><span class="fa fa-shopping-cart"></span>Cart</a></li>
						<li class="divider"></li>
						<li><a href="customer_order.php" style="text-decoration:none; color:blue;">Orders</a></li>
						<li class="divider"></li>
						<li><a href="" style="text-decoration:none; color:blue;">Change Password</a></li>
						<li class="divider"></li>
						<li><a href="logout.php" style="text-decoration:none; color:blue;">Logout</a></li>
					</ul>
				</li>
          <li class="nav-item dropdown">
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
      
        </ul>
	    </ul>
	</div>
</nav>
	
	<p><br/></p>
	
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
					<div class="card-header">Products</div>
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
					<div class="card-footer" style="text-align: center;">&copy; 2019 </div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<ul class="pagination" id="pageno">
						<li><a href="#">1</a></li>
					</ul>
				</center>
			</div>
		</div>
	</div>
</body>
</html>
