<?php 
  require 'db.php';

  session_start();
  $user_id = $_SESSION["uid"];

   $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = '$user_id'");
   $stmt->execute();
   $result = $stmt->get_result();
   $count = $result->fetch_assoc();

  if(!isset($_SESSION["uid"]) || ($count < 1)){
    header("location:index.php");
  }

  if (isset($_SESSION["uid"])) {
          
  $grand_total = 0;
  $allItems = '';
  $items = array();

   $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty,total_price FROM cart WHERE user_id = $_SESSION[uid]";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $result = $stmt->get_result();
   while ($row = $result->fetch_assoc()) {
     $grand_total += $row['total_price'];
     $items[] = $row['ItemQty']; 
   }
   $allItems = implode(",", $items);
  } 
  else {
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
  <link rel="stylesheet" type="text/css" href="style.css">
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
           <ul class="navbar-nav ml-auto">
        <div class="dropdown">
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="dropdown"><span class="fa fa-shopping-cart"></span>&nbsp;Cart<span class="badge badge-danger">0</span></a>
            <ul class="dropdown-menu" style="width:400px;">
            <div class="card-success">
              <div class="card-header">
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
      </div>

        <div class="dropdown">
        <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="dropdown"><span class="fa fa-user"></span>&nbsp;<?php echo "Hi,".$_SESSION["name"]; ?></a>
          <ul class="dropdown-menu">
            <li><a href="cart.php" style="text-decoration:none; color:blue;"><span class="fa fa-shopping-cart"></span>Cart</a></li>
            <li class="divider"></li>
            <li><a href="customer_order.php" style="text-decoration:none; color:blue;">Orders</a></li>
            <li class="divider"></li>
            <li><a href="" style="text-decoration:none; color:blue;">Change Password</a></li>
            <li class="divider"></li>
            <li><a href="logout.php" style="text-decoration:none; color:blue;">Logout</a></li>
          </ul>
        </li>
      </div>
      </ul>
        </div>
    </nav>
  
  <p><br/></p>
  
       <?php 
           require 'db.php';
            
       ?>
<div class="container">
<div class="row justify-content-center">
   <div class="col-lg-6 px-4 pb-4" id="order">
      <h3 class="text-center text info p-2">Complete your order!</h3>
      <div class="jumbotron p-3 mb-2 text-center">
        <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
        <h6 class="lead"><b>Delivery Charge : </b>Free </h6>
        <h5><b>Amount Payable : </b><?= number_format($grand_total,2) ?>/-</h5>
      </div>
      <form action="" method="post" id="placeOrder">
        <input type="hidden" name="products" value="<?= $allItems; ?>">
        <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
        <div id="user_details">
         <!-- Display user details -->
         
        </div>

        <div class="form-group">
          <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here.."></textarea>
        </div>
        <h6 class="text-center lead"> Select Payment Mode</h6>
        <div class="form-group">
        <select name="pmode" class="form-control">
          <option value="" selected disabled>-Select Payment Mode-</option>
          <option value="C.O.D">Cash On Delivery</option>
          <option value="Cards">Debit/Credit Card</option>
          <option value="Mpesa">M-pesa</option>
        </select> 
        </div>
        <div class="form-group">
          <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
        </div>
      </form>
   </div>
</div>
</div> 


<script type="text/javascript">
  $(document).ready(function(){

    $("#placeOrder").submit(function(e){
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize()+"&action=order",
        success: function(response){
          $("#order").html(response);
        }
     });
    });

    load_cart_item_number();

    function load_cart_item_number(){
    $.ajax({
        url: 'action.php',
        method: 'get',
        data: {cartItem:"cart_item"},
        success: function(response){
          $("#cart-item").html(response);
        }
     });
    }
  });
  </script>
</body>

</html> 


