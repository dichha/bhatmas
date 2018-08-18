<?php

$name = $_POST['firstname'];
$name = trim($name); // remove unnecessary extra space, new line, tab etc
$name = stripslashes($name); //remove slashes
$name = htmlspecialchars($name); //function that converts special characters to HTML entities
$name = preg_replace('/\s+/', '', $name); //removes whitespace

if($name == NULL){

	echo "Enter your first name";

}else if(strlen($name)<3){
    echo "3 minimum characters required";
}
?>