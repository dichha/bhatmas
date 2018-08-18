<?php
if(!isset($_SESSION)){
	session_start();
} 
date_default_timezone_set('Etc/UTC');
require_once 'cnct.php';
require_once 'cookie.php';
require dirname(__FILE__).'/PHPMailer/PHPMailerAutoload.php';

class User extends DB{
		public $Username; //get username
		private $Password; //get password
		public $login_message = array(); //holding login messages
		public $s_id;
		public $info = array(); //holding account info
		public $userID; //get user id
		public $address = array();

		public function __construct(){

			parent::__construct();
			$this->s_id = session_id();

			//when a new user object is instantiated, once cookie is set, informations about user like username can bre retrieved easily from database

			if(isset($_COOKIE['login'])){
				$name = mysqli_real_escape_string($this->dbconn,$_COOKIE['login']);
				$stmt2 = mysqli_prepare($this->dbconn, "SELECT login_username FROM customer_login where session_salt = ?");
				$stmt2->bind_param('s',$name);
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($name);

				if($stmt2->num_rows>0){
					while ($stmt2->fetch()) {

	                    $this->Username = $name;
	                    return $this->Username;
						# code...
					}
				}
					$stmt2->close();
				}

		}//end of constructor

		public function login_authenticate(){

			//login authentication

			if(!(isset($_COOKIE['login']))){
				return true;
			}else{
				header('location:account/user.php');
			}

		}

		public function authenticate(){

			//check if user is logged in

			parent::__construct();

			if(isset($_COOKIE['login'])){
				return true;
			}else{
				header('location:http://localhost/v8/login.php');
			}
		}

		public function login($username,$password){

			//logs in and sets cookie

			parent::__construct(); 

			$this->username = mysqli_real_escape_string($this->dbconn,$username);
			$this->Password = mysqli_real_escape_string($this->dbconn,$password);

			$stmt = mysqli_prepare($this->dbconn,"SELECT username,password FROM customer where username = ? AND account_status = (1)");
			$stmt->bind_param('s',$this->username);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($uName,$pWord);

				if($stmt->num_rows == 1){

					while($stmt->fetch()){

						if(password_verify("$this->Password",$pWord)){

							//password verified, set a cookie 

							//setting up a salt

							$salt = mt_rand(111111, 999999999);
							$hash = hash("sha256",$this->s_id.$salt);

							try{

								mysqli_begin_transaction($this->dbconn);

								$stmt1 = mysqli_prepare($this->dbconn,"INSERT INTO customer_login (session_salt, login_username) values (?,?)");
								$stmt1->bind_param('ss',$hash,$this->username);
								$stmt1->execute();
								if($stmt1->affected_rows == 1){

									//create a cookie
									 $cookie_name = "login";
                    				 $cookie_value= $hash;

                    				 $cookie = new Cookie();
                    				 if($cookie->set_cookie($cookie_name,$cookie_value)){

                    				 	mysqli_commit($this->dbconn);
                    				 	$stmt1->close();
                    				 }else{
                    				 	throw new Exception("Error creating cookie file", 1);
                    				 	
                    				 } 

								}else{
									throw new Exception("Error setting up cookie data", 1);
									
								}

							}catch(Exception $e){

								mysqli_rollback($this->dbconn);
								$stmt1->close();
							}

						}else{
							return $this->login_message = array("Your password is incorrect.");
						}

					}
					$stmt->close();


				}else{

					return $this->login_message = array("Incorrect Username.");
					$stmt->close();

				}	

		}

		public function logout(){

			//logging out
			parent::__construct();
			$cookie = new Cookie();
			$cookie_value = $cookie->get_cookie();
			if($cookie->delete_cookie($cookie_value)){
				return true;
			}

		}//end of logout function

		public function updatePassword($oldpassword,$newpassword){

			//updating password when user enters old and new passwords

			$oldpassword = mysqli_real_escape_string($this->dbconn,$oldpassword);
			$newpassword = mysqli_real_escape_string($this->dbconn,$newpassword);

			$stmt3 = mysqli_prepare($this->dbconn,"SELECT password from customer where username = ? ");
			$stmt3->bind_param('s',$this->Username);
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result($hashPassword);
			if($stmt3->num_rows>0){

				//get password and verify with entered old password

				while($stmt3->fetch()){

					if (password_verify("$oldpassword", $hashPassword)){
						
						//encrpt new password
			            $new_hash = password_hash("$newpassword", PASSWORD_BCRYPT,array(
			                  'cost'=>12
			                   ));

						//update password
						 try {
						 	mysqli_begin_transaction($this->dbconn);
						 	$stmt3->close();
						 	$stmt4 = mysqli_prepare($this->dbconn,"UPDATE customer set password = ? where username = ?");
						 	$stmt4->bind_param('ss',$new_hash,$this->Username);
						 	$stmt4->execute();
						 	if($stmt4->affected_rows == 1){
						 		mysqli_commit($this->dbconn);
						 		$stmt4->close();
						 		return true;
						 	}else{
						 		throw new Exception("Error Updating password", 1);
						 		
						 	}
						 	
						 } catch (Exception $e) {
						 	mysqli_rollback($this->dbconn);

						 	
						 }//end of try catch

					}else{
						//password did not match
						return false;
					}//end of password verify block
				}//end of while block


			}//end of if $stmt3 block

		}//end of update password function

		public function signup($info = array()){
			//function registering user
			$title = mysqli_real_escape_string($this->dbconn,$info['title']);
			$firstname = mysqli_real_escape_string($this->dbconn,$info['firstname']);
			$lastname = mysqli_real_escape_string($this->dbconn,$info['lastname']);
			$email = mysqli_real_escape_string($this->dbconn,$info['mail']);
			$password = mysqli_real_escape_string($this->dbconn,$info['password']);
			$passwordhash = password_hash("$password", PASSWORD_BCRYPT,array(
        		'cost'=>12
         		));
			$username = mysqli_real_escape_string($this->dbconn,$info['username']);
			$date = $info['birthdate']; 

			echo '<pre>'; 
			var_dump($info);
			echo '</pre>'; 

			$code1 = md5(uniqid(rand()));
			try {
				mysqli_begin_transaction($this->dbconn);
				$stmt5 = mysqli_prepare($this->dbconn,"INSERT INTO tmp_customer(first_name,last_name,username,password,dob,title,Email) VALUES (?,?,?,?,FROM_UNIXTIME(?),?,?)");
				echo '<pre>'; 
				var_dump($stmt5);
				echo '</pre>'; 
				if($stmt5){
					$stmt5->bind_param('sssssss',$firstname,$lastname,$username,$passwordhash,$date,$title,$email);
				}else{
					$error = mysqli_error($stmt5);
					echo $error; 
				}
				
				/*
				mysqli_begin_transaction($this->dbconn);
				$stmt5 = mysqli_prepare($this->dbconn,"INSERT INTO tmp_customer(first_name,last_name,username,password,dob,title,Email,token) VALUES (?,?,?,?,FROM_UNIXTIME(?),?,?,?)");
				$stmt5->bind_param('ssssssss',$firstname,$lastname,$username,$passwordhash,$date,$title,$email,$code1);
				*/

				$stmt5->execute();
				if($stmt5->affected_rows == 1){
					//send email
					$mail = new PHPMailer;
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
					$mail->addReplyTo('service@bhatmas.com', 'bhatmas.com');
					//Set who the message is to be sent to
					$mail->addAddress($email, $firstname);
					//Set the subject line
					$mail->Subject = 'Your Activation link';
					//Read an HTML message body from an external file, convert referenced images to embedded,
					//convert HTML into a basic plain-text alternative body
					$message.="Click on this link to activate your account \r\n";
					$message.="http://bhatmas.com/user_d1/beta/v4/registration/confirmation.php?passkey=$code1";
					$mail->Body = $message;
					if($mail->send()){
						mysqli_commit($this->dbconn);
						$stmt5->close();
						return true;
					}
				
				}else{
					throw new Exception(mysqli_error($this->dbconn), 1);
					
				}
				
			} catch (Exception $e) {
				mysqli_rollback($this->dbconn);
				$stmt5->close();
				
				
			}//end of try catch block
		}//end of signup function

		public function delete_account(){
			//deactivates account
               
              $stmt6 = mysqli_prepare($this->dbconn,"UPDATE customer set account_status = (0) WHERE username = ? ");
              $stmt6->bind_param('s',$this->Username);
              if($stmt6->execute()){
              	return true;
              }else{
              	return false;
              }
		}//  end of delete function 

		public function get_info(){
			//getting details about user

			$stmt7 = mysqli_prepare($this->dbconn,"SELECT first_name,last_name,dob,title,Email FROM customer where username = ?");
			$stmt7->bind_param('s',$this->Username);
			$stmt7->execute();
			$stmt7->store_result();
			$stmt7->bind_result($firstname,$lastname,$birthdate,$title,$email);
			if ($stmt7->num_rows==1) {
				while ($stmt7->fetch()) {
					$this->info = array(
						'firstname' =>$firstname,'lastname'=>$lastname,'birthdate'=>$birthdate,'title'=>$title,
						'email'=>$email
						);
				}
				
			}
			return $this->info; 
			$stmt7->close();
		} //end of get_info function

		function update_account($firstname,$lastname,$email){

			$firstname = mysqli_real_escape_string($this->dbconn,$firstname);
			$lastname = mysqli_real_escape_string($this->dbconn,$lastname);
			$email = mysqli_real_escape_string($this->dbconn,$email);

			$stmt8 = mysqli_prepare($this->dbconn,"UPDATE customer set first_name = ?, last_name = ?,Email = ? where username = ? ");
			$stmt8->bind_param('ssss',$firstname,$lastname,$email,$this->Username);
			$stmt8->execute();
			if($stmt8->affected_rows == 1){
				return true;
			}else{
				return false;
			}
			$stmt8->close();
		}

		function get_userid(){
			$stmt9 = mysqli_prepare($this->dbconn,"SELECT customer_ID FROM customer WHERE username = ?");
			$stmt9->bind_param('s',$this->Username);
			$stmt9->execute();
			$stmt9->store_result();
			$stmt9->bind_result($id);
			if($stmt9->num_rows>0){
				while ($stmt9->fetch()) {
					return $id;
				}

			}
			$stmt9->close();
		} //end of function get user id

		public function username_exists($username){

			//check if username is already in use
			$name = mysqli_real_escape_string($this->dbconn,$username);
			$stmt10 = mysqli_prepare($this->dbconn,"SELECT * FROM customer WHERE username =?");
			$stmt10->bind_param('s',$name);
			$stmt10->execute();
			$stmt10->store_result();
			if($stmt10->num_rows>0){
				return true;
				$stmt10->close();
				
			}else{
				$stmt10->close();
				$stmt11 = mysqli_prepare($this->dbconn,"SELECT * FROM tmp_customer WHERE username = ?");
				$stmt11->bind_param('s',$name);
				$stmt11->execute();
				$stmt11->store_result();
				if($stmt11->num_rows>0){
					return true;
				}else{
					return false;
				}
				$stmt11->close();
			}

		}//end of function username exists

		public function activate_account($token){
			$key = mysqli_real_escape_string($this->dbconn,$token);
			$info = array();
			try {
				  mysqli_begin_transaction($this->dbconn);
			      $stmt12 = mysqli_prepare($this->dbconn, "SELECT username,password,first_name,last_name,Email,dob,title from tmp_customer where token = ?");
			      $stmt12->bind_param('s',$key);
			      $stmt12->execute();
			      $stmt12->store_result();
			      $stmt12->bind_result($username,$password,$first_name,$last_name,$email,$dob,$title);
			      if($stmt12->num_rows==1){
			      	while($stmt12->fetch()){
			      		$info = array(
			      			'firstname'=>$first_name,'lastname'=>$last_name,
			      			'username'=>$username,'password'=>$password,
			      			'dob'=>$dob,'title'=>$title,
			      			'email'=>$email,
			      			);
			      		$stmt12->close();
			      		$stmt13=mysqli_prepare($this->dbconn,"INSERT INTO customer(first_name,last_name,username,password,dob,title,Email,account_status) VALUES (?,?,?,?,?,?,?,?)");
			      		$var = 1;
			      		$stmt13->bind_param('sssssssi',$info['firstname'],$info['lastname'],$info['username'],$info['password'],$info['dob'],$info['title'],$info['email'],$var);
			      		$stmt13->execute();
			      		if($stmt13->affected_rows ==1){
			      			$stmt13->close();
			      			//now delete tmp record
			      			$stmt14=mysqli_prepare($this->dbconn,"DELETE FROM tmp_customer WHERE token = ?");
			      			$stmt14->bind_param('s',$key);
			      			$stmt14->execute();
			      			if($stmt14->affected_rows == 1){
			      				mysqli_commit($this->dbconn);
			      				$stmt14->close();
			      				return true;

			      			}else{
			      				throw new Exception("Error Processing Request", 1);
			      				
			      			}

			      		}else{
			      			throw new Exception("Error Processing Request", 1);
			      			
			      		}

			      	}

			      }else{
			      	throw new Exception("Error Processing Request", 1);
			      }
				
			} catch (Exception $e) {
				mysqli_rollback($this->dbconn);
				return false;
			}
		}//end of function

		public function email_exists($email){

			//check if username is already in use
			$mail = mysqli_real_escape_string($this->dbconn,$email);
			$stmt10 = mysqli_prepare($this->dbconn,"SELECT * FROM customer WHERE Email =?");
			$stmt10->bind_param('s',$mail);
			$stmt10->execute();
			$stmt10->store_result();
			if($stmt10->num_rows>0){
				return true;
				$stmt10->close();
				
			}else{
				$stmt10->close();
				$stmt11 = mysqli_prepare($this->dbconn,"SELECT * FROM tmp_customer WHERE Email = ?");
				$stmt11->bind_param('s',$mail);
				$stmt11->execute();
				$stmt11->store_result();
				if($stmt11->num_rows>0){
					return true;
				}else{
					return false;
				}
				$stmt11->close();
			}

		}//end of function email exists

		public function set_return_address($sellerID, array $address ){

			//set return address for items
			$firstname = mysqli_real_escape_string($this->dbconn,$address['fname']);
			$lastname = mysqli_real_escape_string($this->dbconn,$address['lname']);			
			$postcode = mysqli_real_escape_string($this->dbconn,$address['pcode']);
			$town = mysqli_real_escape_string($this->dbconn,$address['town']);
			$street1 = mysqli_real_escape_string($this->dbconn,$address['street1']);
			$street2 = mysqli_real_escape_string($this->dbconn,$address['street2']);
			$userid = mysqli_real_escape_string($this->dbconn,$sellerID);

			try {
				mysqli_begin_transaction($this->dbconn);
				$stmt15 = mysqli_prepare($this->dbconn,"INSERT INTO ret_address
					(customerid,firstname,lastname,town,postcode,street1,street2) VALUES
					(?,?,?,?,?,?,?)");
				$stmt15->bind_param('issssss',$userid,$firstname,
					$lastname,$town,$postcode,
					$street1,$street2);
				$stmt15->execute();
				if($stmt15->affected_rows == 1){
					mysqli_commit($this->dbconn);
					return true;					
				}else{
					throw new Exception($this->dbconn->error, 1);					
				}
				
			} catch (Exception $e) {
				mysqli_rollback($this->dbconn);
				return false;
				
			}
			$stmt15->close();

		}//end of function

		public function get_return_address($customerid){
			
			$stmt16 = mysqli_prepare($this->dbconn,"SELECT firstname,lastname,
				town,postcode,street1,street2 FROM ret_address WHERE customerid = ?");
			echo $this->dbconn->error;
			$stmt16->bind_param('i',$customerid);
			$stmt16->execute();
			$stmt16->store_result();
			$stmt16->bind_result($firstname,$lastname,$town,$pcode,$street1,$street2);
			if($stmt16->num_rows == 1){
				while($stmt16->fetch()){
					$this->address = array(
					'fname'=>$firstname,
					'lname'=>$lastname,					
					'town'=>$town,
					'pcode'=>$pcode,
					'street1'=>$street1,
					'street2'=>$street2
					);
				}
				return $this->address;

			}else{

				return false;
			}
			$stmt16->close();
		}//end of function

		public function update_return_address($sellerid,array $address){

			$firstname = mysqli_real_escape_string($this->dbconn,$address['fname']);
			$lastname = mysqli_real_escape_string($this->dbconn,$address['lname']);
			$county = mysqli_real_escape_string($this->dbconn,$address['county']);
			$postcode = mysqli_real_escape_string($this->dbconn,$address['pcode']);
			$town = mysqli_real_escape_string($this->dbconn,$address['town']);
			$street1 = mysqli_real_escape_string($this->dbconn,$address['street1']);
			$street2 = mysqli_real_escape_string($this->dbconn,$address['street2']);
			$userid = mysqli_real_escape_string($this->dbconn,$sellerid);

			try {
				mysqli_begin_transaction($this->dbconn);
				$stmt17 = mysqli_prepare($this->dbconn,"UPDATE ret_address SET firstname = ?,
				lastname = ?,town = ?,postcode = ?,street1 = ?,street2 = ? WHERE customerid = ?");
				$stmt17->bind_param('ssssssi',$firstname,
					$lastname,$town,$postcode,$street1,$street2,$userid);
				$stmt17->execute();
				if($stmt17->affected_rows == 1){
					mysqli_commit($this->dbconn);					
					return true;
				}else{
					throw new Exception("Error Processing Request", 1);
					
				}
				
			} catch (Exception $e) {
				mysqli_rollback($this->dbconn);
				return false;
				
			}
			$stmt17->close();
		}//end of function

		public function get_username($id){

			$cstid = intval($id);
			$stmt18 = mysqli_prepare($this->dbconn,
				"SELECT username FROM customer WHERE customer_ID = ?
				");
			$stmt18->bind_param('i',$cstid);
			$stmt18->execute();
			$stmt18->store_result();
			$stmt18->bind_result($username);
			if($stmt18->num_rows == 1){
				while ($stmt18->fetch()) {
					return $username;
				}
			}
			$stmt18->close();
		}

}
?>