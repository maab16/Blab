<?php

namespace Blab\Libs;

use Blab\Libs\Core as Core;
use Blab\Config as Config;
use Blab\Config\Exception as Exception;

class Configuration extends Core
{
    /**
    *@readwrite
    */
    protected $_type;

    /**
    *@readwrite
    */
    protected $_options;

    protected function _getExceptionForImplementation($method)
    {
        return new Exception\Implementation("{$method} method not implemented");
    }

    public function initialize(){
        
        if (!$this->_type) {
            
            throw new Exception\Argument("Invalid Argument");
        }

        switch ($this->_type) {
            case 'ini':
                return new Config\Driver\Ini();

                break;
            
            default:
                throw new Exception\Argument("Invalid Type");
                break;
        }
    }
}