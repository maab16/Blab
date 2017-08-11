<?php

namespace Blab\Mvc\Controllers;

use Blab\Libs\Core as Core;
use Blab\Mvc\Bootstrap as Bootstrap;

class Blab_Controller extends Core
{

	/**
	 * @var 
	 * @readwrite
	 */
	protected $data;
	protected $model;
	protected $params;

	/**
	 * @return object
	 */
	public function getData(){

		return (object)$this->data;

		//return $this->data;
	}

	/**
	 * @return object
	 */
	public function getModel(){

		return $this->model;
	}
	
	/**
	 * @return string/numeric
	 */
	public function getParams(){

		return $this->params;
	}

	/**
	 * @param array $data
	 * @return void
	 */

	public function __construct($data = []){

		$this->data = $data;
		$this->params = Bootstrap::getRouter()->getParams();
	}

}