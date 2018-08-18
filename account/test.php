<?php
require_once '../model/user.php';
require_once '../functions/core_functions.php';
$user = new User();
$user->authenticate();

$message = false;
$display_errors = false;
$user->get_info();

if(isset($_POST['update_form'])){
  if(empty($_POST) ===FALSE){
  $required_fields = array('fname','lname','mail');

  foreach ($_POST as $key => $value) {    
    if(empty($value) && in_array($key,$required_fields) ===true){
      $errors[] = 'Please do not leave empty fields';
      break 1;     
    }
  }//end of for each block
  if(empty($errors) ===true){

    if (is_alpha($_POST['fname'] == false)) {
      $errors[] = "First name should contain only alphabets.";
      # code...
    }

    if(name_length($_POST['fname']) ==false){
       $errors[] = "Firstname should contain Minimum 3 and Maximum 29 characters.";
    }
    if (is_alpha($_POST['lname'] == false)) {
      $errors[] = "Last name should contain only alphabets.";
      # code...
    }

    if(name_length($_POST['lname']) ==false){
       $errors[] = "Lastname should contain Minimum 3 and Maximum 29 characters";
    }

    if(valid_email($_POST['mail']) == false){
      $errors [] = "Invalid email address.";
    } 
  }//end of empty errors block

}//end of if empy post block

if(empty($_POST) ===false && empty($errors) == true){
              // if no update account
       if($user->update_account($_POST['fname'],$_POST['lname'],$_POST['mail'])){
      $message = true;
       }else{
        $message = false;
       }

     }else{
         //display errors
        $display_errors = true;
    }//end of if block
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bhatmas | Buy</title>
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="../js/jquery.js"></script>
</head>
<body>
    <!-- Navigation -->
    <?php include '../header.php';?>
    <!-- Page Content -->
    <div class="container">
        <!-- Page Heading -->
        <div class="col-sm-12">
          <div class="row"> <!--div row -->
              <div class="col-sm-12">
                <span class="hidden-xs">
                  <h1 class="page-header">Update Account                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Update Account                      
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
                       <form class = "form-horizontal" id="form1" action = "test.php" method = "POST" role="form" >  
          <?php if ($display_errors) {echo output_errors($errors); }?>                  
                  <div class="form-group">
                    <label for="ctitle" class="col-sm-4 control-label" style="font-weight:normal;font-size:18px;">Title</label>
                    <div class="col-sm-6"> 
                      <input class="form-control" type = "text" name = "stitle" value = "<?php echo $user->info['title'];?>" readonly>
                    </div>                    
                  </div>
                   <div class="form-group">
                    <label for="ctitle" class="col-sm-4 control-label" style="font-weight:normal;font-size:18px;">Username</label>
                    <div class="col-sm-6"> 
                      <input class="form-control" type = "text" name = "susername" value = "<?php echo $user->Username;?>" readonly>
                    </div>                    
                  </div>
                   <div class="form-group">
                    <label for="ctitle" class="col-sm-4 control-label" style="font-weight:normal;font-size:18px;">Date of Birth</label>
                    <div class="col-sm-6"> 
                      <input class="form-control" type = "text" name = "sdob" value = "<?php echo $user->info['birthdate'];?>" readonly>
                    </div>                    
                  </div>                                    
                  <hr>
                  <div class="form-group">
                    <label for="fname" class="col-sm-4 control-label" style="font-weight:normal;font-size:18px;">First name</label>
                    <div class="col-sm-6"> 
                      <input class="form-control" type = "text" id = "fname" name = "fname" value = "<?php echo isset($_POST['fname']) ? $_POST['fname'] : $user->info['firstname']; ?>">
                    </div>                    
                  </div>
                  <div class="form-group">
                    <label for="lname" class="col-sm-4 control-label" style="font-weight:normal;font-size:18px;">Last name</label>
                    <div class="col-sm-6">
                      <input class="form-control" type = "text" id = "lname" name = "lname" value = "<?php echo isset($_POST['lname']) ? $_POST['lname'] : $user->info['lastname']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mail" class="col-sm-4 control-label" style="font-weight:normal;font-size:18px;">Email</label>
                    <div class="col-sm-6">
                       <input class="form-control" type = "text" id = "mail" name = "mail" value = "<?php echo isset($_POST['mail']) ? $_POST['mail'] :  $user->info['email']; ?>"> 
                       <h5 style="color:red;"></h5>
                    </div>                    
                  </div>                
                  
                 <div class="col-sm-4"></div>
                 <div class="col-sm-1">
                   <input type = "submit" class = "btn btn-primary" id = "button" name ="update_form" value = "Update"/> 
                </div>
                <div class="col-sm-5"></div>
                <br>
                <br>
                </form>   
                          
                     <?php 
                   if($message){
                    ?>
                    <div class="col-sm-2"></div>                     
                    <div class="alert alert-success fade in col-sm-8">
                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h5 style = "text-align:center"><?php echo "Account Updated successfully"; ?></h5>
                    </div>
                   
                    <?php
                    }?>    
                    </div>                            
              </SECTION>
              </div><!--div 2 row -->
                  </div>
                </div>
              </div><!-- end of div 1 row--> 
            </div>
    </div><!-- /.container -->
   <!-- Footer -->
    <footer class="footer">        
      <div class="container">
        <?php include '../footer.html';?>
      </div>       
    </footer>
        <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>


</body>

</html>