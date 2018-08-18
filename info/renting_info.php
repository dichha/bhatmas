<?php
 require_once 'dir.php';
 $info_active="active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Bhatmas | Renting Information</title>
	<!--Bootstrap core css -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>


</head>

<body class="renting_info">
<?php include'../header.php'; ?>

      
      <div class="container">
      <div class="col-sm-2" style="color:rgb(86,90,92);font-family: Circular; font-size:17px;padding-top:20px;">
      <ul>
        <li style="list-style-type:none;"class="buy_head"><a href="buying_info.php" style="text-decoration:none;font-family: Circular;"><b>Buying</b></a></li><br>
        <li style="list-style-type:none;font-family: Circular;" class="sell_head"><a href="selling_info.php" style="text-decoration:none;font-family: Circular;"><b>Selling</b></a></li><br>
        <li  style="list-style-type:none;font-family: Circular;"><a style="color:rgb(86,90,92);text-decoration:none;font-family: Circular;"><b>Renting</b></a></li>

        </ul>



      </div>
      <h2 style="color:rgb(86,90,92)">Renting</h2>
      <div class="col-sm-8 info">
      <p><b>To whom all does renting term applies?</b><br>
      You can be both renter and rentee to use the platform.</p><br> 
      <p><b>What all can I rent?</b><br>
      <b>Anything</b>. Yes,again anything you think would be marketable and is in condition that will do quality job. So think twice before you toss away that expensive Gucci bag just because you need space for newer ones.</p><br>

       <p><b>How will I get notified once my item has been sold?</b><br>
        You will be notified through your email. You will have three working days to ship an item to a customer. </p><br>

       <p><b>Is there a way that monitors my renting rate as a renter?</b><br>
        Yes, you'll be reviewd by your customers by judging the description you write for the product and the condition they got it. Your rate will be varied accordingly. So keep up with your renting rate and customer satisfaction.
        
       </p><br>



      <button class = "rent_info center-block">
      <?php if(!(isset($_COOKIE['username'])===true)){
        ?>
        <a href="shop/rent.php" style="text-decoration:none; color:white">

        <?php
      }else{
        ?>
        <a href="account/user.php" style="text-decoration:none; color:white">
        <?php
      }

        ?>

        Spread the Resource</a></button>
        
      </div>
      </div>
      <div class="col-sm-2"></div> 
      	
      
      <footer class="footer">
      <div class="container">
      	<!--<p class="pull-right"><a href="#">Back to top</a></p>-->
        <?php include '../footer.html'; ?>
      </div>
      </footer>


 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>


</body>
</html>