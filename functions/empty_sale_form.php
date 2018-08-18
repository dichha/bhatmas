<?php
require_once'core_functions.php';
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
    }
  }
?>