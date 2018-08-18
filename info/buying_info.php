<!DOCTYPE html>
<?php
 require_once 'dir.php';
 $info_active="active";
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Bhatmas | Buying Information</title>
	<!--Bootstrap core css -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>


</head>

<body class="buying_info">
<?php include'../header.php'; ?>

      
      <div class="container">
      
      <div class="col-sm-2" style="color:rgb(86,90,92);font-family: Circular; font-size:17px;padding-top:20px;">
      <ul>
        <li style="list-style-type:none;" onclick="buyInfo()"><b>Buying</b><!--a href="buying_info.php" style="color:rgb(86,90,92);text-decoration:none;font-family: Circular;"><b>Buying</b></a>--></li>
        <br>
        <li style="list-style-type:none;" onclick="sellInfo()"><b>Selling</b><!--<a style="text-decoration:none;font-family: Circular;" href="selling_info.php"><b>Selling</b></a>--></li><br>
        <li  style="list-style-type:none;" onclick="rentInfo()"><b>Renting</b><!--font-family: Circular;" class="rent_head"><a style="text-decoration:none;font-family: Circular;" href="renting_info.php"><b>Renting</b></a>--></li>

        </ul>



      </div>
      <div id="trans_info">
        <h2 style="color:rgb(86,90,92)">Buying</h2>
        <div class="col-sm-8 info">
        <p><b>Who puts products for sale?</b><br>
         People like you. They want to make the best use of resources they have. This way they are making other users who will buy the product happy at the same time they are also generating revenue.</p><br>

         <p><b>Will the product be brand new?</b><br>
         The condition will be listed in the description section of the product. If you want job done in a quality way with much low price, <b>this</b> is the place to buy.</p><br>

         <p><b>How does this platform leverage customer desire and sustainability?</b><br>
  		We strive to <b>not</b> let anyone's desire be left just because they are out of their means. We also make sure that too much resources are not wasted in that quest. So reusing products which otherwise would have been stored for ages or be out of one's means, we brought you this platform.
         	
         </p><br>
        <!-- <button class = "buy_info center-block"><a href="shop/buy.php" style="text-decoration:none; color:white">Buy it Resourcefully</a></button> -->
        <button class="buy_info center-block"><a href="shop/buy.php" style="text-decoration:none; color:white;">Buy Resourcefully</a></button>
        	
        </div>
      </div>
      <div class="col-sm-2"></div> 
      
      
  
      	
      </div>
      <div class="col-sm-4"></div>
      <footer class="footer">
      <div class="container">
      	<!--<p class="pull-right"><a href="#">Back to top</a></p>-->
        <?php include '../footer.html'; ?>
      </div>
      </footer>
      <script type="text/javascript">
        function buyInfo(){
          document.getElementById("trans_info").innerHTML = "<h2 style=\"color:rgb(86,90,92)\">Buying</h2><div class=\"col-sm-8 info\"><p><b>Who puts products for sale?</b><br>People like you. They want to make the best use of resources they have. This way they are making other users who will buy the product happy at the same time they are also generating revenue.</p><br><p><b>Will the product be brand new?</b><br>The condition will be listed in the description section of the product. If you want job done in a quality way with much low price, <b>this</b> is the place to buy.</p><br><p><b>How does this platform leverage customer desire and sustainability?</b><br> We strive to <b>not</b> let anyone's desire be left just because they are out of their means. We also make sure that too much resources are not wasted in that quest. So reusing products which otherwise would have been stored for ages or be out of one's means, we brought you this platform </p><br><!-- <button class = \"buy_info center-block\"><a href=\"shop/buy.php\" style=\"text-decoration:none; color:white\">Buy it Resourcefully</a></button> --><button class=\"buy_info center-block\"><a href=\"shop/buy.php\" style=\"text-decoration:none; color:white;\">Buy Resourcefully</a></button></div>"
        }

        function sellInfo(){
         document.getElementById("trans_info").innerHTML = "<h2 style=\"color:rgb(86,90,92)\">Selling</h2><div class=\"col-sm-8 info\"><p><b>What all can I put for sale?</b><br><b>Anything</b>. Yes, literally anything you think would be marketable and is in condition that will do quality job. So think twice before you toss away that expensive Gucci bag just because you need space for newer ones.</p><br><p><b>How will I get notified once my item has been sold?</b><br>You will be notified through your email. You will have three working days to ship an item to a customer. </p><br><p><b>Is there a way that monitors my selling rate?</b><br>Yes, you'll be reviewd by your customers by judging the description you write for the product and the condition they got it. Your rate will be varied accordingly. So keep up with your selling rate and customer satisfaction.</p><br><button class = \"sell_info center-block\" style=\"width:200px; height:37.5px; border-color: #007a87;background-color: #007a87;font-weight:bold;font-size: 20px;border-radius: 4px;\"><?php if(!(isset($_COOKIE['username'])===true)){?><a href=\"../shop/buy.php\" style=\"text-decoration:none; color:white\"><?php }else{?><a href=\"../account/user.php\" style=\"text-decoration:none; color:white\"><?php }?> Spread the Resource</a></button></div>"
        }


        function rentInfo(){
          document.getElementById("trans_info").innerHTML = "<h2 style=\"color:rgb(86,90,92)\">Renting</h2><div class=\"col-sm-8 info\"><p><b>To whom all does renting term applies?</b><br>You can be both renter and rentee to use the platform.</p><br><p><b>What all can I rent?</b><br><b>Anything</b>. Yes,again anything you think would be marketable and is in condition that will do quality job. So think twice before you toss away that expensive Gucci bag just because you need space for newer ones.</p><br><p><b>How will I get notified once my item has been sold?</b><br>You will be notified through your email. You will have three working days to ship an item to a customer. </p><br><p><b>Is there a way that monitors my renting rate as a renter?</b><br>Yes, you'll be reviewd by your customers by judging the description you write for the product and the condition they got it. Your rate will be varied accordingly. So keep up with your renting rate and customer satisfaction.</p><br><button class = \"rent_info center-block\" style=\"width:200px;height:37.5px; border-color: #007a87;border-bottom-color: #004f58;background-color: #007a87;color: white;font-weight:bold;font-size: 20px;border-radius: 4px;\"><?php if(!(isset($_COOKIE['username'])===true)){?><a href=\"../shop/rent.php\" style=\"text-decoration:none; color:white\"><?php }else{?><a href=\"../account/user.php\" style=\"text-decoration:none; color:white\"><?php }?> Spread the Resource</a></button></div>"
        }


      </script>

 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>


</body>
</html>