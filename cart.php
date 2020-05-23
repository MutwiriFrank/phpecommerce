<?php
session_start();

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

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div style="display: <?php if (isset($_SESSION['showAlert'])) {
        echo $_SESSION['showAlert'];
      }else{echo "none";} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>&times;</button>
        <strong><?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];}  unset($_SESSION['message']); ?></strong>
      </div>
      <div class="table-responsive-sm mt-2">
        <table class="table table-bordered table-stripped text-center">
          <thead>
            <tr>
            <td colspan="7">
              <h4 class="text-center text-info m-0">Products in your cart!</h4>
            </td>
          </tr>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total price</th>
            <th>
              <a href="action.php?clear=all" class="badge badge-danger" onclick="return confirm('Are you sure you want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp; Clear Cart</a>
            </th>
          </tr>
          </thead>

          <tbody>
            <?php 
              require 'db.php';
              $ip_add = getenv("REMOTE_ADDR");
              if(isset($_SESSION["uid"])){
              $stmt = $conn->prepare("SELECT * FROM cart WHERE ip_add = '$ip_add' AND user_id = $_SESSION[uid]");
              }
              else{
               $stmt = $conn->prepare("SELECT * FROM cart WHERE ip_add = '$ip_add' AND user_id < 0");
              }
              $stmt->execute();
              $result = $stmt->get_result();
              $grand_total = 0;
              $n=0;
              while ($row = $result->fetch_assoc()):
              $n++;
             ?>
             <tr>
               <td><?php echo $n ?></td>
               <input type="hidden" class="pid" value="<?= $row['p_id'] ?>">
               <td><img src="images/<?= $row['product_image'] ?>" width= "50"></td>
               <td><?= $row['product_name'] ?></td>
               <td><?= number_format($row['product_price'],2); ?></td>
               <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
               <td><input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style = "width: 85px;"></td>
               <td><?= number_format($row['total_price'],2); ?></td>
               <td>
                 <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure you want to remove this item from cart?');"><i class="fas fa-trash-alt"></i></a>
               </td>
             </tr> 
             <?php $grand_total +=$row['total_price']; ?>
           <?php endwhile; ?>
           <tr>
             <td colspan="3">
               <a href="index.php" class="btn btn-success "><i class="fas fa-cart-plus"></i>&nbsp; Continue Shopping</a>
             </td>
             <td colspan="2"><b>Grand Total</b></td>
             <td><b><span>Ksh</span>&nbsp;<?= number_format($grand_total,2); ?></b></td>
             <td>
              <a href="<?php if(isset($_SESSION["uid"])){ echo'checkout.php';}else{ echo'login_form.php';} ?>" class="btn btn-info <?= ($grand_total >1)?"":"disabled"; ?>"><i class="fas fa-credit-card"></i>&nbsp; Checkout</a>
             </td>
           </tr>

          </tbody>

        </table>
      </div>
    </div> 
  </div>
</div>


   <script type="text/javascript">
     $(document).ready(function(){

       $(".itemQty").on('change', function(){
         var $el = $(this).closest('tr');

         var pid = $el.find(".pid").val();
         var pprice = $el.find(".pprice").val();
         var qty = $el.find(".itemQty").val();
         location.reload(true);
         $.ajax({
           url: 'action.php',
        method: 'post',
           cache: false,
           data: {qty:qty,pid:pid,pprice:pprice},
        success: function(response){
          console.log(response);
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

   



