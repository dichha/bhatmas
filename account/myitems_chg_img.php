<?php 
require_once '../model/user.php';
require_once'../model/product.php';
require_once '../functions/upload.php';
require_once '../functions/core_functions.php';
$user = new User();
$user->authenticate();
$product = new Product();
$display_errors = false;
$update = false;
$type = ""; //type of product
if(isset($_GET['pid'])){
  if($product->is_sale($_GET['pid'])){
    $type = "sale";
  }else if($product->is_rental($_GET['pid'])){
    $type = "rental";
  }else{
     header('location:user.php'); //404 page not found
  }
  
}else{
  header('location:user.php'); // 404 page not found
}//end of isset block
$product->get_product($_GET['pid']);

if(isset($_POST['img_form'])){
 if ($_POST['img_form'] =="Update Image") {
   require_once '../functions/check_upload_error.php';      
  if(empty($_POST['img_form']) ===false && empty($upload_error) == true){
    if($product->update_image($_GET['pid'],$target_file)){
       if(upload($target_file)){
        $update = true;
       }else{
        $upload_error[] = "Error uploading image";
       }
    }else{
      $upload_error[] = "Error updating image.";
    }

  }else{
    //display errors
    $display_errors =true;
  }
     # code...
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
                  <h1 class="page-header">Update Item Image                    
                  </h1>
                </span>
                <span class="visible-xs">
                  <h3 class="page-header">Update Item Image                 
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
    if ($update) {
      ?><div class="alert alert-success">
          <strong>Success!</strong> Your proudct's image has been updated.
        </div>
      <?php
    }
    ?>
      <?php
      if($display_errors){

            ?>
            <div class="alert alert-warning">
            <strong>
              <?php
                echo output_errors($upload_error);
              ?>
            </strong>         
          </div>
            <?php
          }
      switch ($type) {
        case 'sale':
        ?>  <form class = "form-horizontal" action="myitems_chg_img.php?pid=<?php echo htmlspecialchars($_GET['pid']); ?>" method ="POST" enctype="multipart/form-data" id="sell_form">
              <div class="form-group">
                <label for="item_name" class="col-sm-3 control-label">Product name</label>
                <div class="col-sm-9">
                  <input class="form-control" type = "text" id = "item_name" name = "item_name" style="width:27%;" value="<?php echo $product->productInfo['ProductName']; ?>" readonly>                
                </div>              
                </div>
                <div class="form-group">
                  <label for="selling_price" class="col-sm-3 control-label"> Selling price (GBP)</label>
                  <div class="col-sm-9">
                    <input class="form-control" type = "text" id = "selling_price" name = "selling_price" style="width:27%;" value="<?php echo $product->productInfo['SellingPrice']; ?>" readonly >
                  </div>              
                </div>
                <div class="form-group">
                  <label for="image" class="col-sm-3 control-label">Product image</label>
                  <div class="col-sm-9">
                    <input type = "file" name="fileToUpload">
                    asdfsdf
                    <p class="help-block">("jpeg","jpg","png" only supported and less than 2 MB)</p>
                    <img src="<?php echo $product->productInfo['image'];?>" alt="image" width="200px">                     
                  </div>              
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <input id = "button1" type="submit" class="btn btn-primary" name = "img_form"  value = "Update Image"/>               
                </div> 
                <br>              
              </form>
        <?php
          # code...
          break;

          case 'rental':
          ?>
          <form class = "form-horizontal" action ="myitems_chg_img.php?pid=<?php echo htmlspecialchars($_GET['pid']); ?>" method ="POST" enctype="multipart/form-data" id="rent_form">
              <div class = "form-group">
                <label for = "item_name" class="col-sm-3 control-label">Product name</label>
                <div class="col-sm-9">
                  <input class="form-control" type = "text" name = "item_name" id="item_name" style="width:27%;" value="<?php echo $product->productInfo['ProductName']; ?>" readonly>                
                </div>              
              </div>
              <div class="form-group">
                <label for="item_week" class="col-sm-3 control-label">Maximum renting duration</label>
              <div class="col-sm-5" >
                <SELECT class = "form-control" name = "item_week" id="item_week" style="width:27%;">
                  <OPTION selected="selected"><?php echo $product->productInfo['RentalMaxDuration']; ?></OPTION>
                 </SELECT>
                </div>  
                <div class="col-sm-4"></div>                        
              </div>
              <div class="form-group">
                <label for="item_rate" class="col-sm-3 control-label">Rental rate (GBP)</label>
                <div class="col-sm-9">
                  <input class="form-control" type = "text" id = "item_rate" name = "item_rate" style="width:27%" value="<?php echo $product->productInfo['RentingRate']; ?>" readonly> &#163;/week
                </div>
              
              </div>
          
              <div class="form-group">
              <label for="quantity" class="col-sm-3 control-label"> Product quantity</label>
              <div class="col-sm-9">
                  <input class="form-control" type = "text" id = "quantity" name = "quantity" style="width:27%;" value="<?php echo $product->productInfo['Quantity']; ?>" readonly>
              </div>            
              </div>
           
              <div class="form-group">
              <label for="item_info" class="col-sm-3 control-label">Product brief description</label>
              <div class="col-sm-9">
                  <textarea rows ="4" cols = "50" id = "item_info" name = "item_info" class = "form-control" style="width:42%;" readonly><?php echo $product->productInfo['ProductDescription']; ?></textarea>
              </div>           
              </div>  
               <div class="form-group">
                  <label for="image" class="col-sm-3 control-label">Product image</label>
                  <div class="col-sm-9">
                    <input type="file" name="image"/>
                    <p class="help-block">("jpeg","jpg","png" only supported and less than 2 MB)</p>
                    <img src="<?php echo $product->productInfo['image'];?>" alt="image" width="200px">                     
                  </div>              
                </div>
              
              <div class="col-sm-3"></div>
              <div class="col-sm-9">           
                  <input id = "button2" type="submit" class = "btn btn-primary" name = "img_form" value = "Update Image"/>
              </div>       
          
              </form>

          <?php
            # code...
            break;
        
        default:
          # code...
          break;
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
