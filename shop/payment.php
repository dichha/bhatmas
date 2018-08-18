<?php
session_start();
require_once'../vendor/autoload.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/PayRequest.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/Receiver.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ReceiverList.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ReceiverIdentifier.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ReceiverOptions.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/SenderOptions.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/InvoiceItem.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/InvoiceData.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/SetPaymentOptionsRequest.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/Common/RequestEnvelope.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Service/AdaptivePaymentsService.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/PayResponse.php';
require_once 'assign.php';
require_once '../model/paypal.php';
require_once '../model/user.php';

	$user = new USer();
	$user->get_userid();
	$sender = $user->userID;
	$payRequest = new PayPal\Types\AP\PayRequest();

	$receiver = array();
	$receiver[0] = new PayPal\Types\AP\Receiver();
	$receiver[0]->amount = $_SESSION['grand_total'];
	$receiver[0]->email = "prksh123@gmail.com";
	$receiver[0]->primary = "true";

	$i = 1;

	foreach ($_SESSION['merchant_bill'] as $key => $value) {
		$receiver_1_amount = $value * 0.9;
		$receiver[$i] = new PayPal\Types\AP\Receiver();		
		$receiver[$i]->amount = $receiver_1_amount;
		$receiver[$i]->email = "dhirendra123@gmail.com";
		$i++;
	}

	//assign receiver emails and amount to variables
	$a0 = $_SESSION['grand_total'];
	$r0 = $receiver[0]->email; $a0 = $receiver[0]->amount;
	$r1 = $receiver[1]->email; $a1 = $receiver[1]->amount;
	$r2 = "NA"; $a2 = 0.00;

	if(!empty($receiver[2]->email)){
		$receiver[2]->email = "bhatmashelp-buyer@gmail.com";
		$r2 = $receiver[2]->email;
	}else{
		$r2 = "NA";
	}

	if(!empty($receiver[2]->amount)){
		$a2 = $receiver[2]->amount;
	}else{
		$a2 = 0.00;
	}

	$receiverList = new PayPal\Types\AP\ReceiverList($receiver);
	$payRequest->receiverList = $receiverList;

	$requestEnvelope = new PayPal\Types\Common\RequestEnvelope("en_UK");
	$payRequest->requestEnvelope = $requestEnvelope; 
	$payRequest->actionType = "CREATE";
	$payRequest->memo ="hello world";
	$payRequest->cancelUrl = "http://bhatmas.com/user_d1/beta/v4/shop/buy.php";
	$payRequest->returnUrl = "http://bhatmas.com/user_d1/beta/v4/shop/payment_receipt.php";
	$payRequest->currencyCode = "GBP";
	$payRequest->ipnNotificationUrl = "http://bhatmas.com/user_d1/paypal_ipn.php";

	$sdkConfig = array(
	  "mode" => "sandbox",
	  "acct1.UserName" => "bhatmashelp-facilitator_api1.gmail.com",
	  "acct1.Password" => "KSPBTJ3ZU3ALFFTU",
	  "acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31Arz6UPoHy6u6v1ESVRy.0rXPk5-b",
	  "acct1.AppId" => "APP-80W284485P519543T"
	);

	$adaptivePaymentsService = new PayPal\Service\AdaptivePaymentsService($sdkConfig);

	try {
	/* wrap API method calls on the service object with a try catch */
	$payResponse = $adaptivePaymentsService->Pay($payRequest); 
	$ack = strtoupper($payResponse->responseEnvelope->ack);
	if ($ack == "SUCCESS") {
	$payKey = $payResponse->payKey;
	$paypal = new Paypal();
	 $paypal->insert_payment($payKey,$sender,$a0,$r1,$a1,$r2,$a2);
	}
	} catch (Exception $ex) {
	require_once '..\vendor\paypal\adaptive\samples\Common\Error.php';
	exit;
	}
	$setPaymentOptionsRequest = new PayPal\Types\AP\SetPaymentOptionsRequest(new PayPal\Types\Common\RequestEnvelope("en_UK"));
	$setPaymentOptionsRequest->payKey = $payKey;

	$receiverOptions = new PayPal\Types\AP\ReceiverOptions();
	$senderOptions = new PayPal\Types\AP\SenderOptions();

	$receiver  = array();
	$receiverId1 = new PayPal\Types\AP\ReceiverIdentifier();	
	$receiverId1->email = "dhirendra123@gmail.com";
	$receiver[] = $receiverId1;


	$receiverId2 = new PayPal\Types\AP\ReceiverIdentifier();	
	$receiverId2->email = "prksh123@gmail.com";
	$receiver[] = $receiverId2;


	$receiverOptions->receiver = $receiver;

	$invoiceItems = array();
	
	if(!empty($_SESSION['purchase_cart'])){
		foreach ($_SESSION['purchase_cart'] as $pID =>$value) {

		$item = new PayPal\Types\AP\InvoiceItem();
		$item->name = $value['name'];
		$item->identifier = $pID;
		$item->price = $value['price'] * $value['quantity'];
		$item->itemPrice = $value['price'];
		$item->itemCount = $value['quantity'];
		$invoiceItems[] = $item;
		}
     
	}//end of purchase cart
	echo "total price 1  = ".$_SESSION['grand_total'];
	if(!empty($_SESSION['rent_cart'])){

		foreach ($_SESSION['rent_cart'] as $pID =>$value) {
		$item = new PayPal\Types\AP\InvoiceItem();
		$item->name = $value['name'];
		$item->identifier = $pID;
		$item->price = $value['rentingrate']*$value['quantity']*$value['max_week'];
		$item->itemPrice = $value['rentingrate'];
		$item->itemCount = $value['quantity'];
		$item->itemWeek = $value['max_week'];
		$invoiceItems[] = $item;
		}//end of rent cart
	}
	 
	

	$senderOptions->requireShippingAddressSelection = true;
	$receiverOptions->description = "Your list of items";
	$receiverOptions->invoiceData = new PayPal\Types\AP\InvoiceData();
	$receiverOptions->invoiceData->item = $invoiceItems;

	$setPaymentOptionsRequest->receiverOptions[] = $receiverOptions;
	$setPaymentOptionsRequest->senderOptions= $senderOptions;

	$response = $adaptivePaymentsService->SetPaymentOptions($setPaymentOptionsRequest);

	var_dump($response);
	$ack1 = strtoupper($response->responseEnvelope->ack);
	if($ack1 = "SUCCESS"){
		$_SESSION['paykey'] = $payKey;
	  $address = "https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay?paykey=".$payKey;
	  //header('Location:'.$address); 
	} 

?>

