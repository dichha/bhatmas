<?php if(!isset($_SESSION)){ session_start(); }  require_once 'cnct.php';

class Paypal extends DB{

	public $txn_id;
	public $sender_id; //seller id

	public function __construct(){
		parent::__construct();
	}

	public function txn_id_exists($id){

		//function to check if transaction id for primary receiver has not been previously processed
		$txn = mysqli_real_escape_string($this->dbconn,$id);
		$stmt = mysqli_prepare($this->dbconn, "SELECT * FROM paypal_transaction Where txn_0_id = ? ");
		$stmt->bind_param('s',$txn);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows>0){
			return true;
		}else{
			return false;
		}
		$stmt->close();
	} // end of function check txn id

	public function get_txn_id($paykey){

		$key = mysqli_real_escape_string($this->dbconn,$paykey);

		$stmt1 = mysqli_prepare($this->dbconn,"SELECT txn_0_id_sender FROM paypal_transaction WHERE pay_key = ?");
		$stmt1->bind_param('s',$key);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($id);
		if($stmt1->num_rows == 1){
			while ($stmt1->fetch()) {
				$this->txn_id = $id;
			}
		}
		return $this->txn_id;
		$stmt1->close();
	} //end of function get txn id

	public function verify_primary_receiver($email){

		//function to verify receiver email is genuine bhatmas's paypal email

		if(strcmp($email, "prksh123@gmail.com") == 0){
			return true;
		}else{
			return false;
		}
	} // function to verify email

	public function insert_payment($key,$senderid,$receiver_0_amount,$receiver_1_email,$receiver_1_amount,$receiver_2_email,$receiver_2_amount){

		//function to insert paykey and total amount

		$key1 = mysqli_real_escape_string($this->dbconn,$key);
		$key3 = mysqli_real_escape_string($this->dbconn,$receiver_1_email);
		$key5 = mysqli_real_escape_string($this->dbconn,$receiver_2_email);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt2 = mysqli_prepare($this->dbconn,"INSERT INTO paypal_payment(pay_key,sender_id,receiver_0_amount,receiver_1_amount,receiver_1_email,receiver_2_amount,receiver_2_email)
			 VALUES (?,?,?,?,?,?,?)");
			$stmt2->bind_param('siddsds',$key1,$senderid,$receiver_0_amount,$receiver_1_amount,$key3,$receiver_2_amount,$key5);
			$stmt2->execute();
			if($stmt2->affected_rows ==1){
				mysqli_commit($this->dbconn);
			}else{
				throw new Exception($mysqli_error($this->dbconn), 1);				
			}
			
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
			echo $e;			
		}
		$stmt2->close();
	} //end of function

	public function verify_amount($paykey,$amount,$amount1,$amount2){

		$b = (str_replace("GBP", "", $amount));
		$c= (float)$b;
		$b1 = (str_replace("GBP", "", $amount1));
		$c1= (float)$b1;
		$b2 = (str_replace("GBP", "", $amount2));
		$c2= (float)$b2;
		$key = mysqli_real_escape_string($this->dbconn,$paykey);

		$stmt3 = mysqli_prepare($this->dbconn,"SELECT receiver_0_amount,receiver_1_amount,receiver_2_amount FROM paypal_payment WHERE pay_key = ?");
		$stmt3->bind_param('s',$key);
		$stmt3->execute();
		$stmt3->store_result();
		$stmt3->bind_result($r1,$r2,$r3);
		if($stmt3->num_rows == 1){
			while($stmt3->fetch()){
				if(($r1 == $c) && ($r2 == $c1) &&($r3 == $c2) ){
					return true;
				}else{
					return false;
				}
			}

		}else{
			return false;
		}
		$stmt3->close();

	}// end of function to verify amount 

	public function insert_ipn($paykey,
		$txn_id,$txn_id_sender,$txn_receiver,$transaction_amount,$txn_status,
		$txn_1id,$txn_1id_sender,$txn_1receiver,$transaction_1amount,$txn_1status,
		$txn_2id,$txn_2id_sender,$txn_2receiver,$transaction_2amount,$txn_2status){

		$paykey = mysqli_real_escape_string($this->dbconn,$paykey);
		$txn_id_0 = mysqli_real_escape_string($this->dbconn,$txn_id);
		$txn_id_0_sender = mysqli_real_escape_string($this->dbconn,$txn_id_sender);
		$txn_id_1_sender = mysqli_real_escape_string($this->dbconn,$txn_1id_sender);
		$txn_id_2_sender = mysqli_real_escape_string($this->dbconn,$txn_2id_sender);
		$txn_receiver_0 = mysqli_real_escape_string($this->dbconn,$txn_receiver);
		$txn_amount_0 = mysqli_real_escape_string($this->dbconn,$transaction_amount);
		$txn_status_0 = mysqli_real_escape_string($this->dbconn,$txn_status);
		$txn_id_1 = mysqli_real_escape_string($this->dbconn,$txn_1id);
		$txn_receiver_1 = mysqli_real_escape_string($this->dbconn,$txn_1receiver);
		$txn_amount_1 = mysqli_real_escape_string($this->dbconn,$transaction_1amount);
		$txn_status_1 = mysqli_real_escape_string($this->dbconn,$txn_1status);
		$txn_id_2 = mysqli_real_escape_string($this->dbconn,$txn_2id);
		$txn_receiver_2 = mysqli_real_escape_string($this->dbconn,$txn_2receiver);
		$txn_amount_2 = mysqli_real_escape_string($this->dbconn,$transaction_2amount);
		$txn_status_2 = mysqli_real_escape_string($this->dbconn,$txn_2status);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt4 = mysqli_prepare($this->dbconn,"INSERT INTO paypal_transaction
					(pay_key,
					txn_0_id,txn_0_amount,txn_0_receiver,txn_0_status,
					txn_1_id,txn_1_amount,txn_1_receiver,txn_1_status,
					txn_2_id,txn_2_amount,txn_2_receiver,txn_2_status,
					txn_0_id_sender,txn_1_id_sender,txn_2_id_sender) 
					VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt4->bind_param('ssssssssssssssss',$paykey,
				$txn_id_0,$txn_amount_0,$txn_receiver_0,$txn_status_0,
				$txn_id_1,$txn_amount_1,$txn_receiver_1,$txn_status_1,
				$txn_id_2,$txn_amount_2,$txn_receiver_2,$txn_status_2,
				$txn_id_0_sender,$txn_id_1_sender,$txn_id_2_sender);
			$stmt4->execute();
			if($stmt4->affected_rows == 1){
				mysqli_commit($this->dbconn);
			}else{
				$error = mysqli_error($this->dbconn);
				throw new Exception($error, 1);				
			}
			
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
			
		}//end of try catch 
		$stmt4->close();
	} //end of insert ipn details function

	public function verify_receiver($paykey,$receiver1, $receiver2){

		$key =mysqli_real_escape_string($this->dbconn,$paykey); 

		$stmt5 = mysqli_prepare($this->dbconn,"SELECT receiver_1_email,receiver_2_email FROM paypal_payment WHERE pay_key = ?");
		$stmt5->bind_param('s',$key);
		$stmt5->execute();
		$stmt5->store_result();
		$stmt5->bind_result($r1,$r2);
		if($stmt5->num_rows>0){
			while($stmt5->fetch()){
				if(strcmp($r1, $receiver1) == 0 ){
					if(strcmp($r2, $receiver2) == 0){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}
		$stmt5->close();
	} //end of verify receiver emails function

	public function get_senderID($paykey){

		$key = mysqli_real_escape_string($this->dbconn,$paykey);
		$stmt6 = mysqli_prepare($this->dbconn,"SELECT sender_id FROM paypal_payment Where pay_key = ?");
		$stmt6->bind_param('s',$key);
		$stmt6->execute();
		$stmt6->store_result();
		$stmt6->bind_result($id);
		if($stmt6->num_rows>0){
			while ($stmt6->fetch()) {
				$this->sender_id = $id;
				return $this->sender_id;
			}
		}
		$stmt6->close();
	}//end of get sender id function

	function paykey_exists($key){
		$paykey = mysqli_real_escape_string($this->dbconn,$key);
		$stmt7 = mysqli_prepare($this->dbconn,"SELECT * FROM paypal_transaction WHERE pay_key = ?");
		$stmt7->bind_param('s',$paykey);
		$stmt7->execute();
		$stmt7->store_result();
		if($stmt7->num_rows==1){
			return true;
		}else{
			return false;
		}
		$stmt7->close();

	}//check if key exists
}
?>