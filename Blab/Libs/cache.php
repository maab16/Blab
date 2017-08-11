<?php

namespace Blab\Libs;

use Blab\Libs\Core as Core;
use Blab\Libs\Cache as Cache;
use Blab\Cache\Exception as Exception;

class Cache extends Core
{
	/**
	*@readwrite
	*/
	protected $_type;

	/**
	*@readwrite
	*/
	protected $_options;

	protected function _getExceptionForImplementation($method){

		return new Exception\Implementation("{$method} method not implemented");
		
	}

	public function initialize(){

		if (!$this->_type) {
			
			throw new Exception\Argument("Invalid Type");	
		}

		switch ($this->_type) {
			case 'memcached':
				return new Cache\Driver\Memcached($this->_options);
				break;
			
			default:
				throw new Exception\Argument("Invalid Type");
				break;
		}
	}
}