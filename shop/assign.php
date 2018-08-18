<?php
if(!isset($_SESSION)) session_start();
$newArray = array();

$merchant_bill = array();

if(isset($_SESSION['purchase_cart'])){

	if(!empty($_SESSION['purchase_cart'])){
		foreach ($_SESSION['purchase_cart'] as $key => $value) {
			$newArray[$value['email']][$key] = array (
				'item_price' => ($value['price'] * $value['quantity'])
				);
		}
	}
}

//var_dump($newArray);
if(isset($_SESSION['rent_cart'])){

	if(!empty($_SESSION['rent_cart'])){
		foreach ($_SESSION['rent_cart'] as $key => $value) {
			$newArray[$value['email']][$key] = array (
				'item_price' => ($value['rentingrate'] * $value['quantity'] *$value['max_week'])
				);
		}
	}
}


//iterate through new array
// for adding total amount to a receiver
if(!empty($_SESSION['purchase_cart'])){
	foreach ($_SESSION['purchase_cart'] as $key => $value) {

	foreach ($newArray as $key1 => $value1) {
		$amount = 0;

		foreach ($value1 as $key2 => $value2) {

			// match email username and sum up total amount
			if($value['email'] == $key1){
				$amount += $value2['item_price'];
				$_SESSION['merchant_bill'] [$key1] = $amount;

			}
		}

	}
	# code...
}
}

if(!empty($_SESSION['rent_cart'])){
	foreach ($_SESSION['rent_cart'] as $key => $value) {

		foreach ($newArray as $key1 => $value1) {
			$amount = 0;

			foreach ($value1 as $key2 => $value2) {

				// match email username and sum up total amount
				if($value['email'] == $key1){
					$amount += $value2['item_price'];
					$_SESSION['merchant_bill'] [$key1] = $amount;

				}
			}

		}
		# code...
	}
}


?>