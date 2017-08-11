<?php

namespace Blab\Libs;

use Blab\Libs\Core as Core;
use Blab\Database\Connector as Connector;
use Blab\Database\Exception as Exception;

class Database extends Core
{
	/**
	 * @readwrite
	 */

	protected $_type;

	/**
	 * @readwrite
	 */

	protected $_options;

	protected function _getExceptionForImplementation($method)
    {
        return new Exception\Implementation("{$method} method not implemented");
    }

	public function initialize(){

		if (!$this->type) {
			
			throw new Exception\Argument("Invalid Type");
		}

		switch ($this->type) {
			case 'mysql':
				
				return new Connector\Mysql($this->options);
				break;
			
			default:

				throw new Exception\Argument("Invalid Type");
				break;
		}
	}
}