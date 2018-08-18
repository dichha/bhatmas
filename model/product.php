<?php if(!isset($_SESSION)){     session_start(); }  require_once 'cnct.php';

class Product extends DB {

	private $productID;
	private $ownerID;
	public $productInfo = array(); //product detail
	public $sale_products = array(); //all the items
	public $rent_products = array(); //all the items
	public $my_sale_products = array(); //array of sale products
	public $my_rental_products = array(); //array of rental products
	public $errors = ""; //for debugging
	public $search_items = array(); //queried items

	public function __construct(){
		parent::__construct();
	}

 
	public function get_product($pID){ 
		 mysqli_begin_transaction($this->dbconn);
		 $this->productID = mysqli_real_escape_string($this->dbconn, $pID);
         $stmt = mysqli_prepare($this->dbconn, "SELECT product_name,renting_rate,selling_price,product_description,rental_max_duration,quantity,pic_loc,category,owner_id FROM product where product_ID = ?");
         $stmt->bind_param('s',$this->productID);
         $stmt->execute();
         $stmt->store_result();
         $stmt->bind_result($productName,$rentingRate,$sellingPrice,$productDescription,$rentalMaxDuration,$quantity,$image,$category,$ownerid);
         if($stmt->num_rows>0){

         	while ($stmt->fetch()) {

         		$this->productInfo = array(
         			'ProductName' => $productName,
         			'RentingRate'=>$rentingRate,
         			'SellingPrice'=>$sellingPrice,
         			'ProductDescription'=>$productDescription,
         			'RentalMaxDuration'=>$rentalMaxDuration,
         			'Quantity'=>$quantity,
         			'image'=>$image,
         			'category'=>$category         			
         		);
         	}

         }
		 $stmt->close();
		 $stmt1 = mysqli_prepare($this->dbconn,"SELECT username,Email FROM customer Where customer_ID = ?");
		 $stmt1->bind_param('i',$ownerid);
		 $stmt1->execute();
		 $stmt1->store_result();
		 $stmt1->bind_result($username,$email);
		 if($stmt1->num_rows>0){
		 	while ($stmt1->fetch()) {
		 		$var = array(
		 			'email' => $email,
		 			'seller'=>$username
		 			);

		 		array_push($this->productInfo, $var);
		 		# code...
		 	}
		 }
		 $stmt1->close();
		 return $this->productInfo;
	} //end of get product funciton

	public function insert_sale_product($productID,$name,$info,$image,$ownerID,$quantity,$price,$category){

		//inserting product in the database
		$name1 = mysqli_real_escape_string($this->dbconn, $name);
		$info1 = mysqli_real_escape_string($this->dbconn, $info);
		$image1 = mysqli_real_escape_string($this->dbconn, $image);
		$ownerID1 = mysqli_real_escape_string($this->dbconn, $ownerID);
		$quantity1 = mysqli_real_escape_string($this->dbconn, $quantity);
		$price1 = mysqli_real_escape_string($this->dbconn, $price);

		try {

			mysqli_begin_transaction($this->dbconn);		
			$stmt2 = mysqli_prepare($this->dbconn,"INSERT INTO product (product_ID,product_name,product_description,pic_loc,owner_id,quantity,selling_price,category) VALUES (?,?,?,?,?,?,?,?)");
			$stmt2->bind_param('ssssiids',$productID,$name1,$info1,$image1,$ownerID1,$quantity1,$price1,$category);
			$stmt2->execute();
			echo $stmt2->affected_rows;
;			if($stmt2->affected_rows == 1){

				mysqli_commit($this->dbconn);
				return true;
			}else{
				echo mysqli_error($this->dbconn);

				throw new Exception("Error Processing Request", 1);
				
			}
			
		} catch (Exception $e) {

			mysqli_rollback($this->dbconn);
			return false;			
		}
		$stmt2->close();

	}//end of insert sale product function

	public function insert_rent_product($productID,$name,$rate,$info,$image,$ownerID,$quantity,$maxduration,$category){

		//inserting rental product in the database
		$name1 = mysqli_real_escape_string($this->dbconn, $name);
		$info1 = mysqli_real_escape_string($this->dbconn, $info);
		$image1 = mysqli_real_escape_string($this->dbconn, $image);
		$ownerID1 = mysqli_real_escape_string($this->dbconn, $ownerID);
		$quantity1 = mysqli_real_escape_string($this->dbconn, $quantity);
		$rate1 = mysqli_real_escape_string($this->dbconn, $rate);
		$maxduration1 = mysqli_real_escape_string($this->dbconn, $maxduration);

		try {

			mysqli_begin_transaction($this->dbconn);

			$stmt3 = mysqli_prepare($this->dbconn,"INSERT INTO product (product_ID,product_name,renting_rate,product_description,rental_max_duration,pic_loc,owner_id,quantity,category) VALUES (?,?,?,?,?,?,?,?,?)");
			$stmt3->bind_param('ssdsisiis',$productID,$name1,$rate1,$info1,$maxduration1,$image1,$ownerID1,$quantity1,$category);
			$stmt3->execute();
			if($stmt3->affected_rows == 1){
				mysqli_commit($this->dbconn);
				return true;
			}else{

				throw new Exception("Error Processing Request", 1);
				
			}
			
		} catch (Exception $e) {

			mysqli_rollback($this->dbconn);
			return false;
			
		}
		$stmt3->close();
	}//end of insert rent function

	public function update_sell_product($pID, $productName,$sellingPrice,$productDescription,$quantity,$category){

		//updating sell_product
		$this->productID = $pID;
		$this->productID = mysqli_real_escape_string($this->dbconn, $this->productID);
		$productName1 =  mysqli_real_escape_string($this->dbconn, $productName);
		$sellingPrice1 =  mysqli_real_escape_string($this->dbconn, $sellingPrice);
		$productDescription1 =  mysqli_real_escape_string($this->dbconn, $productDescription);
		$quantity1 =  mysqli_real_escape_string($this->dbconn, $quantity);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt4 = mysqli_prepare($this->dbconn,"UPDATE product set product_name = ?,selling_price = ?, product_description = ?, quantity = ?,category = ? where product_ID = ?");
			$stmt4->bind_param('sdsiss',$productName1,$sellingPrice1,$productDescription1,$quantity1,$category,$this->productID);
			$stmt4->execute();
			if($stmt4->affected_rows == 1){

				mysqli_commit($this->dbconn);
				$stmt4->close();
				return true;

			}else{
				throw new Exception("Error Processing Request", 1);
				
			}
			
		} catch (Exception $e) {

			mysqli_rollback($this->dbconn);
			$stmt4->close();
			
		}
	}//end of update sale product

	public function update_rent_product($pID, $productName,$rentingRate,$productDescription,$quantity,$rentalMaxDuration,$category){

		//updating rent_product
		$this->productID = $pID;
		$this->productID = mysqli_real_escape_string($this->dbconn, $this->productID);
		$productName1 =  mysqli_real_escape_string($this->dbconn, $productName);
		$rentingRate1 =  mysqli_real_escape_string($this->dbconn, $rentingRate);
		$productDescription1 =  mysqli_real_escape_string($this->dbconn, $productDescription);
		$quantity1 =  mysqli_real_escape_string($this->dbconn, $quantity);
		$rentalMaxDuration1 =  mysqli_real_escape_string($this->dbconn, $rentalMaxDuration);

		try {

			mysqli_begin_transaction($this->dbconn);

			$stmt5 = mysqli_prepare($this->dbconn,"UPDATE product set product_name = ?, renting_rate = ?, product_description = ?, rental_max_duration = ?, quantity = ?, category = ? where product_ID = ?");
			$stmt5->bind_param('sdsiiss',$productName1,$rentingRate1,$productDescription1,$rentalMaxDuration1,$quantity1,$category,$this->productID);
			$stmt5->execute();
			if($stmt5->affected_rows == 1){

				mysqli_commit($this->dbconn);
				return true;
				$stmt5->close();

			}else{
				throw new Exception("Error Processing Request", 1);
				
			}
			
		} catch (Exception $e) {

			mysqli_rollback($this->dbconn);
			$stmt5->close();
			
		}


	}//end of update rent product function

	public function delete_product($pID){

		//deleting product from the database
		$this->productID = mysqli_real_escape_string($this->dbconn, $pID);

		try {
			mysqli_begin_transaction($this->dbconn);
			$stmt1 = mysqli_prepare($this->dbconn,"UPDATE product SET status = (0) WHERE product_ID = ?");
			$stmt1->bind_param('s',$this->productID);
			$stmt1->execute();
			if($stmt1->affected_rows == 1){
				mysqli_commit($this->dbconn);
				return true;
				$stmt1->close();

			}else{
				 
				throw new Exception("error", 1);
				
			}

			
		} catch (Exception $e) {

			mysqli_rollback($this->dbconn);
			return false;
			$stmt1->close();
			
		}

	}//end of delete product function

	public function view_all_sale_product($start_from, $itemperpage){

		$stmt6 = mysqli_prepare($this->dbconn,
			"SELECT `p`.`product_ID`,`p`.`product_name`,
			`p`.`product_description`,`p`.`selling_price`,
			`p`.`pic_loc`,`p`.`quantity`,`p`.`category`
			FROM `product` `p`
			INNER JOIN `customer` `c` 
			ON `c`.`customer_ID` = `p`.`owner_id` 
			WHERE `p`.`status` =(1) AND `c`.`account_status` =(1)
			AND `p`.`selling_price` > 0
			LIMIT $start_from, $itemperpage");
		$stmt6->execute();
		$stmt6->store_result();
		$stmt6->bind_result($itemID,$item_name,$item_info,
			$item_price,$item_pic,$item_quantity,$category);
		if($stmt6->num_rows>0){
			while($stmt6->fetch()){
				$this->sale_products[$itemID] = array(
					'ProductName' => $item_name,         		
         			'SellingPrice'=>$item_price,
         			'ProductDescription'=>$item_info,       
         			'Quantity'=>$item_quantity,
         			'image'=>$item_pic,
         			'category'=>$category
					);
			}

		}
		$stmt6->close();
		return $this->sale_products;
	}// end of view all sale_product

	function view_all_rent_product($start_from, $itemperpage){
		$stmt12 = mysqli_prepare($this->dbconn,
			"SELECT product_ID,product_name,product_description,
			pic_loc,quantity,renting_rate,rental_max_duration,
			category FROM product 
			WHERE status =(1) AND renting_rate >0 
			LIMIT $start_from, $itemperpage");
		$stmt12->execute();
		$stmt12->store_result();
		$stmt12->bind_result($itemID,$item_name,$item_info,$item_pic,$item_quantity,$item_rent_rate,$item_max_duration,$category);
		if($stmt12->num_rows>0){
			while($stmt12->fetch()){
				$this->rent_products[$itemID] = array(
					'ProductName' => $item_name,
         			'RentingRate'=>$item_rent_rate,
         			'ProductDescription'=>$item_info,
         			'RentalMaxDuration'=>$item_max_duration,
         			'Quantity'=>$item_quantity,
         			'image'=>$item_pic,
         			'category'=>$category
					);
			}

		}
		$stmt12->close();
		return $this->rent_products;


	}//end of view all rent product function

	public function view_my_sale_products($userid){

		$stmt7 = mysqli_prepare($this->dbconn,"SELECT product_id,product_name,product_description,selling_price,pic_loc,quantity,category FROM product WHERE owner_id = ? AND selling_price >0 AND status =(1)");
		$stmt7->bind_param('s',$userid);
		$stmt7->execute();
		$stmt7->store_result();
		$stmt7->bind_result($itemID,$item_name,$item_info,$item_price,$item_pic,$item_quantity,$category);
		if($stmt7->num_rows>0){

			while($stmt7->fetch()){

				$this->my_sale_products[$itemID] = array(
					'ProductName' => $item_name,
         			'SellingPrice'=>$item_price,
         			'ProductDescription'=>$item_info,
         			'Quantity'=>$item_quantity,
         			'image'=>$item_pic,
         			'category'=>$category
					);
			}

		}

		return $this->my_sale_products;

	}//end of view sale function

	public function view_my_rental_products($userid){

		$stmt7 = mysqli_prepare($this->dbconn,"SELECT product_id,product_name,product_description,renting_rate,rental_max_duration,pic_loc,quantity,category FROM product WHERE owner_id = ? AND renting_rate >0 AND status =(1)");
		$stmt7->bind_param('s',$userid);
		$stmt7->execute();
		$stmt7->store_result();
		$stmt7->bind_result($itemID,$item_name,$item_info,$item_rate,$item_rental_dur,$item_pic,$item_quantity,$category);
		if($stmt7->num_rows>0){

			while($stmt7->fetch()){

				$this->my_rental_products[$itemID] = array(
					'ProductName' => $item_name,
         			'RentingRate'=>$item_rate,
         			'RentDuration'=>$item_rental_dur,
         			'ProductDescription'=>$item_info,
         			'Quantity'=>$item_quantity,
         			'image'=>$item_pic,
         			'category'=>$category
					);
			}

		}

		return $this->my_rental_products;

	}//end of view rental function

	public function is_sale($id){

		$id = mysqli_real_escape_string($this->dbconn,$id);
		$stmt8 = mysqli_prepare($this->dbconn,"SELECT selling_price FROM product where product_ID = ? AND status = (1)");
		$stmt8->bind_param('s',$id);
		$stmt8->execute();
		$stmt8->store_result();
		$stmt8->bind_result($price);
		if($stmt8->num_rows >0){
			while ($stmt8->fetch()) {
				if($price>0){
					return true;
				}
				# code...
			}
		}
		$stmt8->close();

	}// end of is_sale function

		public function is_rental($id){

		$id = mysqli_real_escape_string($this->dbconn,$id);
		$stmt9 = mysqli_prepare($this->dbconn,"SELECT renting_rate FROM product where product_ID = ? AND status = (1)");
		$stmt9->bind_param('s',$id);
		$stmt9->execute();
		$stmt9->store_result();
		$stmt9->bind_result($rate);
		if($stmt9->num_rows >0){
			while ($stmt9->fetch()) {
				if($rate>0){
					return true;
				}
				# code...
			}
		}
		$stmt9->close();

	}// end of is_rental function

	function is_unique_id($id){

		//function checks id is already in use
		$stmt10 = mysqli_prepare($this->dbconn,"SELECT * FROM product WHERE product_ID = ?");
		$stmt10->bind_param('s',$id);
		$stmt10->execute();
		$stmt10->store_result();
		if($stmt10->num_rows>0){
			return false;
		}else{
			return true;
		}

	}//end of is unique functiuon	

	function update_image($pid,$targetfile){
		$productID = mysqli_real_escape_string($this->dbconn,$pid);
		$stmt11 = mysqli_prepare($this->dbconn,"UPDATE product SET pic_loc = ? WHERE product_ID = ? and status = (1)");
		$stmt11->bind_param('ss',$targetfile,$productID);
		$stmt11->execute();
		if($stmt11->affected_rows == 1){
			return true;
		}else{
			return false;
		}
	}//end of update_image

	function product_status($pid){
		$productID = mysqli_real_escape_string($this->dbconn,$pid);
		$stmt13 = mysqli_prepare($this->dbconn, "SELECT * FROM product where product_ID = ? AND status = (1) AND selling_price > 0");
		$stmt13->bind_param('s',$productID);
		$stmt13->execute();
		$stmt13->store_result();
		if($stmt13->num_rows>0){
			return "sale_item";
		}else{
			return "rent_item";
		}
		$stmt13->close();
	}//end of product_status function

		public function sale_category($category){

		$cat = mysqli_real_escape_string($this->dbconn,$category);
		$stmt6 = mysqli_prepare($this->dbconn,
			"SELECT `p`.`product_ID`,`p`.`product_name`,
			`p`.`product_description`,`p`.`selling_price`,
			`p`.`pic_loc`,`p`.`quantity`,`p`.`category`
			 FROM `product` `p`
			 INNER JOIN `customer` `c` 
			 ON `c`.`customer_ID` = `p`.`owner_id` 
			 WHERE `p`.`status` =(1) AND `c`.`account_status` =(1)
			 AND `p`.`selling_price` > 0 AND `p`.`category` = ?");
		$stmt6->bind_param('s',$cat);
		$stmt6->execute();
		$stmt6->store_result();
		$stmt6->bind_result($itemID,$item_name,$item_info,$item_price,$item_pic,$item_quantity,$category);
		if($stmt6->num_rows>0){
			while($stmt6->fetch()){
				$this->sale_products[$itemID] = array(
					'ProductName' => $item_name,         		
         			'SellingPrice'=>$item_price,
         			'ProductDescription'=>$item_info,       
         			'Quantity'=>$item_quantity,
         			'image'=>$item_pic,
         			'category'=>$category
					);
			}

		}
		$stmt6->close();
		return $this->sale_products;
	}// end of sale category function

	function rent_category($category){

		$cat = mysqli_real_escape_string($this->dbconn,$category);
		$stmt12 = mysqli_prepare($this->dbconn,"SELECT product_ID,product_name,product_description,pic_loc,quantity,renting_rate,rental_max_duration,category FROM product WHERE status =(1) AND renting_rate >0 AND category = ?");
		$stmt12->bind_param('s',$cat);
		$stmt12->execute();
		$stmt12->store_result();
		$stmt12->bind_result($itemID,$item_name,$item_info,$item_pic,$item_quantity,$item_rent_rate,$item_max_duration,$category);
		if($stmt12->num_rows>0){
			while($stmt12->fetch()){
				$this->rent_products[$itemID] = array(
					'ProductName' => $item_name,
         			'RentingRate'=>$item_rent_rate,
         			'ProductDescription'=>$item_info,
         			'RentalMaxDuration'=>$item_max_duration,
         			'Quantity'=>$item_quantity,
         			'image'=>$item_pic,
         			'category'=>$category
					);
			}

		}
		$stmt12->close();
		return $this->rent_products;


	}//end of view all rent product category function

	//index.php landing page search item function

	public function search_item($item,$category){

		$item1 = mysqli_real_escape_string($this->dbconn,$item);
		$category1 = mysqli_real_escape_string($this->dbconn,$category);

		if($category1 == "All Categories"){
			$stmt14 = mysqli_prepare($this->dbconn,"SELECT product_ID,product_name,renting_rate,selling_price,product_description,rental_max_duration,quantity,pic_loc,category FROM product where product_name LIKE CONCAT('%',?,'%')");
			$stmt14->bind_param('s',$item1);

		}else{
			$stmt14 = mysqli_prepare($this->dbconn,"SELECT product_ID,product_name,renting_rate,selling_price,product_description,rental_max_duration,quantity,pic_loc,category FROM product where product_name LIKE CONCAT('%',?,'%') AND category=?");
			$stmt14->bind_param('ss',$item1,$category1);
		}
		$stmt14->execute();
		$stmt14->store_result();
		$stmt14->bind_result($pID,$productName,$rentingRate,$sellingPrice,$productDescription,$rentalMaxDuration,$quantity,$image,$category);
		if($stmt14->num_rows>0){
			while($stmt14->fetch()){
				$this->search_items[$pID] = array(
         			'ProductName' => $productName,
         			'RentingRate'=>$rentingRate,
         			'SellingPrice'=>$sellingPrice,
         			'ProductDescription'=>$productDescription,
         			'RentalMaxDuration'=>$rentalMaxDuration,
         			'Quantity'=>$quantity,
         			'image'=>$image,
         			'category'=>$category
         		);

			}

		}
		return $this->search_items;
		$stmt14->close();

	}// end of search_item function
	public function sale_total_items(){

		$stmt15 = mysqli_prepare($this->dbconn,"SELECT * FROM product WHERE selling_price > 0 and status=(1)");
		$stmt15->execute();
		$stmt15->store_result();
		return $stmt15->num_rows;
		$stmt15->close();				

	}//end of  sale_total_items method

	public function rent_total_items(){
		$stmt16 = mysqli_prepare($this->dbconn, "SELECT * FROM product where renting_rate > 0 and status = (1)");
		$stmt16->execute();
		$stmt16->store_result();

		return $stmt16->num_rows;
		$stmt16->close(); 
	}


	public function rental_total_citems($category){
		$cat = mysqli_real_escape_string($this->dbconn, $category);
		$stmt17 = mysqli_prepare($this->dbconn, "SELECT * FROM product where renting_rate > 0 AND status = (1) AND category = ?");

		$stmt17->bind_param('s', $cat);
		$stmt17->execute();
		$stmt17->store_result();
		return $stmt17->num_rows;
		$stmt17->close();
	}
	public function sale_total_citems($category){
		$cat = mysqli_real_escape_string($this->dbconn, $category);
		$stmt18 = mysqli_prepare($this->dbconn, "SELECT * FROM product where selling_price > 0 AND status = (1) AND category = ?");
		$stmt18->bind_param('s', $cat);
		$stmt18->execute();
		$stmt18->store_result();
		return $stmt18->num_rows;
		$stmt18->close();
	}
	public function search_query_total_items($search, $category){
		$query = mysqli_real_escape_string($this->dbconn, $search);
		$cat = mysqli_real_escape_string($this->dbconn, $category);
	
		if ($cat == "All Categories"){
			$stmt19 = mysqli_prepare($this->dbconn,"SELECT * FROM product where product_name LIKE CONCAT('%', ?, '%') AND status = (1)");
			$stmt19->bind_param('s', $query);
		}else{
		$stmt19 = mysqli_prepare($this->dbconn, "SELECT * FROM product where product_name LIKE CONCAT('%', ?, '%') AND status = (1) AND category = ?");
		$stmt19->bind_param('ss', $query, $cat);
		}	
		
		$stmt19->execute();
		$stmt19->store_result();
		return $stmt19->num_rows;
		$stmt19->close();

	}

	public function valid_customer($userID,$productID){
		//ensure so that user can not buy one's self product and only a valid customer does

		$pid = mysqli_real_escape_string($this->dbconn,$productID);
		$userid = mysqli_real_escape_string($this->dbconn,$userID);
		//echo $userid;

		$stmt20 = mysqli_prepare($this->dbconn,"SELECT owner_id FROM product WHERE product_ID = ? ");
		$stmt20->bind_param('s',$pid);
		$stmt20->execute();
		$stmt20->store_result();
		$stmt20->bind_result($ownerid);
		if($stmt20->num_rows ==1){
			while ($stmt20->fetch()) {
			if($userid == $ownerid){			
				return false;
			}else{
				return true;
			}
		}
		}
		$stmt20->close();
	}

	public function valid_owner($product_id,$ownerid){
		
		$pid = mysqli_real_escape_string($this->dbconn,$product_id);
		$stmt17 = mysqli_prepare($this->dbconn,"SELECT * FROM product
			WHERE owner_id = ? AND product_ID = ?");
		$stmt17->bind_param('is',$ownerid,$pid);
		$stmt17->execute();
		$stmt17->store_result();
		if($stmt17->num_rows>0){
			echo "string";
			return true;
		}else{
			return false;
		}
		$stmt17->close();

	}

}
?>
