<?php

namespace Blab\Libs;

use Blab\Libs\Configuration;
use Blab\Mvc\Models\Blab_Model;

class defaultSettings
{
	public $_db;

	public function __construct(){

		$configuration = new Configuration(array(
					"type" => "ini"
				));
		$path = ROOT.DS.'App'.DS.'Config'.DS.'default';
		$configuration = $configuration->initialize();
		$parsed = $configuration->parse($path);
		Registry::set("default",$parsed->default);

		/*
			//Create Table from class property
			
			$this->_db = Blab_Model::getDBInstance();

			$user_table = new \App\Database\Models\User();

			$this->_db->createTable($user_table);
		*/
	}
}