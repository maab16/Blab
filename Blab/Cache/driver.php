<?php

namespace Blab\Cache;
use Blab\Libs\Core as Core;
use Blab\Cache\Exception as Exception;

class Driver extends Core
{
	public function initialize(){

		return $this;
	}

	protected function _getExceptionForImplementation($method){

		return new Exception\Implementation("{$method} method not implemented");
		
	}
}