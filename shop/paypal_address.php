<?php
require_once'../address.php';
if(!defined('enter')){
	header('location:'.$address['buy']);
}
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
?>