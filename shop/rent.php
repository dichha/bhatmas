<?php
if(!(isset($_SESSION))){
  session_start();
}
require_once 'shop.php';
//Pagination
$total_pages=$total_items=$itemperpage=$start=$page="";
$itemperpage = 2;
 

//Check that the page number is set
if(!(isset($_GET['page']))){
  $page=1;
  $start_from = ($page-1)*$itemperpage;
}else{
  //Convert the page number to an integer
  $page=(int)$_GET['page'];
  $start_from = ($page-1)*$itemperpage;
}

//getting rental products
if (!(isset($_GET['cat'])) && !(isset($_GET['page']))) {
  $product->view_all_rent_product($start_from, $itemperpage);
//getting rental product with pagination
}else if(!(isset($_GET['cat'])) && isset($_GET['page'])){
  $product->view_all_rent_product($start_from, $itemperpage);
//getting rental product with category
}else if(isset($_GET['cat']) && !(isset($_GET['page']))){
  $product->rent_category($_GET['cat'],$start_from, $itemperpage);
  //getting rental product with category and page
}else{
  $product->rent_category($_GET['cat'],$start_from, $itemperpage);
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

    <title>Bhatmas | Rent</title>
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- <link href="../css/1-col-portfolio.css" rel="stylesheet"> -->
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
        <!-- Page Heading -->
        <div class="row">
            <div class="col-sm-12">
                <span class="hidden-xs">
                <h1 class="page-header"><a href="rent.php" style="text-decoration:none; color:#007a87">Rental Products</a>
                    <small>choose item and rent it for weeks</small>
                </h1>
                </span>
                <span class="visible-xs">
                <h3 class="page-header"><a href="rent.php" style="text-decoration:none; color:#007a87">Rental Products</a>
                    <small>choose item and rent it for weeks</small>
                </h3>
                </span>

            </div>
        </div>
         <div class="row"> <!-- div 1 row-->
            <div class="col-sm-3">
                <p class="lead">Category</p>
                <div class="list-group">
                    <?php include 'category.php';?>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-8">
             <div class="col-sm-12">
              <div class="row"> <!-- div 2 row -->
                <?php

                foreach ($product->rent_products as $key => $value) {?>
                    <div class="row" id="product"> <!-- Product row -->
                      <div class="col-sm-4" id="product-image">
                          <a href="item.php?id=<?php echo htmlspecialchars($key);?>"><span class="helper"></span>
                              <img class="img-responsive center-block img-thumbnail" style="padding:5px, height:170px; width: 170px" src="<?php echo $value['image'];?>" alt="">
                          </a>
                      </div><!-- ./col-sm-4 -->
                      <div class="col-sm-8" id="product-info">
                          <span class="visible-xs">
                            <?php $product_name = ucfirst($value['ProductName']); ?>
                            <a href="item.php?id=<?php echo htmlspecialchars($key);?>" style="text-align:center; text-decoration:none">
                              <?php if(strlen($product_name) > 15){?>
                              <h5 style="color:#007a87"><?php echo $product_name;?>;</h5>
                              <?php
                            }else{
                              ?>
                              <h4 style="color:#007a87"><?php echo $product_name;?></h4>
                              <?php
                            }?>
                            </a>
                            <?php if(strlen($product_name) < 15){?>                             <h5 style="text-align:center"><?php $quant = $value['Quantity']; ?>
                            <?php 
                            if($quant > 5){
                              ?>
                              <span class="label label-success"><?php echo $quant; ?> in stock</span>
                              <?php
                            }else if($quant == 0){
                              ?>
                              <span class="label label-danger">Out of stock</span>
                              <?php
                            }else{
                              ?>
                              <span class="label label-warning"><?php echo $quant; ?> in stock</span>
                              <?php
                            }
                            ?></h5>
                            <?php
                          }
                          ?>
                          </span>
                          
                          <span class="hidden-xs">
                          <a href="item.php?id=<?php echo htmlspecialchars($key);?>" style="text-decoration:none"><h3 style="color:#007a87"><?php echo ucfirst($value['ProductName']);?></h3></a>
                          <h5 class="pull-right"><?php echo "Price: ". "&pound".$value['RentingRate'] . "/week";?></h5>                          
                          <h5 class="pull-left"><?php $quant = $value['Quantity']; ?>
                            <?php 
                            if($quant > 5){
                              ?>
                              <span class="label label-success"><?php echo $quant; ?> in stock</span>
                              <?php
                            }else if($quant == 0){
                              ?>
                              <span class="label label-danger">Out of stock</span>
                              <?php
                            }else{
                              ?>
                              <span class="label label-warning"><?php echo $quant; ?> in stock</span>
                              <?php
                            }
                            ?></h5>
                          <div class="clearfix visible-lg visible-md"> </div>
                          <p id="product-descrip">
                           <?php $descrip = ucfirst($value['ProductDescription']);
                              if(strlen($descrip) > 250){
                                $new_descrip = substr($descrip,0,250);
                                ?>
                                <?php echo $new_descrip?><a href="item.php?id=<?php echo htmlspecialchars($key);?>" style="text-decoration:none"><b> ... </b></a>
                                <?php

                              }else{
                                echo $descrip;
                              }


                            ?>
                          </p>
                          </span>
                          
                         <!-- <a class="btn btn-primary" href="item.php?id=<?php// echo htmlspecialchars($key);?>">View</a> -->
                       </div><!-- #/product-info -->
          
                  </div> <!-- end of product row -->
                  
                  <?php
                }//looping through product array
                ?> 
                  
                  <!-- /.row -->
                </div> <!-- end of div 2 row -->

            </div> <!--end of div col-md-9 row-->
            <!-- Pagination -->
    <div class="row pag text-center">
        
          <?php    
            $total_pages = ceil($product->rent_total_items()/$itemperpage);   
            //echo $total_pages;     
            ?>
          <ul class="pagination">
          <?php 
            if(!(isset($_GET['cat']))){
          ?>
          <li><a href='rent.php?page=1'>First</a></li>
          <?php
          }else{
            ?>
            <li><a href='rent.php?cat=<?php echo $_GET['cat'];?>&page=1'>First</a></li>
            <?php
          }
          ?>
          <?php
            //For all rental products
           if(!(isset($_GET['page'])) && !(isset($_GET['cat']))){
              ?>
              <li class="active"><a href="buy.php?page=1">1</a></li>
            <?php            
              for($j=2;$j<=$total_pages;$j++){
                ?>
                <li><a href='rent.php?page=<?php echo $j; ?>'><?php echo $j;?></a>
                </li>
              <?php

                }
                //For rental products pagination without category
              }else if (isset($_GET['page']) && !(isset($_GET['cat']))){
              for ($i=1;$i<=$total_pages;$i++){
                if($i == $_GET['page'] ){
                  ?><li class="active">
                <a href='rent.php?page=<?php echo $i; ?>'><?php echo $i; ?></a>
                <?php
                  }else{
                ?>
                  <li>
                  <?php
                  echo "<a href=rent.php?page=".$i."'>".$i."</a>";
                  ?>
                  </li>
                  <?php
                } //else
              };//for
            }else{ //elseif

              //For category pagination
              $cat = $_GET['cat'];
              $total_pages = ceil($product->rental_total_citems($cat)/$itemperpage);
              //echo($total_pages);

              //just category
              if(isset($_GET['cat']) && (!(isset($_GET['page'])))){
                ?>
              <li class="active"><a href="rent.php?cat=<?php echo $cat;?>">1</a></li>
              <?php
                for($j=2; $j<=$total_pages; $j++){
                  ?>
                  <li><a href="rent.php?cat=<?php echo $cat;?>&page=<?php echo $j; ?>"><?php echo $j; ?></a></li>
                  <?php
                };//for
              }else{ //if (isset($_GET['cat']) && isset($_GET['page'])){//if
                 
                for($c=1;$c<=$total_pages;$c++){
                  if ($c == $_GET['page']){
                    ?>
                    <li class="active">
                      <a href="rent.php?cat=<?php echo $cat; ?>&page=<?php echo $c;?>"><?php echo $page; ?></a>
                    </li>
                  <?php
                  }else{//if
                    ?>
                    <li><a href="rent.php?cat=<?php echo $cat;?>&page=<?php echo $c; ?>"><?php echo $c; ?></a></li>
                    <?php
                  }//else
                };//for
              }//else
            }//else
              ?>
            <?php if(!(isset($_GET['cat']))){
              ?>
            <li><a href='rent.php?page=<?php echo $total_pages; ?>'>Last</a>
            </li>
            <?php
              }else{
                ?>
                <li><a href="rent.php?cat=<?php echo $_GET['cat']; ?>&page=<?php echo $total_pages; ?>">Last</a></li>
                <?php
              }
            ?>
            </ul>

                            
       
     </div><!--row -->


        </div> <!-- end of div 1 row-->
      </div>
    </div>
  </div>
    <!-- /.container -->
     <footer class="footer">        
      <div class="container">
        <?php include '../footer.html';?>
      </div>       
    </footer>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>