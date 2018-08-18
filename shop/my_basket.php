<?php
if(!isset($_SESSION)){
  session_start();
} 
require_once'shop.php';
require_once'../functions/basket.php';
$_SESSION["total_price1"]=$_SESSION["total_price2"]=0;

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
    <title>Bhatmas | My Basket</title>
      <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="../js/jquery.validate.js"></script>
      <script src="../js/additional.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" >
    <!-- Custom styles for this template -->
    <link  rel="stylesheet"type="text/css" href="../css/sticky-footer-navbar.css">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <!-- Fixed navbar -->
    <?php include'../header.php'; ?>
    <!-- Begin page content -->
    <div class="container">
      <div class="col-sm-12">
      <div class="page-header">
        <h1 style="color:#21610B">Shopping Cart</h1>
        <a href="buy.php">Continue Shopping</a>
      </div>
          <!-- <div class="row">  -->    
            <div class="col-sm-8">
                  <!-- <div class="well"> -->
                  <?php
                  if(empty($_SESSION['purchase_cart']) && empty($_SESSION['rent_cart'])){
                    ?><h3>Your basket is empty</h3><?php
                  }
                  ?>
                  <?php
                      //checking if shopping cart is not empty
                      if(!empty($_SESSION['purchase_cart'])){
                        $_SESSION["total_price1"] = 0;
                  ?>
                <div class="row sale_summary">
                  <div class="col-sm-12">
                    <form method="post" action="my_basket.php" method="POST">
                      <h2>Purchase items</h2>
                        <div class="table">
                            <div class="row">   
                              <div class="col-sm-12">                             
                                <div class="col-sm-2">Product</div>
                                <div class="col-sm-2">Quantity</div>
                                <div class="col-sm-2">Price</div>
                                <div class="col-sm-2">Sub Total</div> 
                                <div class="col-sm-2"></div>
                              </div><!--col-sm-12-->   
                                                      
                            </div><!--row-->
                            <hr> 
                            <div class="row">
                              <div class="col-sm-12">
                            <?php                      
                              foreach ($_SESSION['purchase_cart'] as $pID =>$value) {
                                $product->get_product($pID);
                                //echo $product->productInfo['Quantity'];

                              ?>
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="col-sm-2">
                                    <a href=""><img class="img-thumbnail" src="<?php echo $value['image'];?>" alt=""></a>

                                    <h5><a href="item.php?pid=<?php echo $pID;?>" style="text-decoration:none;"><?php echo ucfirst($value['name']);?></a></h5>
                                        </div>
                                        <div class="col-sm-2">
                                           <select name="item_quantity[<?php echo( $pID);?>]">
                                                <option value="<?php echo $value['quantity']; ?>">
                                                    <?php echo $value['quantity']; ?>
                                                </option>
                                                <option value="" disabled>--</option>
                                                <?php
                                                for($i = 1; $i<= $product->productInfo['Quantity'];$i++){
                                                  ?>
                                                  <OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
                                                  <?php
                                                }
                                                ?>
                                               
                                            </select>                         
                                        </div>
                                        <div class="col-sm-2">
                                            &pound<?php echo $value['price'] ?>
                                            
                                        </div>
                                        <div class="col-sm-2">
                                            &pound<?php echo $value['quantity'] * $value['price'];
                                            $_SESSION["total_price1"] += $value['quantity'] * $value['price']; ?>                                            

                                        </div>
                                        <div class="col-sm-2"><a href="my_basket.php?action=remove&id=<?php echo $pID;?>">Remove</a></div>
                                      </div><!--/.col-sm-12 -->
                                    </div><!--/.row -->

                                    <?php
                                  }//iterating through shopping cart ends here
                                  ?>
                                        <hr>
                                <div class="row">
                        
                                      <div class = "col-sm-4">                                                
                                        <input type="submit" name="update_quantity" value="Update Sale">
                                      </div>                                              

                                    
                                    <div class="col-sm-4">Total Price: &pound<?php echo $_SESSION["total_price1"];?></div>
                                    <div class="col-sm-4"></div>                                    
                                </div><!--/.row -->
                            </div><!--/.col-sm-12 -->

                          </div><!--/.row -->
                        </div><!-- /.table -->
                      </form>
                    </div><!-- /.col-sm-12 -->
                  </div><!-- /.row -->
                                  <?php
                                  //checking for empty cart ends here
                                }else{
                                  $_SESSION['total_price1']=0;

                                } 

                                ?>
                          

                  <!-- rent -->
                  <?php
                     //checking if shopping cart is not empty
                            if(!empty($_SESSION['rent_cart'])){
                              $_SESSION["rent_price2"] = 0;
                  ?>
                  <div class="row rent_summary">
                  <div class="col-sm-12">
                    <form method="post" action="my_basket.php" method="POST">
                      <h2>Rent items</h2>
                        <div class="table">
                            <div class="row">   
                              <div class="col-sm-12">                             
                                <div class="col-sm-2">Product</div>
                                <div class="col-sm-2">Quantity</div>
                                <div class="col-sm-2">Rent For</div>
                                <div class="col-sm-2">Renting Rate</div> 
                                <div class="col-sm-2">Sub Total</div>
                              </div><!--col-sm-12-->   
                                                      
                            </div><!--row-->
                            <hr> 
                            <div class="row">
                              <div class="col-sm-12">
                            <?php
                          
                              foreach ($_SESSION['rent_cart'] as $pID =>$value) {
                                $product->get_product($pID);
                                //echo $product->productInfo['Quantity'];

                              ?>
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="col-sm-2">
                                    <a href=""><img class="img-thumbnail" src="<?php echo $value['image'];?>" alt=""></a>

                                    <h5><a href="item.php?pid=<?php echo $pID;?>" style="text-decoration:none;"><?php echo ucfirst($value['name']);?></a></h5>
                                        </div>
                                        <div class="col-sm-2">
                                           <select name="item_quantity[<?php echo( $pID);?>]">
                                                <option value="<?php echo $value['quantity']; ?>">
                                                    <?php echo $value['quantity']; ?>
                                                  
                                                </option>
                                                <option value="" disabled>--</option>
                                                <?php
                                                for($i = 1; $i<= $product->productInfo['Quantity'];$i++){
                                                  ?>
                                                  <OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
                                                  <?php
                                                }
                                                ?>
                                               
                                            </select>                         
                                        </div>
                                        <div class="col-sm-2">
                                          <select name="item_rent_for[<?php echo( $pID);?>]">
                                                <option value="<?php echo $value['max_week']; ?>">
                                                    <?php echo $value['max_week']; ?>
                                                </option>
                                                <option value="" disabled>--</option>
                                                <?php
                                                for($i = 1; $i<= $product->productInfo['RentalMaxDuration'];$i++){
                                                  ?>
                                                  <OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
                                                  <?php
                                                }
                                                ?>
                                               
                                            </select> 

                                        </div>
                                        <div class="col-sm-2">
                                            &pound<?php echo $value['rentingrate']; ?>/week
                                            
                                        </div>
                                        
                                        <div class="col-sm-2">
                                          &pound<?php echo $value['quantity'] * $value['rentingrate'] * $value['max_week'];
                                            $_SESSION["total_price2"] += $value['quantity'] * $value['rentingrate']* $value['max_week']; ?>&nbsp;


                                          <a href="my_basket.php?action=remove&id=<?php echo $pID;?>">Remove</a></div>
                                      </div><!--/.col-sm-12 -->
                                    </div><!--/.row -->

                                    <?php
                                  }//iterating through shopping cart ends here
                                  ?>
                                         <hr>
                                <div class="row">
                        
                                      <div class = "col-sm-4">                                                
                                        <input type="submit" name="update_quantity" value="Update Rent">
                                      </div>                                    
                                    <div class="col-sm-4">Total Price: &pound<?php echo $_SESSION["total_price2"];?></div>
                                    <div class="col-sm-4"></div>                                    
                                </div><!--/.row -->
                                </div><!--/.col-sm-12 -->

                          </div><!--/.row -->
                        </div><!-- /.table -->
                      </form>
                    </div><!-- /.col-sm-12 -->
                  </div><!-- /.row -->
                                  <?php

                                  //checking for empty cart ends here
                                }else{
                                  $_SESSION['total_price2']=0.00;

                                } 

                                ?>
                         


                </div> <!-- /.col-sm-8-->              

                <div class="col-sm-4">
                  <!--Summary-->
                  <div class="row well">
                    <div class="col-sm-12">
                  <?php
                  if(!empty($_SESSION['purchase_cart']) || !empty($_SESSION['rent_cart']) ){
                    ?>
                 
                      <h4>Cart Summary</h4>
                      <hr>
                      
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="col-sm-6">Sub total</div>
                            <div class="col-sm-6">&pound<?php echo $_SESSION["total_price1"] + $_SESSION["total_price2"]; ?></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                          <div class="col-sm-6">Shipping</div>
                          <div class="col-sm-6">&pound 5.00</div>
                          </div>
                        </div>
                        <div class="row" style="background-color:#8FBC8F">
                          <div class="col-sm-12">
                          <div class="col-sm-6 success">Total</div>
                          <div class="col-sm-6 success">&pound <?php echo $_SESSION["total_price1"] + $_SESSION["total_price2"] + 5;?></div>
                          
                        </div>
                      </div>
                     
                      
                  
                    <?php
                  }
                  ?>
                  <br>
                  <div class="row"><a href="checkout.php" class="btn btn-block">Checkout</a></div>
                  </div><!--/.col-sm-12-->
                </div><!--/.row -->
              </div> <!--/.col-sm-4 -->
                       
        <!-- </div> --> <!--/.row-->  
      </div><!--/.col-sm-12 -->             
    </div>

    <footer class="footer">
      <div class="container">
        <?php include'../footer.html'; ?>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
