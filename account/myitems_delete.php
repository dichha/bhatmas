<?php
session_start();
require_once('../model/user.php');
require_once('../model/product.php');
$user = new user();
$user->authenticate();
$product = new Product();

if(!(isset($_GET['pid']))){
	header('lcoation:user.php');
}
if(isset($_POST['yesdelete'])){
	if($_POST['yesdelete'] =="Yes"){
		if($product->delete_product($_GET['pid'])){
			$_SESSION['deleted'] = true;
		}
	
	}
}//end of isset yesdelte block
if(isset($_POST['nodelete'])){
	if($_POST['nodelete'] =="No"){
		header('location:myitems.php');
		}	
	
}//end of isset yesdelte block
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!--The above meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Bhatmas | Items Delete</title>

	<!--Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<!--Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">

</head>
<body>
	<?php include'../header.php'; ?>
	<div class="container">
		<div class="page-header">
			<h1 style="color:#21610B;">Delete Product</h1>			
		</div>
				<div class="col-sm-7">
				<?php
				if(!($_SESSION['deleted'])){
					?>
					<form class="form-horizontal" method="POST" action = "myitems_delete.php?pid=<?php echo htmlspecialchars($_GET['pid']); ?>" enctype="multipart/form-data" id="delete_item">				
						<h3>Are you sure want to delete <a href=""> sdfasd</a>?
							<input id="delete_btn" type="submit" class="btn btn-sm btn-danger" name="yesdelete" value="Yes"/>
							<input id="delete_btn" type="submit" class="btn btn-sm btn-info" name="nodelete" value="No"/></h3>
						</div>			
					</form>	
					<?php
					}
					?> 
				</div>
				<div class="col-sm-7">
				<?php
				if($_SESSION['deleted']){
					?><h4>Your item has been deleted. User can no longer order the item.<a href="myitems.php">Click here </a>to go back to your inventry.</h4>	<?php
				}
				?>
			</div>
	</div><!-- ./container -->
	<footer class="footer">
      <div class="container">
       <?php include '../footer.html'; ?>
      </div>
    </footer>

    <noscript>
      <div class="lead">You don't have javascript enabled. Please turn it on.         
      </div>
    </noscript>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!--<script src="js/additional.js"></script>-->

</body>
</html>