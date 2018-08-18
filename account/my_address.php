<?php
require_once '../model/user.php';
require_once '../functions/core_functions.php';
$user = new User();
$user->authenticate();
$user->get_userid();

$address = array();
$display_errors = false;

if(isset($_POST['ret_address'])){
  if($_POST['ret_address'] == "Submit" || $_POST['ret_address'] =="Update Address"){
    if(empty($_POST) ===FALSE){

      $required_fields = array('firstname','lastname','town','postcode','street1');

      foreach ($_POST as $key => $value) {    
        if(empty($value) && in_array($key,$required_fields) ===true){
          $errors[] = '* Fields are required';
          break 1;     
        }
      }//end of for each block
      if(empty($errors) ===true){
        if (is_alpha($_POST['firstname'] == false)) {
          $errors[] = "First name should contain only alphabets.";
          # code...
        }

        if(name_length($_POST['firstname']) ==false){
           $errors[] = "Firstname should contain Minimum 3 and Maximum 29 characters.";
        }
        if (is_alpha($_POST['lastname'] == false)) {
          $errors[] = "Last name should contain only alphabets.";
          # code...
        }

        if(name_length($_POST['lastname']) ==false){
           $errors[] = "Lastname should contain Minimum 3 and Maximum 29 characters";
        }

          if(is_postcode($_POST['postcode']) ==false){
           $errors[] = "Invalid Postcode";
        }


      }//end of empty errors true
    }//end of if empty post = false
    if(empty($_POST) ===false && empty($errors) == true){
              // if no errors then insert address
    
    $address = array(
        'fname'=>$_POST['firstname'],'lname'=>$_POST['lastname'],
        'street1'=>$_POST['street1'],'street2'=>$_POST['street2'],
        'town'=>$_POST['town'],'pcode'=>$_POST['postcode']);

    if($_POST['ret_address'] == "Submit") $user->set_return_address($user->userID,$address);        
    if($_POST['ret_address'] == "Update Address") $user->update_return_address($user->userID,$address);
         }else{
             //display errors
            $display_errors = true;
        }
  }//end of if post submit
} //end of isset
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
   

    <title>Bhatmas | My Address</title>   

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
                  <h1 class="page-header">My Address                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">My Address
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
                      <?php
      if($user->get_return_address($user->userID) === FALSE){
        if($display_errors){
          echo output_errors($errors);
        }
        ?>
        <!-- set address form -->
          <form class="form-horizontal" method = "POST" action = "my_address.php">
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">First name*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="firstname" placeholder="First name">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Last name*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="lastname" placeholder="Last name">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>            
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Town*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="town" placeholder="Town">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Post Code*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="postcode" placeholder="Post Code">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Address 1*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="street1" placeholder="House Number, Street Name">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Address 2</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="street 2" placeholder="Optional">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <input id="button" type="submit" name="ret_address" value ="Submit" class="signup_btn">
           <br><br>
          </div>  
          </form>        
        <?php
      }else{
        ?>
        <!--display address -->
        <?php
        $user->get_return_address($user->userID);       
        ?>   
        <form class="form-horizontal" method = "POST" action = "my_address.php">
          <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">First name*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name = "firstname"value ="<?php echo strtoupper($user->address['fname']);?>">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Last name*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name = "lastname"value ="<?php echo strtoupper($user->address['lname']);?>">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>  
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Town*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name = "town"value ="<?php echo strtoupper($user->address['town']);?>">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Post Code*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name= "postcode"value ="<?php echo strtoupper($user->address['pcode']);?>">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Address 1*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name = "street1"value ="<?php echo strtoupper($user->address['street1']);?>">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Address 2</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name = "street2"value ="<?php echo strtoupper($user->address['street2']);?>">
                  <div id = "feedback"></div>
                </div>
                <div class="col-sm-6"></div>
            </div>
            <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <input id="button" type="submit" name="ret_address" value ="Update Address" class="signup_btn">
           <br><br>
          </div>  
        </form>
        <?php
      }
      ?>
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
