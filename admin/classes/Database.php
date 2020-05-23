<?php

/**
 * 
 */
class Database
{
	
	private $conn;
	public function connect(){
		$this->conn = new Mysqli("localhost", "root", "", "store_db");
		return $this->conn;
	}
}

?>