<?php
session_start();
require_once '../functions/core_functions.php';
authenticate();

if(isset($_SESSION['submit_page'])){
  if ($_SESSION['submit_page'] == false) {
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
    <h1>
       <h1 style="color:#21610B;">Congratulation! Your account is successfully created! </h1>
        </h1>
    </div>  
<p>An email has been sent to your account on how to activate your account.</p>
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
