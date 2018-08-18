<?php
require_once('../model/user.php');
require_once('../model/order.php');
require_once('../address.php');
$user = new User();
$user->authenticate();
$order = new Order();
$user->get_info();
$id = $user->get_userid();
$order->get_orders($id);
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
   

    <title>Bhatmas | My Order History</title>   

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
   <script type="text/javascript">
      $(document).ready(function() {

        $('#example tr').click(function() {
            var href = $(this).find("a").attr("href");
            if(href) {
                window.location = href;
            }
        });

    });
  </script>
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
                  <h1 class="page-header">Order History                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Order History                     
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
                       <table class="table table-hover1" id = "example">                 
                      <thead>
                        <tr>
                          <th>Order No</th>                                                                         
                          <th>Order Date</th>
                          <th>Status</th>                          
                        </tr>
                      </thead>
                      <?php
                  foreach ($order->my_orders as $key =>$value) {
                   ?>
                   <tr>
                    <td><a href="<?php echo $address['order']."?"."ref=".$value['order_no'];?>"
                     ><?php echo $value['order_no'];?></a></td>
                    <td><?php echo date('M j Y',
                     strtotime($value['ord_date']));?></td>
                    <td><?php echo $value['status'];?></td>                    
                   </tr>
                   <?php
                   }
                      ?>                 
                  <tbody>
                                                         
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
