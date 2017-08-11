<?php
if (file_exists(ROOT.'/vendor/autoload.php')) {
	require_once ROOT.'/vendor/autoload.php';
}else{
	throw new \Exception("Error Processing Request", 1);
	
}
