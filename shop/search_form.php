<?php
if(!isset($_SESSION)){
  session_start();
}
require_once 'shop.php';
    

$itemperpage = 2;
if(!(isset($_GET['page']))){
  $page=1;
  $start_from = ($page-1)*$itemperpage;
}else{
  //Convert the page number to an integer
  $page=(int)$_GET['page'];
  $start_from = ($page-1)*$itemperpage;
}

if (isset($_POST['search_button'])){

  if($_POST['search_button'] == 'Search'){
      $query_item = trim($_POST['search_item']);  
      $query_category = $_POST['category'];

      $_SESSION['query_item'] = $query_item;
      $_SESSION['query_category'] = $query_category;
        
      $product->search_item($_SESSION['query_item'],$_SESSION['query_category'], $start_from, $itemperpage);  
  }
//   if(isset($_GET['page'])){
//     $query_item = trim($_POST['search_item']);
//     $query_category = $_POST['category'];
//     $product->search_item($query_item,$query_category, $start_from, $itemperpage);
//}else{
//  header('location:../index.php');
//}
 }else if (isset($_GET['page']) && isset($_GET['cat'])){
  if (isset($_SESSION['query_item']) && isset($_SESSION['query_category'])){
    $product->search_item($_SESSION['query_item'],$_SESSION['query_category'], $start_from, $itemperpage);
  }  
 }else if (isset($_GET['cat']) && !isset($_GET['page'])){
  if (isset($_SESSION['query_item']) && isset($_SESSION['query_category'])){
    $new_cat = $_GET['cat'];
    //echo $new_cat;
    $_SESSION['query_category'] = $new_cat;
    $product->search_item($_SESSION['query_item'],$_SESSION['query_category'], $start_from, $itemperpage);
  }  


}else{header('location:../index.php');
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

    <title>Bhatmas.com</title>
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
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
                <h1 class="page-header" style="color: #21610B;">Results for <span>
                  <?php
                  $default_category="All Categories";
                  $_SESSION['default_category'] = $default_category;
                  ?>

                  <a href='search_form.php?cat=<?php echo $_SESSION['default_category']; ?>' style = "color:#007a87;"><?php echo htmlspecialchars($_SESSION['query_item']); ?></a></span> in <span style= "color:#007a87"><?php echo htmlspecialchars($_SESSION['query_category']);?></span>
                    <small>better and cheaper</small>
                </h1>
              </span>
              <span class="visible-xs">
                <h3 class="page-header" style="color: #21610B;">Results for <span>
                  <?php
                  $default_category="All Categories";
                  $_SESSION['default_category'] = $default_category;
                  ?>

                  <a href='search_form.php?cat=<?php echo $_SESSION['default_category']; ?>' style = "color:#007a87;"><?php echo htmlspecialchars($_SESSION['query_item']); ?></a></span> in <span style= "color:#007a87"><?php echo htmlspecialchars($_SESSION['query_category']);?></span>
                    <small>better and cheaper</small>
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
                     if(!empty($product->search_items)){
                      foreach ($product->search_items as $key => $value) {
                        ?>
                        <div class = "row" id = "product">
                              <div class="col-sm-4" id="product-image">
                                <a href="item.php?id=<?php echo htmlspecialchars($key); ?>"><span class="helper"></span><img class="img-responsive center-block img-thumbnail" src="<?php echo $value['image'];?>" alt=""></a>
                              </div>
                              <div class="col-sm-8" id="product-info">

                              <span class="visible-xs">
                                <?php
                                $product_name = ucfirst($value['ProductName']);

                                if (strlen($product_name)>15){
                                  ?>
                                  <a href="item.php?id=<?php echo htmlspecialchars($key);?>"><h5 style="text-align:center; color:#007a87;"><?php echo $product_name;?></h5></a>
                                <?php
                                }else{
                                  ?>
                                  <a href="item.php?id=<?php echo htmlspecialchars($key);?>"><h4 style="text-align:center; color:#007a87; "><?php echo $product_name;?></h4></a>
                                  <?php
                                }
                                ?>
                                <?php if (strlen($product_name) < 15){
                                  ?>
                                
                                <h5 style="text-align:center"><?php $quant = $value['Quantity']; ?>
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
                                <a href="item.php?id=<?php echo htmlspecialchars($key);?>" style="color:#007a87; text-decoration:none;"><h3><?php echo ucfirst($value['ProductName']);?></h3></a>
                                <h5 class="pull-right">
                                  <?php $product_status="";?>

                                  <?php if ($value['RentingRate'] !== NULL){
                                    $product_status = "For Rent";
                                  }
                                  ?>
                                  <?php if($value['SellingPrice'] !== NULL){
                                    $product_status = "For Sale";
                                  }
                                  ?>
                                  <span class="label label-info"><?php echo $product_status; ?></span>

                                </h5>
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
                                <div class="clearfix visible-md visible-lg"></div>
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
                          </div><!--/.col-md-7 -->
                        </div>
                        
                    
                        <?php                        
                      }
                     }else{
                      ?>
                      <h4>There is currently no items with the name <b><?php echo htmlspecialchars($_SESSION['query_item']); ?></b>. Please try later.</h4>
                      <h5><a href="../index.php">Click here </a>to search more.</h5>
                      <?php
                     }
                     ?>                    
                  </div> <!-- /.col-sm-12 -->
                
                  
                </div> <!-- row --> 
            </div> <!--end of div col-sm-8 row-->
            <div class = "row pag text-center">
              <?php
              // if (isset($_SESSION['query_item']) && isset($_SESSION['query_category'])){ 
                $query_item = $_SESSION['query_item'];
                //echo $query_item;
                $query_category = $_SESSION['query_category'];
                $total_pages = ceil($product->search_query_total_items($query_item, $query_category)/$itemperpage);
                //echo $total_pages;
              // }
              


              ?>
              <ul class="pagination">
                <?php if ($total_pages > 0) {?> 
                <li><a href="search_form.php?page=1&cat=<?php echo $_SESSION['query_category']; ?>">First</a></li>
                <?php 
                if(!(isset($_GET['page'])) && !(isset($_GET['cat']))){
                ?>
                <li class="active"><a href="search_form.php?page=1&cat=<?php echo $_SESSION['query_category'];?>">1</a></li>
                <?php 
                for($j=2; $j<=$total_pages; $j++){
                  ?>
                  <li><a href="search_form.php?page=<?php echo $j; ?>&cat=<?php echo $_SESSION['query_category']; ?>"><?php echo $j; ?></a></li>
                  <?php
                  }
                }else if (isset($_GET['cat']) && !isset($_GET['page'])){
                  ?>
                   <li class="active"><a href="search_form.php?page=1&cat=<?php echo $_SESSION['query_category'];?>">1</a></li>
                <?php 
                for($j=2; $j<=$total_pages; $j++){
                  ?>
                  <li><a href="search_form.php?page=<?php echo $j; ?>&cat=<?php echo $_SESSION['query_category']; ?>"><?php echo $j; ?></a></li>
                  <?php
                  }
                }else{
                  for ($k=1; $k<=$total_pages; $k++){
                    if($k == $_GET['page']){
                      ?>
                      <li class="active"><a href="search_form.php?page=<?php echo $k;?>&cat=<?php echo $_SESSION['query_category'];?>"><?php echo $k; ?></a>
                        <?php
                    }else{  
                    ?>
                    <li><a href="search_form.php?page=<?php echo $k;?>&cat=<?php echo $_SESSION['query_category']; ?>"><?php echo $k; ?></a></li>
                    <?php
                    }//else
                  }//for
                }//else


              ?>
                <li><a href="search_form.php?page=<?php echo $total_pages; ?>&cat=<?php echo $_SESSION['query_category']; ?>">Last</a></li>               
            <?php
            }
            ?>
              </ul>
            </div>
        </div> <!-- end of div 1 row-->

    </div><!-- /.col-sm-12 -->
   </div>
    <!-- /.container -->

        <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <?php include'../footer.html'; ?>
      </div>
    </footer>
        <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>