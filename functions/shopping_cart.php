<?php
$cart = false;
if(!isset($_SESSION)){
  session_start();
} 
require_once '../model/product.php';

if (isset($_POST['buy']) && $_POST['buy']=="Add to basket") {
   
  if(isset($_SESSION['purchase_cart'] [$_POST['id']])){ 
    
           header('location:my_basket.php');
        }
        else{
          $product1 = new Product();
          if($product1->is_sale($_POST['id'])){
                 $product1->get_product($_POST['id']);
                 $_SESSION['purchase_cart'][$_POST['id']] = array(
                                 "name" => $product1->productInfo['ProductName'],
                                 "quantity" =>$_POST['quantity'], 
                                  "price" =>$product1->productInfo['SellingPrice'],
                                  "image"=>$product1->productInfo['image'],
                                  "seller"=>$product1->productInfo[0]['seller'],
                                  "email"=>$product1->productInfo[0]['email']
                              );
                 header('location:my_basket.php');
                 
               }

          }//end of isset session cart        

}//end of isset get action buy
if (isset($_POST['rent']) && $_POST['rent']=="Add to basket") {
   
  if(isset($_SESSION['rent_cart'] [$_POST['id']])){ 
    
           header('location:my_basket.php');
        }
        else{
          $product2 = new Product();
          if($product2->is_rental($_POST['id'])){
                 $product2->get_product($_POST['id']);
                 $_SESSION['rent_cart'][$_POST['id']] = array(
                                 "name" => $product2->productInfo['ProductName'],
                                 "quantity" =>$_POST['quantity'], 
                                  "rentingrate" =>$product2->productInfo['RentingRate'],
                                  "image"=>$product2->productInfo['image'],
                                  "max_week"=>$_POST['rent_for'],
                                  "seller"=>$product2->productInfo[0]['seller'],
                                  "email"=>$product2->productInfo[0]['email']
                              );
                 header('location:my_basket.php');                 
               }
          }//end of isset session cart        

}//end of isset get action buy


?>
