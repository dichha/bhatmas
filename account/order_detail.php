<?php   
   session_start();
   require_once '../model/user.php';
   require_once '../model/order.php';
   require_once '../address.php';
   $user = new User();
   $order = new Order();
   $user->authenticate();
   $order_no = "";
   $itemid = "";
   if(isset($_POST['order_request'])){   
      $order_no = htmlspecialchars($_POST['order_no']);
      $itemid = htmlspecialchars($_POST['p_id']);
   }else{
    header('location:'.$address['order_request']);
   }

   $order->view_order($order_no,$itemid);
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
   

    <title>Bhatmas | Order Confirm</title>   

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
  <script src="../js/additional.js"></script> 
  </head>
  <body>
    <!-- Fixed navbar -->
    <?php include '../header.php'; ?>
    <!-- Begin page content -->
    <div class="container">
      <div class="col-sm-12">
        <div class="row"> <!--div row -->
              <div class="col-sm-12">
                <span class="hidden-xs">
                  <h1 class="page-header">Confirm Customer Order                    
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Cofirm Customer Order                     
                  </h3>
                </span>
              </div>
          </div> <!-- end of div row -->
          <div class="row"> <!-- div 1 row-->
            <div class="col-sm-3">
              <div class = "account">
                <div class="list-group">
                 <?php include 'menu.php';?>
                </div>
              </div>
            </div>
            <div class="col-sm-1"></div>
              <div class="col-sm-8">
                <div class="col-sm-12">
                  <div class="row"> <!-- div 2 row -->
                    <!--information-->
                    <SECTION class = "lead">
                    <div class = "content">
                    <?php    
                      foreach ($order->order_details as $key1 => $value1) {
                        $item_rent = false;
                      ?>     
                  <table class="table table-hover">                 
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Type</th>
                      <th>Date</th>
                      <th colspan = "2">Delivery</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>                      
                      <td><?php echo $value1['pdt_name'];?></td>
                      <td><?php echo $value1['pdt_qty'];?></td>
                      <td><?php
                      //if rental week is 0, make it NA
                      if($value1['pdt_week'] ==0)
                        {echo "Purchase";}
                      else{
                       echo "Rent";
                       $item_rent = true;
                     }
                       ?>
                     </td>
                      <td><?php echo date('d-m-y', strtotime($value1['order_date']));?></td>
                      <td>
                        <form method = "POST" action = "order_delivered.php">
                          <input type = "text" name = "o_no" value = "<?php echo $order_no; ?>"readonly hidden>
                          <input type = "text" name = "p_id" value = "<?php echo $value1['pdt_id']; ?>"readonly hidden>
                          <input type = "email" name = "mail" value = "<?php echo $value1['buyer_email']; ?>"readonly hidden>                        
                          <input type = "submit" name = "o_deliver"value = "Confirm"class="btn  btn-xs btn-info" >
                        </form>

                      </td>
                      <td>
                        <a href="order_request.php"><button type="button" class="btn  btn-xs btn-danger">Cancel</button></a>
                      </td>
                    </tr>        

                                          <?php
                      //if item is rent an extra row for rental duration
                      if($item_rent){
                        ?>
                        <tr>
                          <td></td><td></td>
                          <td><?php echo $value1['pdt_week'] . " Week(s)";?></td>
                          <td></td><td></td>
                        </tr>                      

                        <?php
                      }
                      ?>                                  

                                       
                        <tr id = "delivery">
                          <td style = "font-weight:bold"colspan = "6">Shipping Address</td>
                        </tr>
                        <?php
                            $order->get_shipping_address($order_no);
                           ?>
                        <tr>
                          <td colspan = "2">Name   
                          </td>
                          <td colspan = "4"><?php echo empty($order->address['name']) ? $value1['cst_f_name']." ". $value1['cst_l_name'] : $order->address['name'];?></td>
                        </tr>
                        <tr>
                          <td colspan = "2">Street   
                          </td>
                          <td colspan = "4"><?php echo $order->address['street1'] ."\n";
                           echo $order->address['street2'];
                           ?></td>
                        </tr>                                    
                        <tr>
                          <td colspan = "2">City
                          </td>
                          <td colspan = "4">
                           <?php echo $order->address['city'];?>
                          </td>
                        </tr>                                                                          
                        <tr>
                          <td colspan = "2">Post Code
                          </td>
                          <td colspan = "4">
                           <?php echo $order->address['zip'];?>
                          </td>
                        </tr>                           
                        <tr>
                          <td colspan = "2">Country
                          </td>
                          <td colspan = "4">
                           <?php echo $order->address['country'];?>
                          </td>
                        </tr>                                         
                                      
                      <?php
                    }
                  
                  ?>                                          
                  </tbody>
              </table> 
                    </div>                                   
                    </SECTION>
                  </div><!--div 2 row -->
                </div>
              </div>
          </div><!-- end of div 1 row--> 
      </div> <!-- end of col-sm-12>-->      
    </div> <!-- end of container -->
    <footer class="footer">
      <div class="container">
       <?php include '../footer.html'; ?>
      </div>
    </footer>
    <noscript>
      <div class="lead">You don't have javascript enabled. Please turn it on.         
      </div>
    </noscript>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
