<?php

namespace Blab\Mvc\Router;

use Blab\Libs\Inspector as Inspector;
use Blab\Libs\StringMethods as StringMethods;

abstract class RouteAbstract
{
	protected $_pattern;

	protected $_controller;

	protected $_action;

	protected $_params= array();

	public function __construct($options=array()){

		$this->_inspector = new Inspector($this);

		if(count($options)){

			if (is_array($options) || is_object($options)) {
				
				foreach ($options as $name => $value) {
					
					$propertyName 	= ucfirst(trim($name,"_"));
					$methodName		= "set{$propertyName}";
					$this->$methodName($value);
				}
			}
		}
	}

	public function __call($name , $params=array()){

		if (empty($this->_inspector)) {
            
            throw new Exception("Call Parent::__construct");
        }

        $methodName = strtolower($name);

        $methodType = (strpos($methodName,"get")!==false && strpos($methodName,"get")==0) ? "get" 
        			  : ((strpos($methodName,"set")!==false && strpos($methodName,"set")==0) ? "set" : null);
        switch ($methodType) {
        	case 'get':
        		// Match Pattern and return Property Name from Method Name
            
	            $getMaches = StringMethods::match($methodName,"^get([a-zA-Z]+)$");

	            //Check getMatches array  element number greater than 0 . You can count array element using sizeof(arrayName) function
	            if (count($getMaches)>0){
	                
	                $normalized     = lcfirst($getMaches[0]);
	                
	                //Check Given  Property exists in this class if false return null

	                $propertyName = (property_exists($this, $normalized)) ? $normalized 
	                                : (property_exists($this, "_{$normalized}") ? "_{$normalized}" : null );

	                // If property is Private Then no access and raise Exception
	                if ($this->_inspector->isPropertyPrivate($propertyName)) {
	                    
	                    throw $this->_getExceptionForProperty($propertyName);
	                }
	                if (null !== $propertyName) {
	                    //Get Property Meta Data
	                    $propertyMeta = $this->_inspector->getPropertyMeta($propertyName);
	                    // Property Meta Data is empty if true raise exception otherwise return Property Data
	                    if (empty($propertyMeta["@read"]) && empty($propertyMeta["@readwrite"])) {

	                        throw $this->_getExceptionForWriteonly($propertyName);
	                    }

	                    if (isset($this->$propertyName)) {
	                        
	                        return $this->$propertyName;
	                    }

	                    return null;
	                }
	            }
        		break;

        	case 'set':
        		// Match Pattern and return Property Name from Method Name
	            $setMatches = StringMethods::match($methodName,"^set([a-zA-Z]+)$");
	            //Check setMatches array  element number greater than 0 . You can count array element using sizeof(arrayName) function
	            if (count($setMatches)>0) {
	                
	                $normalized     = lcfirst($setMatches[0]);
	                //Check Given  Property exists in this class if false return null
	                $propertyName = (property_exists($this, $normalized)) ? $normalized 
	                                : (property_exists($this, "_{$normalized}") ? "_{$normalized}" : null );
	                // If Property is Private Then No access is av ailable outside Class
	                if ($this->_inspector->isPropertyPrivate($propertyName)) {
	                    
	                    throw $this->_getExceptionForProperty($propertyName);
	                }
	                // If propertName is null then raise exception
	                if (is_null($propertyName)) {
	                    
	                    throw $this->_getExceptionForWriteonly($propertyName);
	                    
	                }
	                //Get Property Meta Data
	                $propertyMeta = $this->_inspector->getPropertyMeta($propertyName);
	                //print_r($propertyMeta);
	                // Property Meta Data is not empty then set value into property and return object otherwise raise exception
	                if (!empty($propertyMeta["@readwrite"])) {

	                    $this->$propertyName = $params[0];
	                    return $this;
	                }else{

	                    throw $this->_getExceptionForProperty($propertyName);
	                }
	            }
        		break;
        	
        	default:
        		throw $this->_getExceptionForImplementation($methodName);
        		break;
        }
	}

	abstract public function doSomeThing();
}