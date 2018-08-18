<?php

class DB{

	protected $dbconn;

	public function __construct(){

		$this->dbconn = mysqli_connect('localhost', 'root', 'rootpass', 'bhatmas');
		#echo "connected successfully"; 
		return $this->dbconn;


	}

	public function __destruct(){
		$this->dbconn->close();
	}

}

?>