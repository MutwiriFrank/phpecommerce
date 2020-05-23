<?php

session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
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
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<h1>Customer Order details</h1>
						<hr/>
						<?php
							include_once("db.php");
							$user_id = $_SESSION["uid"];
							$orders_list = "SELECT o.order_id,o.user_id,o.product_id,o.qty,o.trx_id,o.p_status,p.product_title,p.product_price,p.product_image FROM orders o,products p WHERE o.user_id='$user_id' AND o.product_id=p.product_id";
							$query = mysqli_query($conn,$orders_list);
							if (mysqli_num_rows($query) > 0) {
								while ($row=mysqli_fetch_array($query)) {
									?>
										<div class="row">
											<div class="col-md-6">
												<img style="float:right;" src="images/<?php echo $row['product_image']; ?>" class="img-responsive img-thumbnail"/>
											</div>
											<div class="col-md-6">
												<table>
													<tr><td>Product Name</td><td><b><?php echo $row["product_title"]; ?></b> </td></tr>
													<tr><td>Product Price</td><td><b><?php echo "Ksh ".$row["product_price"]; ?></b></td></tr>
													<tr><td>Quantity</td><td><b><?php echo $row["qty"]; ?></b></td></tr>
													<tr><td>Transaction Id</td><td><b><?php echo $row["trx_id"]; ?></b></td></tr>
												</table>
											</div>
										</div>
									<?php
								}
							}
						?>
						
					</div>
					<div class="panel-footer"></div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</body>
</html>
















































