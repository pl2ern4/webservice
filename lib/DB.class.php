<?php

class DB {
	private $connect;
	public function __construct(){
		$servername = "remotemysql.com:3306";
		$username = "uAJK8lQp5c";
		$password = "plC7KFlWQP";
		$dbname = "uAJK8lQp5c";
		$this->connect = new mysqli($servername, $username, $password, $dbname);
	}
	public function exec($query='',$debug=0){
		if($query){
			$exec = mysqli_query($this->connect, $query);
			if($debug==1)
			{
				echo "<pre>";
				print_r($exec);
			}
			if($exec)
			{
				return $exec;
			}
			else{
				if($debug==1)
				{
				 echo mysqli_error($this->connect);
				}
				return false; 
			}
		}
	}
	public function escapeString($string){
		return mysqli_real_escape_string($this->connect ,$string);
	}
}