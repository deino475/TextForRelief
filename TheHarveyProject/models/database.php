<?php
include "../inc/config.php";

class Database {
	private $host = HOST;
	private $username = USERNAME;
	private $password = PASSWORD;
	private $database = DATABASE;

	private $connection = null;

	public function __construct(){
		$this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
	}

	public function select($query) {
		$res = mysqli_query($this->connection, $query);
		$data = array();
		while ($row = mysqli_fetch_assoc($res)) {
			array_push($data, $row);
		}
		return $data;
	}

	public function insert($query) {
		$res = mysqli_query($this->connection, $query);
		if ($res) {
			return true;
		} 
		return false;
	}

	public function update($query) {
		$res = mysqli_query($this->connection, $query);
		if ($res) {
			return true;
		} 
		return false;
	}

	public function delete($query) {
		$res = mysqli_query($this->connection, $query);
		if ($res) {
			return true;
		} 
		return false;
	}

	public function get_connection() {
		return mysqli_connect($this->host, $this->username, $this->password, $this->database);
	}
}