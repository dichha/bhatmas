<?php
require_once'../vendor/autoload.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/PaymentDetailsRequest.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/GetPaymentOptionsRequest.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/GetPaymentOptionsResponse.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/Receiver.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ReceiverList.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/PaymentInfoList.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/PaymentInfo.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ReceiverOptions.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/InvoiceItem.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/InvoiceData.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ReceiverIdentifier.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/SenderOptions.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/ShippingAddressInfo.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/SenderOptions.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/SenderIdentifier.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/setPaymentOptionsRequest.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/Common/RequestEnvelope.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Service/adaptivePaymentsService.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/payResponse.php';
require_once '../vendor/paypal/adaptive/lib/PayPal/Types/AP/PaymentDetailsResponse.php';
/*
 *  # PaymentDetails API
 Use the PaymentDetails API operation to obtain information about a payment. You can identify the payment by your tracking ID, the PayPal transaction ID in an IPN message, or the pay key associated with the payment.
 This sample code uses AdaptivePayments PHP SDK to make API call
 */
/*
 * 
		 PaymentDetailsRequest which takes,
		 `Request Envelope` - Information common to each API operation, such
		 as the language in which an error message is returned.
 */
$requestEnvelope = new PayPal\Types\Common\RequestEnvelope("en_UK");
/*
 * 		 PaymentDetailsRequest which takes,
		 `Request Envelope` - Information common to each API operation, such
		 as the language in which an error message is returned.
 */
$paymentDetailsReq = new PayPal\Types\AP\PaymentDetailsRequest($requestEnvelope);
$getPaymentOptionsReq = new PayPal\Types\AP\ GetPaymentOptionsRequest($requestEnvelope, "AP-49W77496JF542973C");
/*
 * 		 You must specify either,
		
		 * `Pay Key` - The pay key that identifies the payment for which you want to retrieve details. This is the pay key returned in the PayResponse message.
		 * `Transaction ID` - The PayPal transaction ID associated with the payment. The IPN message associated with the payment contains the transaction ID.
		 `paymentDetailsRequest.setTransactionId(transactionId)`
		 * `Tracking ID` - The tracking ID that was specified for this payment in the PayRequest message.
		 `paymentDetailsRequest.setTrackingId(trackingId)`
 */


$paymentDetailsReq->transactionId = "70W08856UF831481Y";

/*
 * 	 ## Creating service wrapper object
Creating service wrapper object to make API call and loading
Configuration::getAcctAndConfig() returns array that contains credential and config parameters
 */
$sdkConfig = array(
	  "mode" => "sandbox",
	  "acct1.UserName" => "bhatmashelp-facilitator_api1.gmail.com",
	  "acct1.Password" => "KSPBTJ3ZU3ALFFTU",
	  "acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31Arz6UPoHy6u6v1ESVRy.0rXPk5-b",
	  "acct1.AppId" => "APP-80W284485P519543T"
	);

$service = new PayPal\Service\AdaptivePaymentsService($sdkConfig);
try {
	/* wrap API method calls on the service object with a try catch */
	$response = $service->PaymentDetails($paymentDetailsReq);
	$response1 = $service->GetPaymentOptions($getPaymentOptionsReq);
} catch(Exception $ex) {
	require_once 'Common/Error.php';
	exit;	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>PayPal Adaptive Payments - Payment Details</title>
<link href="../css/sdk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/sdk_functions.js"></script>
</head>

<body>
	<div id="wrapper">
		<img src="https://devtools-paypal.com/image/bdg_payments_by_pp_2line.png"/>
		<div id="response_form">
			<h3>Payment Details</h3>
<?php 
$ack = strtoupper($response->responseEnvelope->ack);
$ack1 = strtoupper($response1->responseEnvelope->ack);
if($ack != "SUCCESS" && $ack1!="SUCCESS"){
	echo "<b>Error </b>";
	echo "<pre>";
	print_r($response);
	echo "</pre>";
} else {
/*
 * 			 The status of the payment. Possible values are:
			
			 * CREATED - The payment request was received; funds will be
			 transferred once the payment is approved
			 * COMPLETED - The payment was successful
			 * INCOMPLETE - Some transfers succeeded and some failed for a
			 parallel payment or, for a delayed chained payment, secondary
			 receivers have not been paid
			 * ERROR - The payment failed and all attempted transfers failed
			 or all completed transfers were successfully reversed
			 * REVERSALERROR - One or more transfers failed when attempting
			 to reverse a payment
			 * PROCESSING - The payment is in progress
			 * PENDING - The payment is awaiting processing
 */
	echo "<table>";
	echo "<tr><td>Ack :</td><td><div id='Ack'>$ack</div> </td></tr>";
	echo "<tr><td>PayKey :</td><td><div id='PayKey'>$response->payKey</div> </td></tr>";
	echo "<tr><td>Status :</td><td><div id='Status'>$response->status</div> </td></tr>";
	echo "</table>";
	echo "<pre>";
	var_dump($response1);
	foreach ($response1 as $key => $value) {
		 if($key == "receiverOptions"){
		 	foreach ($value as $key1 => $value1) {
		 		foreach ($value1->invoiceData as $key2 => $value2) {
		 			if($key2 == "item"){
		 				foreach ($value2 as $key3 => $value3) {
		 					echo $value3->name;
		 					# code...
		 				}
		 			}
		 			# code...
		 		}
		 		# code...
		 	}
		 		# code...
		 	}
		 
	}
	foreach ($response as $key => $value) {
		
		if($key == "shippingAddress"){

			echo $value->addresseeName . "\n";
			echo $value->street1 . "\n";
			echo $value->city . "\n";
			echo $value->state . "\n";
			echo $value->zip . "\n";
			echo $value->country . "\n";
				# code...
			}
		}

	echo "</pre>";
}
?>
<table id="apiResponse">
	<tr>
		<td>Request:</td>
	</tr>
	<tr>
		<td><textarea rows="10" cols="100"><?php echo htmlspecialchars($service->getLastRequest());?></textarea>
		</td>
	</tr>
	<tr>
		<td>Response:</td>
	</tr>
	<tr>
		<td><textarea rows="10" cols="100"><?php echo htmlspecialchars($service->getLastResponse());?></textarea>
		</td>
	</tr>
</table>
<br>
<a href="index.php">Home</a>
		</div>
	</div>
</body>
</html>