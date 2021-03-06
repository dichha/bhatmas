<?php
require_once '../model/user.php';
require_once '../model/order.php';
require_once '../address.php';
$user = new User();
$user->authenticate();
$userid = $user->get_userid();
$order = new Order();

if((isset($_GET['ref']) && isset($_GET['pid'])) == FALSE){
  header('location:'.$address['err_page']);
}else{
  if(!($order->athz_rentee($_GET['ref'],$_GET['pid'],$user->get_userid()))){
    header('location:'.$address['err_page']);
  }
}
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
    <title>Bhatmas | Rent Detail</title>   
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
                  <h1 class="page-header">Rent Detail                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Rent Detail                     
                  </h3>
                </span>
              </div>
          </div> <!-- end of div row -->
          <div class="row"> <!-- div 1 row-->
           
            <div class="col-sm-1"></div>
              <div class="col-sm-11">
                <div class="col-sm-12">
                  <div class="row"> <!-- div 2 row -->
                    <!--information-->
                    <SECTION class = "lead">
                    <div class = "content">
                      <table class="table table-hover">
                        <thead>
                          <th>Order No</th>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Order Date</th>
                          <th>Rent End Date</th>
                          <th>Dispatched Date</th>
                        </thead>                      
                      <tbody>
                        <tr>
                          <?php
                          $order->view_rental_item($_GET['pid'],$_GET['ref']);                          
                            ?>
                            <td><?php echo $order->rental_item['o_no'];?></td>                            
                            <td><img class="img-responsive img-thumbnail" src="<?php echo $order->rental_item['pic'];?>" alt=""></td>
                            <td><?php echo $order->rental_item['qty'];?></td>                            
                            <td><?php echo $order->rental_item['date'];?></td>                            
                            <td><?php echo $order->rental_item['return'];?></td>                            
                            <td><?php echo $order->rental_item['o_no'];?></td>                            
                        </tr>
                      </tbody>
                      </table>
                      <?php                     
                      echo "Rentee: ". $user->get_username($order->rental_item['rentee']) . "\n";
                      ?>
                      <h3>Item Return Address</h3>
                      <table>
                        
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
