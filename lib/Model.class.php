<?php

include "DB.class.php";
class Model
{
	public $connect;
	public function __construct()
	{	
		$this->db = new DB();
	}
}
?>