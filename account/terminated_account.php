<?php
  require_once '../model/user.php';
  require_once '../model/cookie.php';

  $delete_status = false;
  
  if (isset($_POST['delete_account'])) {
    if ($_POST['delete_account'] =="Yes") {
      $user = new User();
      if($user->delete_account()){
        $delete_status = true;
        if(isset($_COOKIE['login'])){
          $cookie = new Cookie();
          $cookie->delete_cookie($_COOKIE['login']);
        }
      }
    }else if($_POST['delete_account'] == "No"){
      header('location:user.php');
    }
    # code...
  }else{
    header('location:../login.php');
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
   

    <title>OOPS | Change Password</title>   

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
       <div class="row"> <!--div row -->
              <div class="col-sm-12">
                <span class="hidden-xs">
                  <h1 class="page-header">Account Deleted                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Account Deleted                    
                  </h3>
                </span>
              </div>
          </div> <!-- end of div row -->
      <div class = "main">
           <div class="form-group">
                   
                    <div class="col-sm-10">
                      <?php
                      if ($delete_status) {
                        echo  "Your account has been deleted";
                      }
                      ?>
                      
                    </div>                    
                  </div>
  
      </div>  
    </div>  
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
