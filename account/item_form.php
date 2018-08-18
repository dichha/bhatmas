<?php
require_once '../model/user.php';

$user = new User();
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
   

    <title>Bhatmas | Add Items</title>   

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
  <script>
   $(document).ready(function() {
      $("#form1").validate({      
      //setting up the rules for validation      
        rules: {          
          old_password: {required: true},        
          new_password:{required: true,pwchecklowercase: true,pwcheckuppercase: true,pwchecknumber: true,pwcheckconsecchars: true,
                pwcheckspechars: true,pwcheckallowedchars: true,minlength: 5,maxlength: 25},
          confirm_password:{required: true,equalTo:"#new_password"}},//rules
      
      //setting up custom messages     
        messages: {  
          old_password:{required:"Enter your old password"},          
          new_password:{required:"Enter new password"},confirm_password:{required:"Enter to confirm new password"}}//messages
        });//validate
      });//function
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
                  <h1 class="page-header">Product Form                     
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Product Form                  
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
                       <form method = "POST" action ="sale_form.php">
            <ul >I would like to put an item for <b>SALE</b>
            </ul>
            <ul>
              <input type="submit" class="btn btn-primary"id = "sell_check" />
            </ul>
          </form>
          <form method = "POST" action ="rental_form.php">
             <ul>I would like to put an item for <b>RENT</b>.</ul>            
            <ul>
              <input id = "button"type = "submit" class="btn btn-primary"id = "rent_check" />
            </ul>
          </form>
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
