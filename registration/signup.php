<?php
session_start();
require_once '../model/user.php';
require_once '../functions/core_functions.php';
authenticate();

$_SESSION['submit_page'] = false;// session variable to access submit page

$display_errors = false;

if(isset($_POST['formSubmit'])){
	 if(empty($_POST) ===FALSE){

  $required_fields = array('Title','firstname','lastname','uname','pword','cpword','month','day','year','mail');

  foreach ($_POST as $key => $value) {    
    if(empty($value) && in_array($key,$required_fields) ===true){
      $errors[] = 'Please fill in every form fields.';
      break 1;     
    }
  }//end of for each block

  if(empty($errors) ===true){

    if (is_alpha($_POST['firstname'] == false)) {
      $errors[] = "First name should contain only alphabets.";
      # code...
    }

    if(name_length($_POST['firstname']) ==false){
       $errors[] = "Firstname should contain Minimum 3 and Maximum 29 characters.";
    }
    if (is_alpha($_POST['lastname'] == false)) {
      $errors[] = "Last name should contain only alphabets.";
      # code...
    }

    if(name_length($_POST['lastname']) ==false){
       $errors[] = "Lastname should contain Minimum 3 and Maximum 29 characters";
    }

    if(valid_username($_POST['uname']) ==false){
      $errors [] = "Username should contain alphanumeric and underscores characters";
    }else if(username_length($_POST['uname'])){
      $errors[] = "Username characters must be 5-15 long";
    }else if (username_exists($_POST['uname'])) {
    	$errors[] = "Username is already in use";
    }

    if(valid_password($_POST['pword']) ==false){
      $errors[] ="Password must include a uppercase,lowercase,number and a special character";
    }else if(password_length($_POST['pword']) ==false){
      $errors[] = "Password should contain Minimum 5 and Maximum 25 characters";
    }

    if(confirm_password($_POST['pword'],$_POST['cpword']) ==false){
      $errors[] = "Passwords did not match.";
    }
    if(valid_email($_POST['mail']) == false){
      $errors [] = "Invalid email address.";
    } 
    if(check_age($_POST['year'],$_POST['month'],$_POST['day']) ==false){
    	$errors[] = "Minimum 18 years age is required.";
    }

  }//end of empty errors block

 }//end of if empty post block

if(empty($_POST) ===false && empty($errors) == true){
		        	// if no errors then register user
  	$date = set_date($_POST['year'],$_POST['month'],$_POST['day']);
   	$form_value = array(
       	'title'=>$_POST['Title'],'firstname'=>$_POST['firstname'],
       	'lastname'=>$_POST['lastname'],'username'=>$_POST['uname'],
       	'password'=>$_POST['pword'],'birthdate'=>$date,'mail'=>$_POST['mail']);
   	$user = new User();
	$user->login_authenticate();
    if($user->signup($form_value)){
	 	$_SESSION['submit_page'] = true;
	 	header('location:submit.php');
	   	 }
	   }else{
		     //display errors
		    $display_errors = true;
		}
}
    	
?>
<!doctype html>
<html>
	<head>
		<meta charset = "UTF - 8">
		<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
		<meta name="description" content="">
    	<meta name="author" content="">  
   		<title>Bhatmas | Signup</title>
    		<!-- Bootstrap core CSS -->
	    <link href="../css/bootstrap.min.css" rel="stylesheet">
	    <!-- Custom styles for this template -->
	    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	    <link rel="stylesheet" type="text/css" href="../css/index.css">	
	    <script src="../js/jquery.js"></script>   
	    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
	    <script src="../js/additional.js"></script>
	  	<script type="text/javascript">
			
		   $(document).ready(function() {
    		$("#form1").validate({	  
				//setting up the rules for validation	  
				rules: {
					firstname: {required:true, nowhitespace:true,lettersonly:true,rangelength:[3,30]},
				    mail: {required: true,email: true},
				    lastname: {required: true,nowhitespace:true,lettersonly:true,rangelength:[3,30]},
				    uname: {required: true,rangelength:[6,15],alphanumeric : true, nowhitespace:true},						
					pword:{required: true,pwchecklowercase: true,pwcheckuppercase: true,pwchecknumber: true,pwcheckconsecchars: true,pwcheckspechars: true,
				           pwcheckallowedchars: true,minlength: 5,maxlength: 25},
					cpword:{required:true,equalTo:"#pword"},
					month:{required:true},day:{required:true},year:{required:true},title:{required:true},mail:{required:true}},
						
					//setting up custom messages
						
				 messages: {       
					firstname:{ required: "Please enter your first name",rangelength:"The name should be between 3 and 30 characters long."},
				    lastname:{required:"Please enter your last name",rangelength:"The name should be between 3 and 30 characters long."},
					uname:{required:"Enter username"},pword:{required:"Enter password"},cpword:{required:"Re-enter your password to confirm"},
					month:{required:"Month required"},day:{required:"Day required"},year:{required:"Year required"},title:{required:"Choose a Title"},
					mail:{required:"Enter your email address"}		  
				        }
				      });
				    });
				</script>	
	</head>
	<BODY>
		<?php include'../header.php'; ?>	
		<!-- registration form -->		
		 <div class="container">
		 	<div class = "main">
      		<div class="page-header">
        		<h1 style="color:#21610B;">Signup Form</h1>
      		</div>
      		<?php
      		if($display_errors){
      			echo output_errors($errors);
      		}
      		?>	
			<form  class="form-horizontal" name = "signupform"id ="form1" method ="POST" action ="signup.php" >
				<div class="form-group">
		      	<label for="title" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Title</label>
		      	<div class="col-sm-2">
		      		<SELECT name="Title">
		        		<OPTION value ="<?php echo isset($_POST['Title']) ? $_POST['Title'] : '' ?>"><?php echo isset($_POST['Title']) ? $_POST['Title'] : 'Title' ?></OPTION>
		        		<OPTION value="Mr">Mr</OPTION>
		        		<OPTION value="Miss">Miss</OPTION>
		        		<option value ="Mrs">Mrs</option>
						<option value ="Mrs">Ms</option>
		      		</SELECT>
		      	</div>
		      	<div class="col-sm-7"></div>
	      	 </div>
   			<div class="form-group">
		      	<label for="firstname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">First name</label>
		      	<div class="col-sm-3">
		      		<input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name"value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>">
		      		<div id = "feedback"></div>
		      	</div>
		      	<div class="col-sm-6"></div>
	     	</div>
		<div class="form-group">
		      	<label for="lastname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Last name</label>
		      	<div class="col-sm-3">
		      		<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last name"value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>">
		      	</div> 
		      	<div class="col-sm-6"></div>     	
	     	</div>
				<div class="form-group">
		      	<label for="uname" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Username</label>
		      	<div class="col-sm-3">
		      		<input type="text" name="uname" class="form-control" placeholder="Username"value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : '' ?>">      		
		      	</div>
		      	<div class="col-sm-6"></div>     	
	      	</div>

		    <div class="form-group">
		      	<label for="password" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Password</label>
		      	<div class="col-sm-3">
		      		<input type ="password" id ="pword" name="pword" class="form-control" placeholder="Password">      		
		      	</div> 
		      	<div class="col-sm-6"></div>    	
	      	</div>
			<div class="form-group">
		      	<label for="cpword" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Confirm Password</label>
		      	<div class="col-sm-3">
		      		<input type ="password" id ="cpword"name = "cpword" class="form-control" placeholder="Confirm Password">      		
		      	</div>
		      	<div class="col-sm-6"></div>     	
      		</div>
			<div class="form-group">
      		<label for="month" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;">Birthday</label>
      		<div class="col-sm-6" >
			<select name="month">
			<option value ="<?php echo isset($_POST['month']) ? $_POST['month'] : '' ?>"><?php echo isset($_POST['month']) ? $_POST['month'] : 'Month' ?></option><option value="01">January</option><option value="02">Febuary</option><option value="03">March</option><option value="04">April</option>
			<option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option>
			<option value="10">October</option><option value="11">November</option><option value="12">December</option>
		</select>
		<select name="day">
			<option value="<?php echo isset($_POST['day']) ? $_POST['day'] : '' ?>"><?php echo isset($_POST['day']) ? $_POST['day'] : 'Day' ?></option>
			<?php
			for($i = 1; $i<=31;$i++){
				?>
				<OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
				<?php
			}
			?>
		</select>

		<select name="year"><option value ="<?php echo isset($_POST['year']) ? $_POST['year'] : '' ?>"><?php echo isset($_POST['year']) ? $_POST['year'] : 'Year' ?></option>
			<?php
			for($i = 2000; $i>=1945;$i--){
				?>
				<OPTION value = "<?php echo $i;?>"><?php echo $i;?></OPTION>
				<?php
			}
			?>
		</select>
		</div>
		</div>		
      	 <div class="form-group">
     		<label for="email" class="col-sm-3 control-label" style="font-weight:normal; font-size:18px;"> Email</label>
     		<div class="col-sm-3">
     		<input type = "email" name = "mail" class="form-control" placeholder="Email"value="<?php echo isset($_POST['mail']) ? $_POST['mail'] : '' ?>">
     		</div>
     		<div class="col-sm-6"></div>
     	</div>
     	<br>
		<div class="col-sm-3"></div>
	    <div class="col-sm-9">
	     	<input id="button" type="submit" name="formSubmit" value ="Submit" class="signup_btn">
	     <br><br>
	    </div>		    
	</form>
	<br><br><br><br>
	</div>	
	</div>	
	<footer class="footer">
      <div class="container">
        <?php include'../footer.html'; ?>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
		
	</BODY>
</html>
