<?php
	session_start();
	$ip_add = getenv("REMOTE_ADDR");
	require 'db.php';

	// Adding item into cart
	if(isset($_POST["addToCart"])){
		
	 $p_id = $_POST["proId"]; 
	 $pro_name = $_POST["proName"];
	 $pro_price = $_POST["proPrice"];
	 $pro_image = $_POST["proImg"];
	 $qty = 1;
		
	 if(isset($_SESSION["uid"])){

	 $user_id = $_SESSION["uid"];

	 $stmt = $conn->prepare("SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'");
	 $stmt->execute();
	 $result = $stmt->get_result();
	 $count = $result->fetch_assoc();
	 if($count > 0){
		 echo "
			<div class='alert alert-warning'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Product already added into the cart Continue Shopping..!</b>
			</div>
			";
	 } else {
	 $stmt = $conn->prepare("INSERT INTO cart (p_id,user_id,ip_add,product_image,product_name,product_price,qty,total_price) VALUES (?,?,?,?,?,?,?,?)");
	 $stmt->bind_param("iissssis",$p_id,$user_id,$ip_add,$pro_image,$pro_name,$pro_price,$qty,$pro_price);
	 $stmt->execute();

		 echo "
			 <div class='alert alert-success'>
				 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				 <b>Product Added To Cart Successfully..!</b>
			 </div>";
		 exit();
	  }
	}
	 else {
	 $stmt = $conn->prepare("SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1");
	 $stmt->execute();
	 $result = $stmt->get_result();
	 $count = $result->fetch_assoc();
	 if($count > 0) {

		 echo "
			 <div class='alert alert-warning'>
					 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					 <b>Product already added into the cart Continue Shopping..!</b>
			 </div>";
		 exit();
	 } 
	 else {
	 $user_id = -1;	
	 $stmt = $conn->prepare("INSERT INTO cart (p_id,user_id,ip_add,product_image,product_name,product_price,qty,total_price) VALUES (?,?,?,?,?,?,?,?)");
	 $stmt->bind_param("iissssis",$p_id,$user_id,$ip_add,$pro_image,$pro_name,$pro_price,$qty,$pro_price);
	 $stmt->execute();
		 echo "
			 <div class='alert alert-success'>
				 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				 <b>Product Added To Cart Successfully..!</b>
			 </div>";
		 exit();
		}
			
	}
				
	}
	
	// Delete cart item
	if (isset($_GET['remove'])) {
	$id = $_GET['remove'];

	 $stmt = $conn->prepare("DELETE FROM cart WHERE id=?");
     $stmt->bind_param("i",$id);
     $stmt->execute();

     $_SESSION['showAlert'] = 'block';
     $_SESSION['message'] = 'Product removed from the cart..!';
     header('location:cart.php');
              
	}

 	// Clear all cart items
	if (isset($_GET['clear'])) {
	 $stmt = $conn->prepare("DELETE FROM cart");
     $stmt->execute();

     $_SESSION['showAlert'] = 'block';
     $_SESSION['message'] = 'All Products removed from the cart..!';
     header('location:cart.php');

	 }

 	// Update cart item price
 	if (isset($_POST['qty'])) {
 	 $qty = $_POST['qty'];
 	 $pid = $_POST['pid'];
 	 $pprice = $_POST['pprice']; 

 	 if ($qty < 1) {
			$qty = 1;
		};

 	 $tprice = $qty*$pprice;

	 $stmt = $conn->prepare("UPDATE cart SET qty=?, total_price=? WHERE p_id=?");
     $stmt->bind_param("isi",$qty,$tprice, $pid);
     $stmt->execute();

	 }


 //ECOMMERCE STARTS HERE
 if(isset($_POST["category"])){
	$category_query = "SELECT * FROM categories";
	$run_query = mysqli_query($conn,$category_query) or die(mysqli_error($conn));
	echo "
		<div class='card-primary'>
			<div class='card-header text-white' style= 'background: #235b97'><h4>Categories</h4></div>
			<div class='card-body'>
	";
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$cid = $row["cat_id"];
			$cat_name = $row["cat_title"];
			echo " 
					<button class='btn btn-default btn-block category text-info  text-left' cid='$cid'>$cat_name</button>
			";
		}
		echo "</div>";
	}
}
	if(isset($_POST["brand"])){
		$brand_query = "SELECT * FROM brands";
		$run_query = mysqli_query($conn,$brand_query);
		echo "
			<div class='card'>
				<div class='card-header text-white' style= 'background: #235b97'><h4>Brands</h4></div>
				<div class='card-body'>
		";
		if(mysqli_num_rows($run_query) > 0){
			while($row = mysqli_fetch_array($run_query)){
				$bid = $row["brand_id"];
				$brand_name = $row["brand_title"];
				echo "
						<button class='btn btn-default btn-block selectBrand text-info  text-left' bid='$bid'>$brand_name</button>
				";
			}
			echo "</div>";
		}
	}
	if(isset($_POST["page"])){
		$sql = "SELECT * FROM products";
		$run_query = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($run_query);
		$pageno = ceil($count/12);
		for($i=1;$i<=$pageno;$i++){
			echo "
				<li class='page-item'><a class='page-link' href='#' page='$i' id='page'>$i</a></li>
			";
		}
	}
	if(isset($_POST["getProduct"])){
		$limit = 12;
		if(isset($_POST["setPage"])){
			$pageno = $_POST["pageNumber"];
			$start = ($pageno * $limit) - $limit;
		}else{ 
			$start = 0;
		}
		$product_query = "SELECT * FROM products LIMIT $start,$limit";
		$run_query = mysqli_query($conn,$product_query);
		if(mysqli_num_rows($run_query) > 0){
			while($row = mysqli_fetch_array($run_query)){
				$pro_id    = $row['product_id'];
				$pro_cat   = $row['product_cat'];
				$pro_brand = $row['product_brand'];
				$pro_name = $row['product_name'];
				$pro_desc = $row['product_desc'];
				$pro_price = $row['product_price'];
				$pro_image = $row['product_image'];
				echo "
					<div class='col-md-3'>
								<div class='card mb-3'>
									<div class='card-header' style='text-align: center; background: #ececec'>$pro_name</div>
									<div class='card-body text-center'>
										<img src='images/$pro_image' style='width:160px; height:150px;'>
									</div>
									<div class='card-heading'><small><dt>$pro_desc</dt></small>
									</div>
									<div class='card-footer' style='background: #ececec'>
										<div class='card-heading'><small>Ksh.$pro_price</small>
											<small><button pid='$pro_id' pname='$pro_name' pprice='$pro_price' pimage='$pro_image' style='float:right;' id='product' class='btn btn-danger btn-sm'><i class='fa fa-cart-plus'></i>&nbsp;Buy</button></small>
										</div>
									</div>
								</div>
							</div>	
				";
			}
		}
	}
	// Select category, Brand and Search Products 
	if(isset($_POST["get_selected_Category"]) 
	if(isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])){
		if(isset($_POST["get_seleted_Category"])){
			$id = $_POST["cat_id"];
			$sql = $conn->prepare("SELECT * FROM products WHERE product_cat = '$id'");
			}
		 else if(isset($_POST["selectBrand"])){
			$id = $_POST["brand_id"];
			$sql = $conn->prepare("SELECT * FROM products WHERE product_brand = '$id'");
			}
		 else {
			$word = trim($_POST["keyword"]);
			$keyword = $word;
			$sql =  $conn->prepare("SELECT * FROM products WHERE product_keywords LIKE '%$keyword%'");
			}
	
		  $sql->execute();
		  $result = $sql->get_result();
		  while($row = $result->fetch_assoc()){
			 $pro_id    = $row['product_id'];
			 $pro_cat   = $row['product_cat'];
			 $pro_brand = $row['product_brand'];
			 $pro_name = $row['product_name'];
			 $pro_desc = $row['product_desc'];
			 $pro_price = $row['product_price'];
			 $pro_image = $row['product_image'];

			echo "<div class='col-md-3'>
								<div class='card mb-3'>
									<div class='card-header' style='text-align: center; background: #ececec'>$pro_name</div>
									<div class='card-body text-center'>
										<img src='images/$pro_image' style='width:160px; height:150px;'>
									</div>
									<div class='card-heading'><small><dt>$pro_desc</dt></small>
									</div>
									<div class='card-footer' style='background: #ececec'>
										<div class='card-heading'><small>Ksh.$pro_price.00</small>
											<small><button pid='$pro_id' pname='$pro_name' pprice='$pro_price' pimage='$pro_image' style='float:right;' id='product' class='btn btn-danger btn-sm'><i class='fa fa-cart-plus'></i>&nbsp;Buy</button></small>
										</div>
									</div>
								</div>
							</div>	
				";
			}
	 	}
	



	//Count User cart item
	if (isset($_POST["count_item"])) {
		//When user is logged in then we will count number of item in cart by using user session id
		if (isset($_SESSION["uid"])) {
			$sql = $conn->prepare("SELECT COUNT(*) AS count_item FROM cart WHERE user_id = $_SESSION[uid]");
		}else{
			//When user is not logged in then we will count number of item in cart by using users unique ip address
			$sql = $conn->prepare("SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0");
		}
		
		$sql->execute();
		$result = $sql->get_result();
		$row = $result->fetch_assoc();
		echo $row["count_item"];
		exit();
		}
	//Get User Details
	if(isset($_POST["details"])){
		$stmt = $conn->prepare("SELECT * FROM user_info WHERE user_id = $_SESSION[uid]");
	        
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()){
        $fname    = $row['first_name'];
		$lname   = $row['last_name'];
		$email = $row['email'];
		$phone = $row['mobile'];

			 echo "<div class='form-group'>
			 <h6>Name :<span class='text-warning'>   $fname $lname</span></h6>
	        </div>
	        <div class='form-group'>
	          <h6>Email :<span class='text-info'>  $email</span></h6>
	        </div>
	        <div class='form-group'>
	          <h6> Phone : <span> $phone</span></h6>
	          </div>";
	        }

		}

		//Placing an order by customer
		if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
			$stmt = $conn->prepare("SELECT * FROM user_info WHERE user_id = $_SESSION[uid]");
	        $stmt->execute();
	        $result = $stmt->get_result();
	        while ($row = $result->fetch_assoc()){
			$user_id = $_SESSION['uid'];
		 	$name    = $row['first_name'].' '.$row['last_name'];
			$email = $row['email'];
			$phone = $row['mobile'];
		 	$products= $_POST['products'];
		 	$grand_total = $_POST['grand_total'];
		 	$address = $_POST['address'];
		 	$pmode = $_POST['pmode'];

		 	$data = '';
		  
		 	$stmt = $conn->prepare("INSERT INTO orders (user_id,name,email,phone,address,p_mode,products,amount_paid) VALUES(?,?,?,?,?,?,?,?)");
		 	$stmt->bind_param("ssssssss",$user_id,$name,$email,$phone,$address,$pmode,$products,$grand_total);
		 	$stmt->execute();
		 	$data .= '<div class="text-center">  
						<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
						<h2 class="text-success">Your Order Placed Successfully!</h2>
						<h4 class="bg-danger text-light rounded p-2">Items Purchased : '.$products.'</h4>
						<h4>Name : '.$name.'</h4>
						<h4>Email : '.$email.'</h4>
						<h4>Phone : '.$phone.'</h4>
						<h4>Amount Payed : '.number_format($grand_total,2).'</h4>
						<h4>Payment Mode : '.$pmode.'</h4>
					</div>';
			echo $data;

			$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = $_SESSION[uid]");
	        $stmt->execute();
		 }
		 
		}
//Get Cart Item From Database to Dropdown menu
	if (isset($_POST["Common"])) {

		if (isset($_SESSION["uid"])) {
			//When user is logged in this query will execute
			$sql = "SELECT a.product_id,a.product_name,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
		}else{
			//When user is not logged in this query will execute
			$sql = "SELECT a.product_id,a.product_name,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.ip_add='$ip_add' AND b.user_id < 0";
		}
	$query = mysqli_query($conn,$sql);
	if (isset($_POST["getCartItem"])) {
		//display cart item in dropdown menu
		if (mysqli_num_rows($query) > 0) {
			$n=0;
			while ($row=mysqli_fetch_array($query)) {
				$n++;
				$product_id = $row["product_id"];
				$product_name = $row["product_name"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				echo '
					<div class="row">
						<div class="col-md-3">'.$n.'</div>
						<div class="col-md-3"><img class="img-responsive" src="images/'.$product_image.'" /></div>
						<div class="col-md-3">'.$product_name.'</div>
						<div class="col-md-3">Ksh'.$product_price.'</div>
					</div>';
				
			}
			?>
				<a style="float:right;" href="cart.php" class="btn btn-warning">Edit&nbsp;&nbsp;<span class="fa fa-edit"></span></a>
			<?php
			exit();
		}
	}
	if (isset($_POST["checkOutDetails"])) {
		if (mysqli_num_rows($query) > 0) {
			//display user cart item with "Ready to checkout" button if user is not login
			echo "<form method='post' action='login_form.php'>";
				$n=0;
				while ($row=mysqli_fetch_array($query)) {
				$n++;
				$product_id = $row["product_id"];
				$product_name = $row["product_name"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
					
				echo '<tr>
				<td>'.$product_id.'</td>
	               <td><img src="images/'.$product_image.'" width= "50"></td>
	               <td>'.$product_name.'</td>
	               <td>'.$product_price.'</td>
	               <td><input type="number" class="form-control itemQty" value="'.$qty.'" style = "width: 85px;"></td>
	               <td>'.$product_price.'</td>
				   <td>
                 	 <a href="action.php?remove=" class="text-danger lead" onclick="return confirm("Are you sure you want to remove this item from cart?");"><i class="fas fa-trash-alt"></i></a>
               	   </td>
               	   </tr>'
               	   ;

          		}
          		}}}
          
?> 






				   