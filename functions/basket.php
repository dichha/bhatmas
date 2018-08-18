<?php
    //for updating shopping cart

if (isset($_GET['action'])) {

  $action = $_GET['action'];
  $id = $_GET['id'];


  switch ($action) {
    case 'remove':

   if(!empty($_SESSION['purchase_cart'])){
     foreach ($_SESSION['purchase_cart'] as $key=>$value) {

        if($key == $id){
          unset($_SESSION['purchase_cart'][$key]);  
          if(isset($_SESSION['merchant_bill'])) unset($_SESSION['merchant_bill']);
        }
        # code...
      }
   }
     if(!empty($_SESSION['rent_cart'])){
       foreach ($_SESSION['rent_cart'] as $key=>$value) {

        if($key == $id){
          unset($_SESSION['rent_cart'][$key]);    
          if(isset($_SESSION['merchant_bill'])) unset($_SESSION['merchant_bill']);      
        }
        # code...
      }
     }
      break;
    
  }
  # code...
}

if (isset($_POST["update_quantity"])) {
 if (!empty($_SESSION['purchase_cart'])) {
   if($_POST['update_quantity'] == "Update Sale"){

      foreach ($_POST["item_quantity"] as $key => $value) {
       
       $_SESSION['purchase_cart'][$key]['quantity'] = $value;
       
      # code...
    } 
  }//update sale
   # code...
 }

if (!empty($_SESSION['rent_cart'])) {
    if($_POST['update_quantity'] == "Update Rent"){
    foreach ($_POST["item_quantity"] as $key => $value) {
       
       $_SESSION['rent_cart'][$key]['quantity'] = $value;
       
      # code...
    } 

  }
  # code...
}
}



?>