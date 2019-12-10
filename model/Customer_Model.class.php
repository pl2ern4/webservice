<?php


class Customer_Model extends Model{
	public function __construct(){
		parent::__construct();
	}

	function createcustomerTable(){ 
		$sql = "CREATE TABLE customer (
		user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		id INT(6) NOT NULL,
		first_name VARCHAR(30) NOT NULL,
		last_name VARCHAR(30) NOT NULL,
		email VARCHAR(50),
		gender VARCHAR(20),
		ip_address VARCHAR(50),
		company VARCHAR(50),
		city VARCHAR(50),
		title VARCHAR(100),
		website VARCHAR(500)
		)";

		$dbresp = $this->db->exec($sql);
		if(!$dbresp){
			return false;
		}else{
			return true;
		}
	}
	function isTableExist(){
		$isDbExist = "select 1 from customer;";
		$dbresp = $this->db->exec($isDbExist);
		if(!$dbresp){
			return false;
		}
		return true;
	}
	function insertDataInTable(){
		$filepath='C:\xampp\htdocs\test\customers.csv'; 
		if (($getdata = fopen($filepath, "r")) !== FALSE) { 
					   fgetcsv($getdata);   
				   while (($data = fgetcsv($getdata)) !== FALSE) {
							$fieldCount = count($data);
							for ($c=0; $c < $fieldCount; $c++) {
							  $columnData[$c] = $data[$c];
							}
					 $id = $this->db->escapeString($columnData[0]);
					 $first_name = $this->db->escapeString($columnData[1]);
					 $last_name = $this->db->escapeString($columnData[2]);
					 $email = $this->db->escapeString($columnData[3]);
					 $gender = $this->db->escapeString($columnData[4]);
					 $ip_address = $this->db->escapeString($columnData[5]);
					 $company = $this->db->escapeString($columnData[6]);
					 $city = $this->db->escapeString($columnData[7]);
					 $title = $this->db->escapeString($columnData[8]);
					 $website = $this->db->escapeString($columnData[9]);
					 $import_data[] ='("'.$id.'","'.$first_name.'","'.$last_name.'","'.$email.'","'.$gender.'","'.$ip_address.'","'.$company.'","'.$city.'","'.$title.'","'.$website.'")'; 
					// SQL Query to insert data into DataBase
					 
			}
			$import_data = implode(',', $import_data);
			$query ="INSERT INTO customer (id,first_name,last_name,email,gender,ip_address,company,city,title,website) VALUES ".$import_data.";";
			if ($this->db->exec($query)) {
			    // echo "data inserted successfully";
			    return true;
			} else {
			    return false;
			}
 		fclose($getdata);
	}
	return false;
	}
	function getRowCount(){
		$query = "select COUNT(1) as count from customer";
		$result = $this->db->exec($query);
		if(!$result){
			return null;
		}
		return mysqli_fetch_array($result)[0];
	}

	public function getCustomer($params){
		$page = ($params['page']!==null && $params['page']!=="") ? trim($params['page']): 1;
		$limit = $params['limit'] ? trim($params['limit']):10;

		
		$limit = $limit && $limit<50 ? $limit : 20;
		$array = ["data"=>[],"pages"=>0,"code"=>0];
		$rows = [];
		$data_retrive = "";
		
		$totalRows = $this->getRowCount();
		if(!$totalRows)
		{
			$this->appendHeaderWithResult($array);
		}
		$pages = ceil($totalRows/$limit); 
		$offset = ($page - 1) * $limit;
		
		$sql = "select * from customer order by user_id LIMIT $offset, $limit;"; 
		$result = $this->db->exec($sql); 
		if(!$result)
		{
			$this->appendHeaderWithResult($array);
		}
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		$array = ["data"=>$data,"pages"=>$pages,"code"=>1,"count"=>$totalRows];
		
		$this->appendHeaderWithResult($array);
	}

	public function InsertCustomerDetail()
	{
		if(!$this->isTableExist()){  
			$this->createcustomerTable();
			if($this->insertDataInTable())
			{
				$res = array('result'=>'data inserted','code'=>1);
				$this->appendHeaderWithResult($res);
			}
			else{
				$res = array('result'=>'data not inserted',code=>0);
				$this->appendHeaderWithResult($res);
			}
		}else{
			$res = array('result'=>'data inserted','code'=>1);
			$this->appendHeaderWithResult($res);
		}
	}
	function appendHeaderWithResult($result){
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		echo json_encode($result);
		die;
	}
}
?>