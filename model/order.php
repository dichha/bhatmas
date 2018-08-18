<?php if(!isset($_SESSION)){ session_start(); }  require_once 'cnct.php';
require_once 'product.php';

class Order extends DB{	

	public $my_orders = array();
	public $order_details = array();
	public $address = array();
	public $list_request = array();
	public $iteminfo = array();
	public $rental_items = array();
	public $rental_item = array();
	public $rented_items = array(); // lists of user items that are on rent

	public function __construct(){
		parent::__construct();
	}

	
	function generate_ord_number($length = 10) {
		//genereate random string for customer order
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	function ord_number_unique($number){

		$number = mysqli_real_escape_string($this->dbconn,$number);

		$stmt7 = mysqli_prepare($this->dbconn,"SELECT * FROM cst_order WHERE order_no = ?");
		$stmt7->bind_param('s',$number);
		$stmt7->execute();
		$stmt7->store_result();
		if($stmt7->num_rows>0){
			return false;
		}else{
			return true;
		}
		$stmt7->close();
	}

	function insert_cst_order($orderNumber,$senderid,$txn_0_id_sender,$paykey){

		$orderNumber = mysqli_real_escape_string($this->dbconn,$orderNumber);
		$txn_0_id_sender = mysqli_real_escape_string($this->dbconn,$txn_0_id_sender);
		$paykey = mysqli_real_escape_string($this->dbconn,$paykey);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt = mysqli_prepare($this->dbconn,"INSERT INTO cst_order(order_no,sender_id,txn_id,paykey) VALUES(?,?,?,?)");
			$stmt->bind_param('siss',$orderNumber,$senderid,$txn_0_id_sender,$paykey);
			$stmt->execute();
			if($stmt->affected_rows == 1){
				mysqli_commit($this->dbconn);
			}else{
				throw new Exception("Error Processing Request", 1);
			}
			
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
			
		}//end of try catch
		$stmt->close();

	}//end of function insert customer order

	public function insert_shipping_address($orderNumber,$name,$street1,$street2,$city,$state,$zip,$country,$phone){

		$orderNumber = mysqli_real_escape_string($this->dbconn,$orderNumber);
		$name = mysqli_real_escape_string($this->dbconn,$name);
		$street1 = mysqli_real_escape_string($this->dbconn,$street1);
		$street2 = mysqli_real_escape_string($this->dbconn,$street2);
		$city = mysqli_real_escape_string($this->dbconn,$city);
		$state = mysqli_real_escape_string($this->dbconn,$state);
		$zip= mysqli_real_escape_string($this->dbconn,$zip);
		$country = mysqli_real_escape_string($this->dbconn,$country);
		$phone = mysqli_real_escape_string($this->dbconn,$phone);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt1 = mysqli_prepare($this->dbconn,"INSERT INTO order_shipping
			 (order_no,name,street_1,street_2,city,state,zip,country,phone)
			 VALUES
			 (?,?,?,?,?,?,?,?,?)");
			$stmt1->bind_param('sssssssss',$orderNumber,$name,$street1,$street2,
				$city,$state,$zip,$country,$phone);
			$stmt1->execute();
			if($stmt1->affected_rows == 1){
				mysqli_commit($this->dbconn);
			}else{
				throw new Exception("Error Processing Request", 1);
				
			}
			
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
			
		}//end of try catch 
		$stmt1->close();

	}//end of function shipping_address

	public function get_order_number($txn_0_id_sender){

		//returns customer order number
		$txn_id = mysqli_real_escape_string($this->dbconn,$txn_0_id_sender);
		$stmt2 = mysqli_prepare($this->dbconn,"SELECT order_no FROM cst_order WHERE txn_id = ?");
		$stmt2->bind_param('s',$txn_id);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($order_no);
		if($stmt2->num_rows>0){
			while ($stmt2->fetch()) {
				return $order_no;
			}
		}
		$stmt2->close();
	} //end of get_order_number

	public function insert_item_details($orderNumber,$itemid,$itemcount,$itemweek){

		//inserts order items
		$orderNumber = mysqli_real_escape_string($this->dbconn,$orderNumber);
		$productID = mysqli_real_escape_string($this->dbconn,$itemid);
		$productQuantity = mysqli_real_escape_string($this->dbconn,$itemcount);
		$productWeek = mysqli_real_escape_string($this->dbconn,$itemweek);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt3 = mysqli_prepare($this->dbconn,"INSERT INTO order_item(order_no,product_id,quantity,rental_week) VALUES
				(?,?,?,?)");
			$stmt3->bind_param('ssss',$orderNumber,$productID,$productQuantity,$productWeek);
			$stmt3->execute();
			if($stmt3->affected_rows == 1){
				mysqli_commit($this->dbconn);
			}else{
				throw new Exception("Error Processing Request", 1);
				
			}
			
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
		}
		$stmt3->close();
	}
	public function update_product_number($ordernumber,$pid,$number){

		try {
			mysqli_begin_transaction($this->dbconn);
			$p = new Product();
			$p->get_product($pid);

			if($p->productInfo['Quantity']-$number>=0){
				$var = $p->productInfo['Quantity']-$number;
				$stmt4 = mysqli_prepare($this->dbconn,"UPDATE product set quantity = ? WHERE product_ID =?");
				$stmt4->bind_param('is',$var,$pid);
				$stmt4->execute();
				if($stmt4->affected_rows == 1){
					$stmt4->close();
					$status = "Unshipped";
					$stmt5 = mysqli_prepare($this->dbconn,"UPDATE cst_order set status = ? WHERE order_no = ?");
					$stmt5->bind_param('ss',$status,$ordernumber);
					$stmt5->execute();
					if($stmt5->affected_rows == 1){
						mysqli_commit($this->dbconn);
						$stmt5->close();
					}else{
						throw new Exception("Error Processing Request", 1);
						
					}
				}else{
					throw new Exception("Error Processing Request", 1);
					
				}
			}else{
				//insert into database an error for now exception
				throw new Exception("Error Processing Request", 1);				
				
			}
			
		} catch (Exception $e) {

			mysqli_rollback($this->dbconn);
		}
	}//end of function update product number

	public function get_orders($userid){

		$id = mysqli_real_escape_string($this->dbconn,$userid);

		$stmt6 = mysqli_prepare($this->dbconn,"SELECT
		 	 no,order_no,order_date,status
			 FROM cst_order Where sender_id = ?");
		$stmt6->bind_param('i',$id);
		$stmt6->execute();
		$stmt6->store_result();
		$stmt6->bind_result($number,$orderNo,$ord_date,$status);
		if($stmt6->num_rows>0){
			while ($stmt6->fetch()) {
				$this->my_orders[] = array(
					'no' =>$number,
					'order_no' =>$orderNo,
					'ord_date'=>$ord_date,
					'status'=>$status					
					);
			}
		}
		return $this->my_orders;
		$stmt6->close();
	}	//end of function to get my orders

	public function view_order($id){

		//collects arrays of order details i.e items,prices,numbers etc
		// of a customer's specific order number

		$ref = mysqli_real_escape_string($this->dbconn,$id);		
		$stmt8 = mysqli_prepare($this->dbconn,"SELECT `i`.`status`,
			`p`.`product_name`,`i`.`quantity`,
			`i`.`rental_week`,`i`.`product_id`,
			`c`.`Email`,`p`.`pic_loc`, 
			`c`.`first_name`,`c`.`last_name`,`o`.`order_date`
			FROM `order_item` `i` 
			INNER JOIN `cst_order` `o` 
			ON `o`.`order_no` = `i`.`order_no` 
			INNER JOIN `customer` `c`
			ON `c`.`customer_ID` = `o`.`sender_id` 
			INNER JOIN `product` `p`
			ON `i`.`product_id` = `p`.`product_ID`
			WHERE `o`.`order_no` = ?");		
		echo $this->dbconn->error;
		$stmt8->bind_param('s',$ref);
		$stmt8->execute();
		$stmt8->store_result();
		$stmt8->bind_result($status,
			$product_name,$quantity,$week,$pid,$email,$image,
			$cst_f_name,$cst_l_name,$order_date);
		if($stmt8->num_rows>0){
			while ($stmt8->fetch()) {
				$this->order_details[] = array(
					'odr_status' =>$status,					
					'pdt_name'=>$product_name,
					'pdt_qty'=>$quantity,
					'pdt_week'=>$week,
					'pdt_id'=>$pid,
					'buyer_email' =>$email,
					'img'=>$image,
					'cst_f_name'=>$cst_f_name,
					'cst_l_name'=>$cst_l_name,
					'order_date'=>$order_date
					);
			}
			return $this->order_details;
		}
		$stmt8->close();

	}//end of function  view_order

	public function get_shipping_address($order_no){

		$stmt9 = mysqli_prepare($this->dbconn,"SELECT name, street_1,street_2,city,state,zip,country FROM order_shipping WHERE order_no =?");
		echo $this->dbconn->error;
		$stmt9->bind_param('s',$order_no);
		$stmt9->execute();
		$stmt9->store_result();
		$stmt9->bind_result($name,$stree1,$street2,$city,$state,$zip,$country);
		if($stmt9->num_rows>0){
			while ($stmt9->fetch()) {
				$this->address = array(
					'name'=>$name,
					'street1'=>$stree1,
					'street2'=>$street2,
					'city'=>$city,
					'state'=>$state,
					'zip'=>$zip,
					'country'=>$country
					);
			}
			return $this->address;
		}
		$stmt9->close();

	}//end of function get shipping address

	public function order_request($seller_id){

		//function to retrive requests of items from buyers

		$id = mysqli_real_escape_string($this->dbconn,$seller_id);

		$stmt9 = mysqli_prepare($this->dbconn,"SELECT `o`.`order_no`,
			`i`.`status`,`o`.`order_date`,`p`.`category`,
			`p`.`product_name`,`i`.`quantity`,`i`.`rental_week`,
			`s`.`name`,`s`.`street_1`,`s`.`street_2`,
			`s`.`city`,`s`.`state`,`s`.`zip`,`s`.`country`,
			`c`.`username`,`i`.`product_id`
			 FROM `cst_order` `o` INNER JOIN `order_item` `i`
			  ON `o`.`order_no` = `i`.`order_no` 
			  INNER JOIN `product` `p` ON
			   `i`.`product_id` = `p`.`product_ID`
			  INNER JOIN `customer` `c` ON
			   `c`.`customer_ID` = `o`.`sender_id`
			  INNER JOIN `order_shipping` `s` ON
			   `o`.`order_no` = `s`.`order_no`
			  WHERE `p`.`owner_id` = ? ");
		echo $this->dbconn->error;
		$stmt9->bind_param('i',$id);
		$stmt9->execute();
		$stmt9->store_result();
		$stmt9->bind_result($number,$status,$date,$category,
			$itemname,$quantity,$week,$name,$street1,$street2,
			$city,$state,$zip,$country,$username,$productid);
		if($stmt9->num_rows>0){
			while ($stmt9->fetch()) {
				$this->list_request[] = array(
					'order_no'=>$number,
					'category'=> $category,
					'status' => $status,
					'date'=>$date,
					'itemname'=>$itemname,
					'quantity'=> $quantity,
					'week'=>$week,
					'name'=>$name,
					'street1' =>$street1,
					'street2' =>$street2,
					'city' =>$city,
					'state'=>$state,
					'zip'=>$zip,'country'=>$country,
					'customer'=>$username,
					'productid'=>$productid
					);
			}
		}
		return $this->list_request;
		$stmt9->close();
	}

	function count_request($id){
		//returns number of unshipped requests

		$userid = mysqli_real_escape_string($this->dbconn,$id);
		$status = "Unshipped";
		$stmt10 = mysqli_prepare($this->dbconn,"SELECT `o`.`order_no`
			 FROM `cst_order` `o` INNER JOIN `order_item` `i`
			  ON `o`.`order_no` = `i`.`order_no` 
			  INNER JOIN `product` `p` ON `i`.`product_id` = `p`.`product_ID`			  
			  WHERE `p`.`owner_id` = ? AND `i`.`status` = ?");
		$stmt10->bind_param('ss',$userid,$status);
		$stmt10->execute();
		$stmt10->store_result();
		return $stmt10->num_rows;
		$stmt10->close();

	}//end of function count_request

	function shipped_item($orderno,$itemid){

		$o_no = mysqli_real_escape_string($this->dbconn,$orderno);
		$p_id = mysqli_real_escape_string($this->dbconn,$itemid);
		$dispatched_date = date("Y-m-d H:i:s"); 
		$return_date = "";
		$item = new Product();
		try {
			mysqli_begin_transaction($this->dbconn);

			//if item is rental, add return date

			if($item->is_rental($p_id)){
				$week = "";
				$pre = mysqli_prepare($this->dbconn,"SELECT rental_week FROM order_item WHERE order_no = ? AND product_id = ?");
				$pre->bind_param('ss',$o_no,$p_id);
				$pre->execute();
				$pre->store_result();
				$pre->bind_result($duration);
				if($pre->num_rows == 1){
					while ($pre->fetch()) {
						$week = $duration;
					}
				}else{
					throw new Exception($this->dbconn->error, 1);
					
				}
				$pre->close();
				$days = ($week *7) . " days";
				$return_date = date('Y-m-d H:i:s', strtotime($dispatched_date. " + $days"));
				$stmt11 = mysqli_prepare($this->dbconn,"UPDATE order_item SET status = 'Shipped', dispatched = ?, return_date=? WHERE order_no = ? AND product_id = ? ");
				$stmt11->bind_param('ssss',$dispatched_date,$return_date,$o_no,$p_id);

			}else{
				$stmt11 = mysqli_prepare($this->dbconn,"UPDATE order_item SET status = 'Shipped', dispatched = ? WHERE order_no = ? AND product_id = ? ");
				$stmt11->bind_param('sss',$dispatched_date,$o_no,$p_id);
			}
			$stmt11->execute();
			if($stmt11->affected_rows == 1){
				mysqli_commit($this->dbconn);
				return true;
				
			}else{				
				throw new Exception($this->dbconn->error, 1);
				
			}
			
			} catch (Exception $e) {
				mysqli_rollback($this->dbconn);
				echo $e;
				return false;
				
			}
			$stmt11->close();


	}//end of function shipped item
	
	function get_item_request($orderno,$productid){

		$o_no = mysqli_real_escape_string($this->dbconn,$orderno);
		$p_id = mysqli_real_escape_string($this->dbconn,$productid);

		$stmt12 = mysqli_prepare($this->dbconn,"SELECT quantity,rental_week FROM order_item WHERE order_no = ? AND product_id = ? ");
		$stmt12->bind_param('ss',$o_no,$p_id);
		$stmt12->execute();
		$stmt12->store_result();
		$stmt12->bind_result($quantity,$week);
		if($stmt12->num_rows == 1){
			while ($stmt12->fetch()) {
				$this->iteminfo = array(
					'quantity'=>$quantity,
					'week'=>$week
					);				
			}
		}
		return $this->iteminfo;
		$stmt12->close();
	}//end of function

	public function my_rental_items($userid){

		//function to retrive requests of rental items of user

		$id = mysqli_real_escape_string($this->dbconn,$userid);

		$stmt9 = mysqli_prepare($this->dbconn,"SELECT `o`.`order_no`,`i`.`status`,
			`o`.`order_date`,`p`.`category`,
			`p`.`product_name`,`i`.`quantity`,`i`.`rental_week`,			
			`c`.`username`,`i`.`dispatched`,`i`.`return_date`,`p`.`product_ID`,
			`c`.`Email`
			 FROM `cst_order` `o` INNER JOIN `order_item` `i`
			  ON `o`.`order_no` = `i`.`order_no` 
			  INNER JOIN `product` `p` ON `i`.`product_id` = `p`.`product_ID`
			  INNER JOIN `customer` `c` ON `c`.`customer_ID` = `p`.`owner_id`			  
			  WHERE `o`.`sender_id` = ? AND `i`.`rental_week` >0  ");
		echo $this->dbconn->error;
		$stmt9->bind_param('i',$id);
		$stmt9->execute();
		$stmt9->store_result();
		$stmt9->bind_result($number,$status,$date,$category,$itemname,
			$quantity,$week,$renter_username,$dispatched,$return_date,$productid,$renterEmail);
		if($stmt9->num_rows>0){
			while ($stmt9->fetch()) {
				$this->rental_items[] = array(
					'order_no'=>$number,
					'category'=> $category,
					'status' => $status,
					'date'=>$date,
					'itemname'=>$itemname,
					'quantity'=> $quantity,
					'week'=>$week,
					'renter'=>$renter_username,
					'dispatched'=>$dispatched,
					'return'=>$return_date,
					'pid'=>$productid,
					'renter_email'=>$renterEmail
					);
			}
		}
		return $this->rental_items;
		$stmt9->close();
	}//end of function

	public function view_rental_item($productid,$orderid){

		//function to view a rental item inforamtion
		$pid = mysqli_real_escape_string($this->dbconn,$productid);
		$oid = mysqli_real_escape_string($this->dbconn,$orderid);
		$stmt9 = mysqli_prepare($this->dbconn,"SELECT 
			`o`.`order_no`,`i`.`status`,
			`o`.`order_date`,`p`.`category`,`o`.`sender_id`,
			`p`.`product_name`,`i`.`quantity`,`i`.`rental_week`,			
			`c`.`username`,`i`.`dispatched`,`i`.`return_date`,`p`.`product_ID`,
			`c`.`Email`,`p`.`owner_id`,`p`.`pic_loc`
			 FROM `cst_order` `o` INNER JOIN `order_item` `i`
			  ON `o`.`order_no` = `i`.`order_no` 
			  INNER JOIN `product` `p` ON `i`.`product_id` = `p`.`product_ID`
			  INNER JOIN `customer` `c` ON `c`.`customer_ID` = `p`.`owner_id`			  
			  WHERE `i`.`product_id` = ? AND `o`.`order_no` =?");
		echo $this->dbconn->error;
		$stmt9->bind_param('ss',$pid,$oid);
		$stmt9->execute();
		$stmt9->store_result();
		$stmt9->bind_result($number,$status,$date,$category,
			$renteeid,$itemname,$quantity,$week,$renter_username,
			$dispatched,$return_date,$productid,$renterEmail,$renterid,$pic);
		if($stmt9->num_rows == 1){
			while ($stmt9->fetch()) {
				$this->rental_item = array(
					'o_no'=>$number,
					'category'=> $category,
					'status' => $status,
					'date'=>$date,
					'itemname'=>$itemname,
					'qty'=> $quantity,
					'week'=>$week,
					'renter'=>$renter_username,
					'dispatched'=>$dispatched,
					'return'=>$return_date,
					'pid'=>$productid,
					'renter'=>$renterid,
					'rentee'=>$renteeid,
					'pic'=>$pic
					);
			}
		}
		return $this->rental_item;
		$stmt9->close();

	}//end of function

	public function return_rent_item($orderid,$productid){

		$o_no = mysqli_real_escape_string($this->dbconn,$orderid);
		$p_id = mysqli_real_escape_string($this->dbconn,$productid);
		$return_date = date("Y-m-d H:i:s");

		try {
			mysqli_begin_transaction($this->dbconn);

			$stmt13 = mysqli_prepare($this->dbconn,"UPDATE order_item SET 
				cst_returned = ?, status = ('Returned') WHERE order_no = ? AND product_id = ?");
			$stmt13->bind_param('sss',$return_date,$o_no,$p_id);
			$stmt13->execute();
			if($stmt13->affected_rows == 1){
				mysqli_commit($this->dbconn);
				return true;
				
			}
			
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
			return false;
			
		}
		$stmt13->close();

	}

	public function get_buyer_email($customerid,$paykey){

		$id = mysqli_real_escape_string($this->dbconn,$customerid);
		$key = mysqli_real_escape_string($this->dbconn,$paykey);

		$stmt14 = mysqli_prepare($this->dbconn,"SELECT `c`.`Email`
			FROM `paypal_payment` `p` 			
			INNER JOIN `customer` `c` on `c`.`customer_ID` = `p`.`sender_id` 			
			 WHERE `p`.`sender_id` = ? AND `p`.`pay_key`= ?");
		echo $this->dbconn->error;
		$stmt14->bind_param('is',$id,$key);
		$stmt14->execute();
		$stmt14->store_result();
		$stmt14->bind_result($mail);
		if($stmt14->num_rows == 1){
			while($stmt14->fetch()){
				return $mail;
			}

		}else{
			return false;
		}
		$stmt14->close();

	}//end of function

	public function all_order_shipped($orderno){

		//checks if every items in the order is fully shipped
		$no = mysqli_real_escape_string($this->dbconn,$orderno);		
		$stmt15 = mysqli_prepare($this->dbconn,"SELECT *
		 FROM order_item WHERE status ='Unshipped' AND order_no =? ");
		$stmt15->bind_param('s',$order_no);
		$stmt15->execute();
		$stmt15->store_result();
		if($stmt15->num_row>0){
			return false;
		}else{
			return true;
		}
		$stmt15->close();
	}

	public function valid_order($reference,$cst_id){

		//function checks valid customer order to be briefed
		//retrieve customer id and match the parameter id
		// to verify the customer
		$id = mysqli_real_escape_string($this->dbconn,$reference);
		$cst = intval($cst_id);
		$stmt16 = mysqli_prepare($this->dbconn,
			"SELECT `c`.`customer_ID`
			 FROM `cst_order` `o`
			 INNER JOIN `customer` `c`
			 ON `c`.`customer_ID`=`o`.`sender_id`
			 WHERE `o`.`order_no` = ?");
		$stmt16->bind_param('s',$id);
		$stmt16->execute();
		$stmt16->store_result();
		$stmt16->bind_result($cstid);
		if($stmt16->num_rows==1){
			while ($stmt16->fetch()) {
				if($cstid ==$cst){
					return true;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
		$stmt16->close();
	}

	public function is_shipped($orderid){
		//check if every item in a order is shipped

		$id = mysqli_real_escape_string($this->dbconn,$orderid);
		$stmt17 = mysqli_prepare($this->dbconn,"SELECT * FROM order_item
			WHERE status = 'Unshipped' AND order_no = ?");
		$stmt17->bind_param('s',$id);
		$stmt17->execute();
		$stmt17->store_result();
		if($stmt17->num_row>0){
			return false;
		}else{
			return true;
		}
		$stmt17->close();
	}

	public function udt_ord_history($orderno){
		$id = mysqli_real_escape_string($this->dbconn,$orderno);
		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt18 = mysqli_prepare($this->dbconn,
				"UPDATE cst_order SET status = 'Shipped'
				 WHERE order_no = ?");
			$stmt18->bind_param('s',$id);
			$stmt18->execute();
			if($stmt18->affected_rows == 1){
				mysqli_commit($this->dbconn);
				$stmt18->close();
			}else{
				throw new Exception("Error Processing Request", 1);
				
			}
		} catch (Exception $e) {
			mysqli_rollback($this->dbconn);
		}

	}

	public function my_rented_items($userid){

		//function that contains array of lists
		//of user items on rent by customer
		$stmt19 = mysqli_prepare($this->dbconn,"SELECT
			`i`.`quantity`,`i`.`rental_week`,`i`.`product_id`,
			`i`.`order_no`,`p`.`pic_loc`,`o`.`order_date`,
			`i`.`return_date`,`i`.`status`
			FROM `order_item` `i` 
			INNER JOIN `cst_order` `o` 
			ON `o`.`order_no` = `i`.`order_no`
			INNER JOIN `product` `p` 
			ON `p`.`product_ID` = `i`.`product_id`  
			INNER JOIN `customer` `c`
			ON `c`.`customer_ID`=`p`.`owner_id`
			WHERE `i`.`rental_week`>0 AND `p`.`owner_id` = ?
		 ");
		$id = intval($userid);
		echo $this->dbconn->error;
		$stmt19->bind_param('i',$id);
		echo $this->dbconn->error;
		$stmt19->execute();
		$stmt19->store_result();
		$stmt19->bind_result($qty,$week,$pid,$o_no,$pic,$o_date,$r_date,$status);
		if($stmt19->affected_rows>0){
			while ($stmt19->fetch()) {
				$this->rented_items[]= array(
					'pid'=> $pid,
					'o_no'=> $o_no,
					'o_date'=>$o_date,
					'qty'=>$qty,
					'pic'=>$pic,
					'week'=>$week,
					'r_date'=>$r_date,
					'status'=>$status
					);
			}
			return $this->rented_items;
		}
		$stmt19->close();
	}

	function athz_rentee($ono,$pid,$userid){

		//function to authenticate valid user and their customer		
		$uid = intval($userid);
		$stmt20 = mysqli_prepare($this->dbconn,
			"SELECT *	FROM `order_item` `i` 
			INNER JOIN `cst_order` `o` 
			ON `o`.`order_no` = `i`.`order_no`
			INNER JOIN `product` `p` 
			ON `p`.`product_ID` = `i`.`product_id`  
			INNER JOIN `customer` `c`
			ON `c`.`customer_ID`=`p`.`owner_id`
			WHERE `p`.`owner_id` = ? AND `i`.`order_no`	=? AND `i`.`product_id` = ?
			 ");		
		$stmt20->bind_param('iss',$uid,$ono,$pid);
		$stmt20->execute();
		$stmt20->store_result();
		if($stmt20->num_rows == 1){
			return true;
		}else{
			return false;
		}
		$stmt20->close();

	}

	//list of functions
	/*
	count_request - counts number of unshipped order request for the seller
	order_request - retrieves detailed information about all the order requests for the seller 
	get_shipping_address - gets shipping address w.r.t order number
	*/

}
?>