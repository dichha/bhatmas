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

	<title>Bhatmas | About</title>
	<!--Bootstrap core css -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>



</head>

<body class="about">
<?php include'../header.php'; ?>

      
      <div class="container">
      <div class="col-sm-2" style="list-style-type:none;font-weight:bold;font-size:15px;">
      <br>
        <ul>
        <li style="list-style-type:none;font-family: Circular"; onClick="aboutUs()">About Us<!--<a href="about.php" style="color:rgb(86,90,92);text-decoration:none;font-family: Circular;"></a>--></li>
        <br>
        <li  style="list-style-type:none;font-family: Circular;" class="founders" onClick="foundersInfo()">Founders<!--<a href="founders.php" >Founders</a>--></li>

        </ul>
      </div>
      <div class="col-sm-1"></div>
      <div id="displayInfo">
      
      <h2 style="color:rgb(86,90,92)">About Us</h2> 

      <div class="col-sm-9" id="about">

      	<br>
      	<p>Bhatmas is an online niche marketplace for economy sharing where renters/sellers and rentees/buyers  carry out transactions from listings of the platform.The values of this platform are:</p>
      		<ul class="list-unstyled">
      		<li>affordable prices of items for all</li>
      		<li>generating revenues from products you no longer need/want</li>
      		<li>maintaining sustainability and eco-friendliness with our needs</li>
      		</ul>

      	<p>Currently we are carrying a test launch with a community in England. Please give us your feedback to improve our service in our <a href="https://docs.google.com/forms/d/1GGBOSSvhMggvmO_FnCID6e9Fid5QEV9-pH_X_nQu82Q/viewform?c=0&w=1" style="color:#21610B; text-decoration:none">feedback form</a>.</p>
      </div>
      	
      </div><!-- end of displayInfo -->
      <script type="text/javascript">
        function aboutUs(){
          document.getElementById("displayInfo").innerHTML = 
          "<h2 style=\"color:rgb(86,90,92)\">About Us</h2><div class=\"col-sm-9\" id=\"about\"><br><p>Bhatmas is an online niche marketplace for economy sharing where renters/sellers and rentees/buyers  carry out transactions from listings of the platform.The values of this platform are:</p><ul class=\"list-unstyled\"><li>affordable prices of items for all</li><li>generating revenues from products you no longer need/want</li><li>maintaining sustainability and eco-friendliness with our needs</li></ul><p>Currently we are carrying a test launch with a community in England. Please give us your feedback to improve our service in our <a href=\"https://docs.google.com/forms/d/1GGBOSSvhMggvmO_FnCID6e9Fid5QEV9-pH_X_nQu82Q/viewform?c=0&w=1\" style=\"color:#21610B; text-decoration:none\">feedback form</a>.</p></div>"
        }
        function foundersInfo(){
          document.getElementById("displayInfo").innerHTML = "<h2 style=\"color:rgb(86,90,92)\">Our Co-founders</h2><div class=\"co-foun\"><div class=\"col-sm-9\"><div class=\"row\"><figure class=\"media-photo media-round pull-left\" style=\"padding-left:7px;margin-left:40px\"><img src=\"../images/roshan.jpg\" width=\"175px\" height=\"175px\" alt=\"Roshan\" style=\"clip:(0px,60px,200px,0px);\"></figure><div class=\"media-body\"><h4 style=\"padding-left:7px;padding-top:1px;padding-bottom:0px;margin-left:60px\">Roshan<br><small style=\"padding-top:3px; color:rgb(130,136,138);\">Co-Founder</small></h4><p style=\"padding-left:7px;font-size:15px;display:block;font-family: Circular,'Helvetica Neue',Helvetica,Arial,sans-serif;line-height:22.88px;color:rgb(86,90,92); margin-left:60px\">Roshan  is a front line marketer, manager and coordinator. He is a student of Business & Management. He was also a team member of Prince Harry’s charity Walking With The Wounded (WWTW).</p></div></div><br><br><div class=\"row\"><figure class=\"media-photo media-round pull-left\" style=\"padding-left:7px;margin-left:40px\"><img src=\"../images/dichha.jpg\" width=\"175px\" height=\"175px\" alt=\"Dichha\" style=\"clip:(0px,60px,200px,0px);\"></figure><div class=\"media-body\"><h4 style=\"padding-left:7px;padding-top:1px;padding-bottom:0px;margin-left:60px\">Dichha<br><small style=\"padding-top:3px; color:rgb(130,136,138);\">Co-Founder</small></h4><p style=\"padding-left:7px;font-size:15px;display:block;font-family: Circular,'Helvetica Neue',Helvetica,Arial,sans-serif;line-height:22.88px;color:rgb(86,90,92); margin-left:60px\">Dichha is pursuing master degree in Computer Science from University of Iowa.  Besides coding she likes hiking, biking, travelling and trying different cuisines.  She cares about women and youth empowerment, poverty alleviation, digital literacy and environment.  </p></div></div><br><br><div class=\"row\"><figure class=\"media-photo media-round pull-left\" style=\"padding-left:7px;margin-left:40px\"><img src=\"../images/bilash.jpg\" width=\"175px\" height=\"175px\" alt=\"Bilash\" style=\"clip:(0px,60px,200px,0px);\"></figure><div class=\"media-body\"><h4 style=\"padding-left:7px;padding-top:1px;padding-bottom:0px;margin-left:60px\">Bilash<br><small style=\"padding-top:3px; color:rgb(130,136,138);\">Co-Founder</small></h4><p style=\"padding-left:7px;font-size:15px;display:block;font-family: Circular,'Helvetica Neue',Helvetica,Arial,sans-serif;line-height:22.88px;color:rgb(86,90,92); margin-left:60px\">DLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consequat, tellus at pulvinar condimentum, leo metus vestibulum velit, commodo metus diam eu sapien. Suspendisse vel velit a nisi faucibus suscipit vitae non dui.  </p></div></div>"
        }



      </script>	
     
  
      	
      </div>
      <footer class="footer">
      <div class="container">
        <!--<p class="pull-right"><a href="#">Back to top</a></p>-->
        <?php include '../footer.html'; ?>
      </div>
      </footer>


 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>


</body>
</html>
