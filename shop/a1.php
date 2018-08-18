<?php

/*if(!isset($_POST['email'])){
	echo "working";
}*/

session_start();
$_SESSION['receiver'][0] = "apple";
$_SESSION['receiver'][1] = "mango";

$receiver2 = $_SESSION['receiver'][1];
echo $receiver2;
?>