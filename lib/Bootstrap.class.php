<?php
include 'config.php';
class Bootstrap{
	public function __construct($params)
	{ 
		$parameters = explode('/',$params['param']);

		$controller = FOLDER.'/controller/'.ucfirst($parameters[0]).'.php';
		
		if(!file_exists($controller))
		{
			$file = 'defined Controller';
			include FOLDER.'/view/error.html';
			exit;
		}
		include $controller;
		$controller_class = ucfirst($parameters[0]);
		if(!class_exists($controller_class)){

			$file = 'defined Controller class';
			include FOLDER.'/view/error.html';
			exit;
		}
		$obj = new $controller_class($controller_class);
		$newArr = array_splice($parameters, 2);
		$newArr = array_merge($parameters,$_GET,$_POST);
		if(!method_exists($controller_class,$parameters[1]))
		{
			$file = 'defined Method';
			include FOLDER.'/view/error.html';
			die;
		}
		$obj->{$parameters[1]}($newArr);

		exit(1);
	}
}
?>