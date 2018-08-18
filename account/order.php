<?php
require_once('../address.php');
require_once('../model/user.php');
require_once('../model/order.php');

$user = new User();
$user->authenticate();
$order = new Order();
if(isset($_GET['ref'])){

	//needs to verify user
	if(!($order->valid_order($_GET['ref'],$user->get_userid()))){		
		header($address['error']);	
	}
}else{
	header($address['error']);	
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
   

    <title>Bhatmas | Order</title>   

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
                  <h1 class="page-header">My Order <?php echo strtoupper($_GET['ref']);?>                     
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">My Order                     
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
                   		<table class="table table-hover">                                       
                   			<thead>
                   				<th>No</th>
                   				<th>Item</th>
                   				<th>Type</th>
                   				<th>Qty</th>                   				
                   				<th>Status</th>
                   			</thead>
                   			<tbody>
                   				<?php
                   				$order->view_order($_GET['ref']);
                   				$i = 0;
                   				foreach ($order->order_details as $key => $value) {
                   					$i++;
                   					?>
                   					<tr>
                   						<td><?php echo $i;?></td>
                   						<td><a href="<?php echo $address['item_detail']."?id=".$value['pdt_id'];?>" >
                   							<img class="img-responsive img-thumbnail"
                   						 src="<?php echo $value['img'];?>" alt="">
                   						</a></td>
                   						 <td><?php echo empty($value['rental_week'])? "Purchase" : "Rent";?></td>
                   						 <td><?php echo $value['pdt_qty'];?></td>
                   						 <td><?php echo $value['odr_status'];?></td>
                   					</tr>                   					
                   					<?php
                   				}
                   				?>
                   			</tbody>
                   		</table>
                   		<table class = "table table-hover">
                   			<tr id = "delivery">
                          <td colspan = "5">Shipping Address</td>
                        </tr>
                        <?php
                            $order->get_shipping_address($_GET['ref']);
                           ?>
                        <tr>
                          <td colspan = "2">Name   
                          </td>
                          <td colspan = "3"><?php 
                          $user->get_info();
                          echo (empty($order->address['name']))? $user->info['firstname'] ." ". $user->info['lastname'] : $order->address['name'];
                           ?></td>
                        </tr>
                        <tr>
                          <td colspan = "2">Street   
                          </td>
                          <td colspan = "3"><?php echo $order->address['street1'] ."\n";
                           echo $order->address['street2'];
                           ?></td>
                        </tr>                                    
                        <tr>
                          <td colspan = "2">City
                          </td>
                          <td colspan = "3">
                           <?php echo $order->address['city'];?>
                          </td>
                        </tr>                        
                        <tr>
                          <td colspan = "2">County
                          </td>
                           <td colspan = "3">
                           <?php echo $order->address['state'];?>
                          </td>
                        </tr>                           
                        <tr>
                          <td colspan = "2">Post Code
                          </td>
                          <td colspan = "3">
                           <?php echo $order->address['zip'];?>
                          </td>
                        </tr>                           
                        <tr>
                          <td colspan = "2">Country
                          </td>
                          <td colspan = "3">
                           <?php echo $order->address['country'];?>
                          </td>
                        </tr>  
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
