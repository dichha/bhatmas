<?php
require_once '../model/user.php';
require_once '../model/order.php';
$user = new User();
$user->authenticate();
$order = new Order();
$order->my_rental_items($user->get_userid());
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
   

    <title>Bhatmas | My Rental Items</title>   

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
                  <h1 class="page-header">My Rental Items                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">My Rental Items                     
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
                      if(!empty($order->rental_items)){
                        foreach ($order->rental_items as $key => $value) {
                            if (!empty($value['week'])) {                   
                            
                            ?>
                          <table class="table table-hover1" id = "example"> 
                          <thead>
                            <tr>
                              <th>Order No</th>                            
                              <th>Item</th>                                       
                              <th>Qty</th>
                              <th>Rented</th>                                                 
                              <th>Sent</th>
                              <th>Rent End</th>                                                            
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><?php echo $value['order_no'];?></td>                           
                              <td><?php echo $value['itemname'];?></td>                      
                              <td><?php echo $value['quantity'];?></td>
                              <td><?php echo $value['week'] . " wk";?></td>                                                    
                              <td><?php echo date('M j Y ', strtotime($value['dispatched']));?></td>
                              <td><?php echo date('M j Y ', strtotime($value['return']));?></td>                                                                        
                            </tr>
                               </tbody>
                        </table> 
                            
                            <?php
                          }//end of if empty
                        }

                      }else{
                        echo "You have 0 items on rent.";

                      }//end of if not empty
                  
                      ?>       

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
