<?php

$newArray = array();

if(isset($_SESSION['purchase_cart'])){

	if(!empty($_SESSION['purchase_cart'])){
		foreach ($_SESSION['purchase_cart'] as $key => $value) {
			$newArray[] = $value['seller'];
		}
	}
}


if(isset($_SESSION['rent_cart'])){

	if(!empty($_SESSION['rent_cart'])){
		foreach ($_SESSION['rent_cart'] as $key => $value) {
			$newArray[] = $value['seller'];
		}
	}
}

$sellerArray = array_unique($newArray);

$count = count($sellerArray);


?>