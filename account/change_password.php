<?php
require_once('../model/user.php');
$user = new user();
$user->authenticate();
$message = array();
$update_password = false;
if(isset($_POST['update_password'])){
  if($_POST['update_password'] == "Update Password"){

  if(!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
    if($user->updatePassword($_POST['old_password'],$_POST['new_password'])){
       $update_password = true;
       $message = [
                'success' => 'Your password has been updated successfully.'
                ];
    }else{         
       $message= [
            'wrong_password'=> 'Your current password is incorrect.'
            ];
    }

  }else{
     $message = [
          'empty' => 'Please fill in the details.'
          ];
  }//end of if empty passwords block
}//end of isset update password block
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
   

    <title>Bhatmas | Change Password</title>   

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
                  <h1 class="page-header">Change Password                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Change Password                      
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
                      <form class = "form-horizontal" id="form1" action = "change_password.php" method = "POST" role="form" >
                 
                  <div class="form-group">
                    <label for="fname" class="col-sm-2 control-label" style="font-weight:normal;font-size:18px;">Enter Old Password</label>
                    <div class="col-sm-10"> 
                      <input class="form-control" type = "password" name = "old_password" style="width:27%;">
                    </div>                    
                  </div> 
                   <div class="form-group">
                    <label for="fname" class="col-sm-2 control-label" style="font-weight:normal;font-size:18px;">Enter New Password</label>
                    <div class="col-sm-10"> 
                      <input class="form-control" type = "password" id = "new_password" name = "new_password" style="width:27%;">
                    </div>                    
                  </div>                  
                   <div class="form-group">
                    <label for="fname" class="col-sm-2 control-label" style="font-weight:normal;font-size:18px;">Confirm New Password</label>
                    <div class="col-sm-10"> 
                      <input class="form-control" type = "password" name = "confirm_password" style="width:27%;">
                    </div>                    
                  </div> 
                  
                 <div class="col-sm-2"></div>
                 <div class="col-sm-2">
                   <input type = "submit" class = "btn btn-primary" id = "button" name ="update_password" value = "Update Password"/> 
                </div>
                <div class="col-sm-4"></div>
                <br>
                </form> 
                <br>                             
                 <div class="col-sm-10">
                  <?php
                  if($update_password){
                    ?>
                    <div class="col-sm-2"></div>                     
                    <div class="alert alert-success fade in col-sm-8">
                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h5 style = "text-align:center"><?php echo $message['success'];?></h5>
                    </div>                   
                    <?php
                  }else{
                        if(!empty($message)){?>
                        <div class="col-sm-2"></div>                     
                        <div class="alert alert-danger fade in col-sm-8">
                          <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h5 style = "text-align:center">
                        <?php
                          if(isset($message['wrong_password'])) echo $message['wrong_password'] ;
                          if(isset($message['empty'])) echo $message['empty'];
                        }
                        ?></h5>
                    </div> 
                  <?php
                  }
                  ?>
                 </div> 
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
