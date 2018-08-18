<?php   
   require_once '../model/user.php';
   require_once '../model/order.php';
   require_once '../model/product.php';
   require_once '../address.php';
   require_once('../model/PHPMailer/PHPMailerAutoload.php');
   date_default_timezone_set('Etc/UTC');
   $user = new User();
   $order = new Order();
   $product = new product();
   $delivery = false;

   $user->authenticate();
   $order_no = "";$buyer_email = "";
   $productid = "";
   if(isset($_POST['r_deliver'])){
    if($_POST['r_deliver'] == "Return"){
      $order_no = $_POST['o_no'];
      $productid = $_POST['p_id'];
      $renter_email = $_POST['renter_email'];
      
      $order->get_shipping_address($order_no);
      $product->get_product($productid);  
    }else{
    	header('location:'.$address['order_request']);	
    }
   }else{
    header('location:'.$address['order_request']);
   }

   if($order->shipped_item($order_no,$productid)){
   	$mail = new PHPMailer;
   	$order->get_item_request($order_no,$productid);

   	//for checking rental items
   	$week = "";
   	if($order->iteminfo['week'] == 0){
   		$week = "NA";
   	}else{
   		$week = $order->iteminfo['week'];
   	}

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 2;

	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';

	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';
	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "sheeseer@gmail.com";

	//Password to use for SMTP authentication
	$mail->Password = "ZxCvBnM12#";

	//Set who the message is to be sent from
	$mail->setFrom('service@bhatmas.com', 'bhatmas.com');

	//Set an alternative reply-to address
	$mail->addReplyTo('service@bhatmas.com', 'bhatmas');

	//Set who the message is to be sent to
	//$mail->addAddress($user->info['email'], $name);
	$mail->addAddress("dhirezxc@gmail.com", "dikchya");
	//Set the subject line
	$mail->Subject = 'Your Order Delivery';

	$mail->isHTML(true);
	//getting item details 
	$mail->Body = "Your item has been dispatched by the seller.";
	$mail->Body.="<br>"."<br>";
	$mail->Body.= "<table rules='all' style='border-color: #666;' cellpadding='10'><tr style='background:#009900;'><th>No</th><th>Item</th><th>Quantity</th><th>Total Rental Week</th></tr>";
	$mail->Body.="<tr>
                  <td>".$order_no."</td><td>".$product->productInfo['ProductName']."</td><td>".$order->iteminfo['quantity']."</td><td>".$week."</td>
                </tr> ";

   	$order->get_shipping_address($order_no);
   	$mail->Body.= "</table>"; //close table
	$mail->Body.="<br>";
	$mail->Body.="Shipping Address";
	$mail->Body.="<br>";
      $mail->Body.=$order->address['name'];
      $mail->Body.="<br>";
      $mail->Body.=$order->address['street1'];
      $mail->Body.="<br>";
      $mail->Body.= $order->address['street2'];
      $mail->Body.="<br>";
      $mail->Body.= $order->address['city'];
      $mail->Body.="<br>";
      $mail->Body.= $order->address['state'];
      $mail->Body.="<br>";
      $mail->Body.= $order->address['zip'];
      $mail->Body.="<br>";
      $mail->Body.= $order->address['country'];
      $mail->Body.="<br>";
      
        # code...
    
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
          } else {
             $delivery = true;
          }                
   } //end of if condtion

?>
<!doctype html>
<html>

	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bhatmas | Confirm Order</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
			
	</head>
	<BODY>
  <!-- Fixed navbar -->
  <?php //include'../header.php'; ?>

  <!--Begin page content -->
  <div class="container">
		<div class = "page-header">
    <h1> Delivery</h1>
    </div>
    <?php
    if($delivery){
    	echo "An email has been dispatched to the seller notifying that the item has been dispatched by you.";
    }
    ?>
  
   </div> <!-- end of header-->
   <footer class="footer">
      <div class="container">
        <?php include'../footer.html'; ?>
      </div>
    </footer>
   <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
  </BODY> 
  
      
    </footer>
</html>
