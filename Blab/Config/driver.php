<?php

namespace Blab\Config;

use Blab\Libs\Core as Core;
use Blab\Config\Exception as Exception;

class Driver extends Core
{
	protected $_parsed = array();

	public function initialize(){

		return $this;
	}

	protected function _getExceptionForImplementation($method){

		return new Exception\Implementation("{$method} method not implemented");
	}
}