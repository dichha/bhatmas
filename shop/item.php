<?php
session_start();
require_once 'shop.php';
require_once '../address.php';
require_once'../functions/shopping_cart.php';
$status = $product->product_Status($_GET['id']);
$product->get_product($_GET['id']);
$pid = htmlspecialchars($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop | Item</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="../css/item.css" rel="stylesheet"> -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/index.css" rel="stylesheet">
 
    <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <?php include '../header.php';?>
    <!-- Page Content -->
    <div class="container">
               <div class="col-sm-12">
        <?php
        switch ($status) {
            case 'sale_item':
                ?>
                <div class = "breadcrumbs">
                    <a href="buy.php">Back to view items</a>
                </div>
                <div class="row"> <!-- sale item row-->  
                    <div class="col-sm-9 sale_descrip">
                        <!-- <div class="thumbnail"> -->  <!-- <div class="thumbnail"> -->  
                        
                            <img class="img-responsive center-block" style="padding:10px;float:center" src="<?php echo $product->productInfo['image'];?>" alt="">
                     
  
                            <div class="caption-full">
                                <h4><?php echo $product->productInfo['ProductName'];?>
                                </h4>
                                <h5 class="pull-right">Price: &pound<?php echo $product->productInfo['SellingPrice'];?></h5>
                              
                                <h5 class="pull-left">
                                    <?php $quant=$product->productInfo['Quantity'] ?>

                                    <?php if ($quant>5){
                                        ?><span class="label label-success"><?php echo $quant;?> in stock</span>
                                    <?php } else if ($quant === 0){?>
                                    <span class="label label-danger">Out of stock</span>

                                    <?php
                                    }else{ ?>
                                    <span class="label label-warning"><?php echo $quant;?> in stock</span>
                                    <?php }?>
                                </h5>

                                <div class="clearfix"></div>
                                <p id="product-descrip"><?php echo $product->productInfo['ProductDescription'];?></p>
                                <div class="clearfix"></div>
                                <p><strong>Currently delivers for UK users only.</strong></p>
                            <!-- </div> -->                          
                        </div>
                    </div>
                   
                      <div class="col-sm-3">
                        <div class="list-group list-group-item">
                         <form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class = "lead"></p>
                               Quantity<select name = "quantity" class = "form-control">
                                <?php
                                for ($i=1; $i<=$product->productInfo['Quantity']; $i++) {
                                    ?><OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
                                    <?php
                                }
                                ?>
                            </select><br>                            
                                <input type = "text" value = "<?php echo htmlspecialchars($_GET['id']);?>" name = "id" readonly hidden> 
                                <?php
                                if(!isset($_COOKIE['login'])){
                                    ?><input type = "submit" class="btn btn-block" name = "buy"value = "Add to basket">                        
                                    <?php
                                }else{                                                                       
                                    if($product->valid_customer($user->get_userid(),$pid)){                                        
                                        ?>
                                        <!-- enable add to basket-->
                                        <input type = "submit" class="btn btn-block" name = "buy"value = "Add to basket">                        
                                        <?php
                                    }else{
                                        ?>
                                        <!-- send to edit items-->
                                        <a class="btn btn-block" href="<?php echo $address['myitems_update']."?pid=".$pid;?>">Update Item</a>                                                                                
                                        <?php
                                    }
                                }
                                ?>
                         </form>                            
                        </div>
                    </div> <!-- col md 3 for box -->

                </div> <!-- sale item row-->
                <?php
                break;
            case 'rent_item':
            ?>
                <div class = "breadcrumbs">
                            <a href="rent.php">Back to view items</a>
                </div>
                <div class="row"> <!-- rent item row-->  
                    <div class="col-md-9 rent_descrip">
                        <!-- <div class="thumbnail"> -->
                            
                            <img class="img-responsive center-block" src="<?php echo $product->productInfo['image'];?>" alt="">
                           
                            <div class="caption-full">
                                
                                <h4><?php echo ucfirst($product->productInfo['ProductName']);?></h4>
                                 <h5 class="pull-right">&pound<?php echo $product->productInfo['RentingRate'];?>/week</h5>
                                 <h5 class="pull-left">
                                    <?php $quant=$product->productInfo['Quantity'] ?>

                                    <?php if ($quant>5){
                                        ?><span class="label label-success"><?php echo $quant;?> in stock</span>
                                    <?php } else if ($quant === 0){?>
                                    <span class="label label-danger">Out of Stock</span>

                                    <?php
                                    }else{ ?>
                                    <span class="label label-warning"><?php echo $quant;?> in stock</span>
                                    <?php }?>
                                </h5>
                                <div class="clearfix"></div>
                                <h5><b>Maximum Rent Period: </b><?php echo $product->productInfo['RentalMaxDuration'];?> weeks
                                </h5>
                                <p><?php echo $product->productInfo['ProductDescription'];?></p>
                                <p><strong>Currently delivers for UK users only.</strong></p>
                            </div>                          
                       <!--  </div> -->
                    </div>
                    
                      <div class="col-md-3">
                        <div class="list-group list-group-item">
                         <form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class = "lead"></p>
                               Quantity <select name = "quantity" class = "form-control">
                                <?php
                                for ($i=1; $i<=$product->productInfo['Quantity']; $i++) {
                                    ?><OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
                                    <?php
                                }
                                ?>
                            </select>
                              Rent For <select name = "rent_for" class = "form-control">
                                <?php
                                for ($i=1; $i<=$product->productInfo['RentalMaxDuration']; $i++) {
                                    ?><OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
                                    <?php
                                }
                                ?>
                            </select>
                            <br>
                            
                                <input type = "text" value = "<?php echo htmlspecialchars($_GET['id']);?>" name = "id" readonly hidden> 
                                <input type = "submit" class="btn btn-block" name = "rent" value = "Add to basket">
                            
                         </form>                            
                        </div>
                    </div> <!-- col md 3 for box -->

                </div> <!-- rent item row-->
            <?php

            break;            
            default:
                # code...
                break;
        }
        ?>
        </div>
        
    </div>
    <!-- /.container -->
     <footer class="footer">        
      <div class="container">
        <?php include '../footer.html'; ?>
      </div>       
    </footer>

    

   

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>