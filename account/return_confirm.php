<?php
require_once '../model/user.php';
require_once '../model/order.php';
require_once '../address.php';

$user = new User();
$order = new Order();
$user->authenticate();

if(isset($_POST['r_deliver'])){
  if($_POST['r_deliver'] == "Return"){

    $order_no = $_POST['o_no'];
    $renter_email = $_POST['mail'];
    $productid = $_POST['p_id'];
      
    $user->get_userid();
    if(!($user->get_return_address($user->userID))){
      echo("string");
    }
    $order->view_rental_item($user->userID,$productid,$order_no);

  }else{
    header('location:'.$address['account']);  
  } //end of if post deliver

}else{
  header('location:'.$address['account']);
} //end of if isset post
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bhatmas | Rental Confirm</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/index.css">   
  </head>
  <body>
    <!-- Fixed navbar -->
    <?php include'../header.php'; ?>
    <div class="container">
    <div class="page-header">
        <h1 style="color:#21610B;">Confirm Return</h1>
    </div>       
          
                
                  <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Order No</th>
                      <th>Order Requested</th>
                      <th>Renter Username</th>
                      <th>Item Name</th>                               
                      <th>Quantity</th>
                      <th>Rental Week</th>                              
                      <th>Status</th>
                      <th>Dispatched Date</th>
                      <th>Return Date</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $order->rental_item['order_no'];?></td>
                      <td><?php echo date('M j Y g:i A', strtotime($order->rental_item['date']));?></td>
                      <td><?php echo $order->rental_item['renter'];?></td>
                      <td><?php echo $order->rental_item['itemname'];?></td>                      
                      <td><?php echo $order->rental_item['quantity'];?></td>
                      <td><?php echo $order->rental_item['week'];?></td>                      
                      <td><?php echo $order->rental_item['status'];?></td>
                      <td><?php echo date('M j Y ', strtotime($order->rental_item['dispatched']));?></td>
                      <td><?php echo date('M j Y ', strtotime($order->rental_item['return']));?></td>                      
                    
                    </tr>
                       </tbody>
                </table> 
      <div class="page-header">
          <h2 style="color:#21610B;">Return Address</h2>
      </div>
      <form  class="form-horizontal" method = "POST" action = "item_return_delivered.php">
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">First Name</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" value="<?php echo $user->address['fname'];?>" readonly>
            </div> 
            <div class="col-sm-6"></div>      
        </div>
            <div class="form-group">
            <label for="Last Name" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Last Name</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" value="<?php echo $user->address['lname'];?>"readonly>
            </div> 
            <div class="col-sm-6"></div>      
        </div>
          <div class="form-group">
            <label for="Town" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Town</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" value="<?php echo $user->address['town'];?>"readonly>
            </div> 
            <div class="col-sm-6"></div>      
        </div>
          <div class="form-group">
            <label for="Post Code" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Post Code</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" value="<?php echo $user->address['pcode'];?>"readonly>
            </div> 
            <div class="col-sm-6"></div>      
        </div>
          <div class="form-group">
            <label for="Address 1" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Address 1</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" value="<?php echo $user->address['street1'];?>"readonly>
            </div> 
            <div class="col-sm-6"></div>      
        </div>
          <div class="form-group">
            <label for="Address 2" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Address 2</label>
            <div class="col-sm-3">
              <input type="text"  class="form-control" value="<?php echo $user->address['street2'];?>"readonly>
            </div> 
            <div class="col-sm-6"></div>      
        </div>
            <input type = "text" name = "o_no" value = "<?php echo $order->rental_item['order_no']; ?>"readonly hidden>
            <input type = "text" name = "p_id" value = "<?php echo $order->rental_item['pid']; ?>"readonly hidden>
            <input type = "email" name = "mail" value = "<?php echo $order->rental_item['renter_email']; ?>"readonly hidden> 
               <div class="form-group">
            <label for="confirm" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;"></label>
          <div class="col-sm-3">
               <input type = "submit" name = "r_confirm"value = "Confirm Return"class="btn  btn-xs btn-info" >
            </div> 
            <div class="col-sm-6"></div>      
          </div> 
          <input type = "text" name = "o_no" value = "<?php echo $order->rental_item['order_no']; ?>"readonly hidden>
          <input type = "text" name = "p_id" value = "<?php echo $order->rental_item['pid']; ?>"readonly hidden>
          <input type = "email" name = "mail" value = "<?php echo $order->rental_item['renter_email']; ?>"readonly hidden>                                           
         
      </form>
    
          
      </div> 
    <footer class="footer">
      <div class="container">
        <?php include'../footer.html'; ?>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  
  </body>
</html>
