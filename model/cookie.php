<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

require_once 'cnct.php';

class Cookie extends DB{

	public $cookieName;
	public $cookieValue;

	public function set_cookie($name,$value){

		$this->cookieName = $name;
		$this->cookieValue = $value;

		setcookie("$this->cookieName", "$this->cookieValue", time() + (86400 * 30), "/"); // 86400 = 1 day
		return true;

	}//end of set cookie

	public function get_cookie(){

		//getting cookie value
		
		$this->cookieValue = $_COOKIE['login'];
		return $this->cookieValue;
	}

	public function delete_cookie($cookiename){

		// deleting cookie

		parent::__construct();

		//first removing from database
		$value = mysqli_real_escape_string($this->dbconn,$cookiename);

		$stmt = mysqli_prepare($this->dbconn,"DELETE from customer_login where session_salt = ?");
		$stmt->bind_param('s',$value);
		$stmt->execute();
		if($stmt->affected_rows == 1){

			unset($_COOKIE['login']);
            setcookie('login', '', time() - (86400 * 30), "/"); // 86400 = 1 day
            session_regenerate_id();
            session_destroy();

			return true;
		}else{
			return false;
		}		
		$stmt->close();

	}//end of delete cookie function



}
?>