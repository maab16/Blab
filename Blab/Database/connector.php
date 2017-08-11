<?php

namespace Blab\Database;

use Blab\Libs\Core;
use Blab\Database\Exception;

class Connector extends Core
{
	public function initialize()
    {
        return $this;
    }
        
    protected function _getExceptionForImplementation($method)
    {
        return new Exception\Implementation("{$method} method not implemented");
    }	
}