<?php
session_start();
require_once '../model/user.php';
require_once '../model/product.php';

$user = new User();
$user->authenticate();

if(isset($_SESSION['upload'])){
  if (!($_SESSION['upload'])) {
    header('location:item_form.php');
    # code...
  }
}else{
  header('location:item_form.php');
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
    <link rel="icon" href="../../favicon.ico">

    <title>Bhatmas | Item Information</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
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
    <?php include '../header.php';?>    

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h2 style="color:#21610B;">Product Upload Information</h2>
      </div>
      <?php
      if($user->get_return_address($user->userID) == FALSE){
        ?>
        <SECTION class ="lead">
          Thank you. Your item has been uploaded and is ready for order. <a href='my_address.php'> Click here</a> to manage your return address for your items. You must have a valid address to put your items on rent.      
        </SECTION>
        <?php
      }else{
        ?>
         <SECTION class ="lead">
          Thank you. Your item has been uploaded and is ready for order. <a href='user.php'> Click here</a> to go back to your account.      
        </SECTION>
        <?php
      }
      ?>
           
    </div>

    <footer class="footer">
      <div class="container">
        <?php include'../footer.html'; ?>
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
