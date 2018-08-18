<?php

require_once(__DIR__.'/../model/user.php');
$errors= array(); //array to hold error messages

function sanitize($data){
	 $data = trim($data); // remove unnecessary extra space, new line, tab etc
     $data = stripslashes($data); //remove slashes
     $data = htmlspecialchars($data); //function that converts special characters to HTML entities
     $data = preg_replace('/\s+/', '', $data); //removes whitespace
     return $data;
}

function is_alpha($data){
	//checks for only alphabets
     $data1 = sanitize($data);
	 if (ctype_alpha($data1)){
	 	return true;
	 }else{
	 	return false;
	 }
}

function valid_username($data){

	//checks for alpha numeric characters with underscore
	$data1 = sanitize($data);
	if(preg_match('/^[A-Za-z0-9_]+$/', $data) == 1){
		return true;
	}else{
		return false;
	}
}

function username_length($data){

	//check username legnth
	$data1 = sanitize($data);
	if(strlen($data1)<4 && strlen($data1)<16){
		return true;
	}else{
		return false;
	}

}

function name_length($data){

	//check user name legnth
	$data1 = sanitize($data);
	if(strlen($data1)>=3 && strlen($data1)<30){
		return true;
	}else{
		return false;
	}
}

function valid_password($data){

	/*allows one lowercase char
    at least one uppercase char
    at least one number
    at least one special character*/
    $data1 = sanitize($data);

	 if(preg_match('/^(?=.*\d)(?=.*[\@\#\$\?\%\+\&\_\-\!])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z\@\#\$\?\%\+\&\_\-!]{5,25}$/',$data1) ==1){
	 	return true;
	 }else{
	 	return false;
	 }
}

function confirm_password($data1,$data2){

	$data3 = sanitize($data1);
	$data4 = sanitize($data2);

	if(strcmp($data3, $data4) == 0 ){
		return true;
	}else{
		return false;
	}
}

function password_length($data){

	if(strlen($data)>4 && strlen($data)<26){
		return true;
	}else{
		return false;
	}

}

function valid_email($data){

	$data1 = sanitize($data);

	if (filter_var($data1, FILTER_VALIDATE_EMAIL)) {
    	return true;
	}else{
		return false;
	}
}

function output_errors($errors){
	return '<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
}

function check_age($year,$month,$day){
	//minimun age set 18
	  $date = new DateTime();
	  $date->setDate($year, $month, $day);
	  $date->format('Y-m-d');
	  $min_age = 18;
  	  $date2 = new DateTime(date('Y-m-d'));
  	  $interval = $date->diff($date2);
  	  if($interval->y >= $min_age){
  	  	return true;
  	  }else{
  	  	return false;
  	  }
}

function set_date($year,$month,$day){

	$date = new DateTime();
	$date->setDate($year, $month, $day);
	$newdate = $date->format('Y-m-d');
	return $newdate;
}

function authenticate(){
	if(!(isset($_COOKIE['login']))){
		return true;
		}else{
			header('location:../account/user.php');
		}
}

function numeric($data){
	//check if its numeric
	if(is_numeric($data)){
		return true;
	}else{
		return false;
	}
}

function is_number($data){
	//check a valid number
	if(is_numeric($data)){
		$data = intval($data);
		if(is_int($data)){
			if($data>0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}else{
		return false;
	}
}

function max_length($data){
	//max of 120 characters for product names and informations

	if(strlen($data)<=120){
		return true;
	}else{
		return false;
	}

}

function generate_id(){
	$a = rand(1,10000);
	$b = substr(md5($a), 0,7);
	return "bm".$b;
}

function username_exists($name){
	$user = new User();
	if($user->username_exists($name)){
		return true;
	}else{
		return false;
	}
}

function is_postcode($postcode){
 $postcode = strtoupper(str_replace(' ','',$postcode));
    			if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/",$postcode) || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/",$postcode) || preg_match("/^GIR0[A-Z]{2}$/",$postcode))
   				 {
              
        				return true;
    			}else{
    				return false;
    			}
    				
}


?>

