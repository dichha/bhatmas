<?php
require_once('../model/user.php');
$user = new user();
$user->authenticate();
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
    <title>Bhatmas | User Account </title> 
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/thumb.css">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Fixed navbar -->
    <?php  include '../header.php'; ?>   
    <!-- Begin page content -->
    <div class="container">
      <div class = "main">
        <div class = "shadow">
      <div class="page-header">
        <h1 style="color:#21610B;">Hi  <?php echo ucfirst($user->Username); ?>!</h1>
      </div>
       <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail tile" style = "text-decoration:none" href="update_account.php">
                    <p class = "lead" style = "text-align:center" >Update Account </p> 
                    <p style = "text-align:center"  >update personal details </p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="change_password.php">
                   <p class = "lead" style = "text-align:center">Change Password</p>
                   <p style = "text-align:center"  >update with new password </p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="item_form.php">
                    <p class = "lead" style = "text-align:center">Rent Or Sell </p>
                     <p style = "text-align:center"  >put your items on store for rent or sale </p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="myitems.php">
                   <p class = "lead" style = "text-align:center">View your items </p>
                    <p style = "text-align:center"  >your lists of items for rent and sale</p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="order_history.php">
                   <p class = "lead" style = "text-align:center">Order history </p>
                  <p style = "text-align:center"  >lists of orders made </p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="order_request.php">
                   <p class = "lead" style = "text-align:center">Order Requests </p>
                    <p style = "text-align:center"  >view customer order on your items </p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="my_rentee.php">
                  <p class = "lead" style = "text-align:center">My Rentees</p>
                  <p style = "text-align:center"  >view customers who rented your items </p> 
                </a>
            </div>
             <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="my_rental_items.php">
                   <p class = "lead" style = "text-align:center">My Rental Items</p>
                   <p style = "text-align:center"  >view items rented by you</p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="my_address.php">
                   <p class = "lead" style = "text-align:center">Manage My Return Address</p>
                   <p style = "text-align:center"  >edit address details </p> 
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 thumb">
                <a class="thumbnail" style = "text-decoration:none" href="delete_account.php">
                   <p class = "lead" style = "text-align:center">Delete Account </p>
                   <p style = "text-align:center"  >deactivate your account </p> 
                </a>
            </div>
        </div>
    </div>
    </div>
  </div>
    <footer class="footer">
      <div class="container">
        <?php include '../footer.html'; ?>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
