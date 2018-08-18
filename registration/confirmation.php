<?php   
   require_once '../model/user.php';
   $created = false;
   if(!isset($_COOKIE['login']) === true){
    if(isset($_GET['passkey'])){
      $user = new User();
      if($user->activate_account($_GET['passkey'])){
        $created = true;
      }
    }else{
        header('location:signup.php');      
    }
   }else{
    header('location:signup.php');
   }
?>
<!doctype html>
<html>

	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OOPS | Submit</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
			
	</head>
	<BODY>
  <!-- Fixed navbar -->
  <?php include'../header.php'; ?>

  <!--Begin page content -->
  <div class="container">
		<div class = "page-header">
    <h1><?php
     if ($created) {
       echo '<h1 style="color:#21610B;">Congratulation! Your account has been successfully activated! </h1>'; 
       ?><button type="button" class="btn btn-link"><a href="signup.php">Go back</a></button>
      <?php        
     }
     else{
      echo '<h1 style="color:#21610B;">The token has been expired. Please try again!<h1></h1>';
      ?><button type="button" class="btn btn-link"><a href="signup.php"><a href="signup.php">Go back</a></button>
      <?php      
     }
    ?></h1>
    </div>
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
  </BODY> 
  
      
    </footer>
</html>
