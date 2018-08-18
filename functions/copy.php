<?php
    //for updating shopping cart
if (!isset($_POST['buy']) && !isset($_POST['rent'])) {
  header("location:../shop/buy.php");
  # code...
}

if (isset($_GET['action'])) {

  $action = $_GET['action'];
  $id = $_GET['id'];


  switch ($action) {
    case 'remove':

    foreach ($_SESSION['purchase_cart'] as $key=>$value) {

        if($key == $id){
          unset($_SESSION['purchase_cart'][$key]);          
        }
        # code...
      }
      foreach ($_SESSION['rent_cart'] as $key=>$value) {

        if($key == $id){
          unset($_SESSION['rent_cart'][$key]);          
        }
        # code...
      }
      break;
    
  }
  # code...
}

if (isset($_POST["update_quantity"])) {
  if($_POST['update_quantity'] == "Update Sale"){

	    foreach ($_POST["item_quantity"] as $key => $value) {
	     
	     $_SESSION['purchase_cart'][$key]['quantity'] = $value;
	     
	    # code...
	  } 
	}//update sale

	if($_POST['update_quantity'] == "Update Rent"){
		foreach ($_POST["item_quantity"] as $key => $value) {
	     
	     $_SESSION['rent_cart'][$key]['quantity'] = $value;
	     
	    # code...
	  } 

	}

}

?>