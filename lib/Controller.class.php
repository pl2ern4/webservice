<?php

// Base Controller
class Controller{

    protected $model;
    public function __construct($params){
        $model = ucfirst($params)."_Model";
        $model_folder = FOLDER."/model/".$model.".class.php";
        if(!file_exists($model_folder))
		{
			$file = 'defined model';
			include FOLDER.'/view/error.html';
			exit;
		}
        include $model_folder;
        
    	$this->model = new $model; 
    }
}