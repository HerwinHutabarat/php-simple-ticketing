<?php 

class Database {

	private $host = "127.0.0.1";
	private $port = "3306";
	private $dbname = "ticketing";
	private $user = "root";
	private $pass = "";
	public $conn;

	public function init() {
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);
		if ($this->conn->connect_errno) {
			echo "Failed to connect to MySQL (ticketing) : " . $this->conn->connect_error;
			exit();
		}
		return $this->conn;
	}
	
}  
