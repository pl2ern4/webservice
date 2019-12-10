<?php
class Customer extends Controller{
	public function __construct($params){
		parent::__construct($params);
	}
	public function getCustomer($params){
		return $this->model->getCustomer($params);
	}
	public function initData($params){ 
		return $this->model->InsertCustomerDetail($params);
	}
}