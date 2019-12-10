<?php

require_once("lib/Bootstrap.class.php");
require_once("lib/Controller.class.php");
require_once("lib/Model.class.php");

$obj = new Bootstrap(array_merge($_GET,$_POST));
?>