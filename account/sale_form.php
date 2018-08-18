<?php
session_start();
require_once '../model/user.php';
require_once '../model/product.php';
require_once '../functions/core_functions.php';
require_once '../functions/upload.php';

$user = new User();
$user->authenticate();
$display_errors = false;
$product = new Product();
$user->get_userid();
$_SESSION['upload'] = false;

if(isset($_POST['upload'])){
  if(empty($_POST) ===false){
  $required_fields = array('item_name','fileToUpload','selling_price','quantity','item_info');
  foreach ($_POST as $key => $value) {    
    if(empty($value) && in_array($key,$required_fields) ===true){
      $errors[] = 'Please fill in every form fields.';
      break 1;     
    }
  }//end of for each block

  if(empty($errors) === true){
    if (numeric($_POST['selling_price']) == false) {
      $errors[] = "Please enter a valid price";
    }
     if (is_number($_POST['quantity']) == false) {
      $errors[] = "Please enter a valid quanity number";
    }
      if (max_length($_POST['item_name']) == false) {
      $errors[] = "Maximum of 120 characters allowed";
    }
      if (max_length($_POST['item_info']) == false) {
      $errors[] = "Maximum of 120 characters allowed";
    }
    
      if(!empty($_FILES['fileToUpload'])){
        if(empty($upload_error) ===true){
            
          if (is_image() ===false) {
              $upload_error[] = "File is not an image.";           
              # code...
            }
          if(file_type($imageFileType) === true){
              $upload_error[] = "JPG, JPEG, PNG & GIF files are allowed";
            }     
            if(file_exist($target_file) ===true){
              $upload_error[] = "File is already in use. Please choose another file.";
            }
          if(upload_size() ===true){
              $upload_error[] = "File is too large.";
            } 
          }         
       
    }else{
      $upload_error[] = "File cannot be empty";
    }//end of $upload_error;       
    
}
}//end of if empty sale form block
if(empty($_POST['upload']) ===false && empty($errors) == true &&empty($upload_error) == true){
  $productid = generate_id();
  if($product->is_unique_id($productid)){
     try {
    if($product->insert_sale_product($productid,$_POST['item_name'],$_POST['item_info'],$target_file,$user->get_userid(),$_POST['quantity'],$_POST['selling_price'],$_POST['category'])){
      if(upload($target_file)){
        $_SESSION['upload'] = true;
        header('location:item_info.php');
      }else{
        $upload_error[] = "Sorry, there was an error uploading your file.";
        echo "here";

      }
    }else{
      echo $user->userID;
    }
     
   } catch (Exception $e) {
     
   }

  }else{
    $errors[] = "Please try again.";
  }
  //end of if unique
  
}else{
  //display errors
  $display_errors =true;
}//end of if empty post sale and erros block

}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bhatmas | Item Form</title>

    <noscript>       
      <div class = "lead"> You don't have javascript enabled.  Please turn it on.      
      </div>
    </noscript>

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
    <script src="../js/jquery.js"></script>
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
                  <h1 class="page-header">Item Sale Form                      
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Item Sale Form                      
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
                      <div id = "sell">
          <?php
          if($display_errors){
            ?>
            <div class="alert alert-warning">
            <strong>
              <?php
              if($display_errors){echo output_errors($errors); echo output_errors($upload_error);}
              ?>
            </strong>         
          </div>
            <?php
          }
          ?>
          <form class = "form-horizontal" method ="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="item_name" class="col-sm-3 control-label">Product name</label>
              <div class="col-sm-9">
                <input class="form-control" type = "text" id = "item_name" name = "item_name" style="width:27%;"placeholder=" Item name" value = "<?php echo isset($_POST['item_name']) ? htmlspecialchars($_POST['item_name']) : ''?>">                
              </div>              
            </div>
            <div class="form-group">
              <label for="category_name" class="col-sm-3 control-label">Category</label>
              <div class = "col-sm-9">
                <?php include '../functions/form_category.php';?>              
              </div>
            </div>
            <div class="form-group">
              <label for="image" class="col-sm-3 control-label">product image</label>
              <div class="col-sm-9">
                <!-- chaging the way pic is stored -->
                <input type = "file" name="fileToUpload">
                <p class="help-block">("jpeg","jpg","png" only supported and less than 2 MB)</p>
              </div>
              
            </div>
            <div class="form-group">
              <label for="selling_price" class="col-sm-3 control-label"> Selling price (GBP)</label>
              <div class="col-sm-9">
              <input class="form-control" type = "text" id = "selling_price" name = "selling_price" style="width:27%;" placeholder = " Selling Price" value = "<?php echo isset($_POST['selling_price']) ? $_POST['selling_price'] : ''?>"> &#163;               
              </div>              
            </div>
            <div class="form-group">
              <label for="quantity" class="col-sm-3 control-label">Product quantity</label>
              <div class="col-sm-9">
                <input class="form-control" type = "text" id = "quantity" name = "quantity" style="width:27%" placeholder=" Product Quantity"value = "<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''?>">
              </div>              
            </div>
            <div class="form-group">
              <label for="item_into" class="col-sm-3 control-label">Product brief description </label>
              <div class="col-sm-9">
                <textarea class = "form-control" rows ="4" cols = "50" id = "item_info" name = "item_info" style="width:42%;" placeholder = " Enter brief product description..."><?php echo isset($_POST['item_info']) ? $_POST['item_info'] : ''?></textarea>
              </div>                          
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <input id = "button1" type="submit" class="btn btn-primary" name = "upload"  value = "Upload Item For Sale"/>
                            
            </div> 
            <br>              
        
          </form>
        </div>
        <br>
      
      </SECTION>      
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
