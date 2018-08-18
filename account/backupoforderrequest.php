<?php
require_once '../model/user.php';
require_once '../model/order.php';

$user = new User();
$user->authenticate();
$user->get_userid();
$order = new Order();
$order->order_request($user->get_userid());
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
   

    <title>Bhatmas | Order Request</title>   

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
                  <h1 class="page-header">Order Request 
                  <small>list of customer orders</small>                     
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Order Request                     
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
                  foreach ($order->list_request as $key => $value) {
                    ?>
                  <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Order No</th>
                      <th>Order Requested</th>
                      <th>Item Name</th>
                      <th>Category</th>                      
                      <th>Quantity</th>
                      <th>Rental Week</th>                              
                      <th>Status</th>
                      <th>Update</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $value['order_no'];?></td>
                      <td><?php echo date('M j Y g:i A', strtotime($value['date']));?></td>
                      <td><?php echo $value['itemname'];?></td>
                      <td><?php echo $value['category'];?></td>
                      <td><?php echo $value['quantity'];?></td>
                      <td><?php echo empty($value['week'])? "NA" :$value['week'];?></td>                      
                      <td><?php echo $value['status'];?></td>
                      <td>
                        <?php
                        //removing update button for shipped items
                        if(!($value['status'] =="Shipped")){
                          ?>
                          <form method = "POST" action = "order_confirm.php">
                          <input type = "text" name = "order_no" value = "<?php echo $value['order_no'];?>"readonly hidden>
                          <input type = "submit" class = "btn  btn-xs btn-info" Value = "Send" name = "order_request">
                          </form>
                          <?php
                        }
                        ?>
                      </td>

                    </tr>
                    <tr id = "delivery">
                          <td colspan = "8">Shipping Address</td>
                        </tr>                        
                        <tr>
                          <td colspan = "2">Name   
                          </td>
                          <td colspan = "6"><?php echo $value['name'];;
                           ?></td>
                        </tr>
                        <tr rowspan = "2">
                          <td colspan = "2">Street   
                          </td>
                          <td colspan = "6"><?php echo $value['street1']."<br>";
                          echo $value['street2'];
                           ?></td>
                        </tr>                                    
                        <tr>
                          <td colspan = "2">City
                          </td>
                          <td colspan = "6">
                           <?php echo $value['city'];?>
                          </td>
                        </tr>                        
                        <tr>
                          <td colspan = "2">County
                          </td>
                           <td colspan = "6">
                           <?php echo $value['state'];?>
                          </td>
                        </tr>                           
                        <tr>
                          <td colspan = "2">Post Code
                          </td>
                          <td colspan = "6">
                           <?php echo $value['zip'];?>
                          </td>
                        </tr>                           
                        <tr>
                          <td colspan = "2">Country
                          </td>
                          <td colspan = "6">
                           <?php echo $value['country'];?>
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
