<?php
require_once 'model/user.php';
require_once 'functions/core_functions.php';
$user = new User();
$user->login_authenticate();
$display_error = false;
//form validation
if(isset($_POST['login'])){
  if(empty($_POST) ===FALSE){

    $required_fields = array('username','password');
    foreach ($_POST as $key => $value) {
      if(empty($value) && in_array($key,$required_fields) ===true){
        $errors[] = 'Please enter username and password';
         break 1; 
      }
      # code...
    }//end of for each block

  }//end of if empty

  if(empty($_POST) ===false && empty($errors) == true){
    $user->login($_POST['username'],$_POST['password']); 
    if(empty($user->login_message) === false){

       foreach ($user->login_message as $key) {
        $errors[] = $key;
        $display_error = true;
       }
    }else{
      $user->authenticate();
    }
  }else{
    $display_error = true;
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
    <link rel="icon" href="../../favicon.ico">

    <title>Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery.js"></script>
  </head>

  <body>
   <!-- Navigation -->
    <?php include 'header.php';?>

    <div class="container">
      <?php
      if($display_error){
        echo output_errors($errors);
      }
      ?>

      <form class="form-signin" method = "POST" action = "login.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" name="username" class="form-control" placeholder="Username"autofocus><br/>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password"  name="password" id="inputPassword" class="form-control" placeholder="Password">
        <div class="checkbox">
          <label>
            <a href="registration/signup.php">Sign Up</a> Don't have an account?
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" name = "login" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
    <!-- Footer -->
    <footer class="footer">        
      <div class="container">
        <?php include 'footer.html';?>
      </div>       
    </footer>
   
  </body>
</html>
