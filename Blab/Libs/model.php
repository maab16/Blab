<?php

namespace Blab\Libs;

use Blab\Libs\Core as Core;
use Blab\Libs\Registry as Registry;
use Blab\Libs\Reflector as Reflector;
use Blab\Libs\StringMethods as StringMethods;
use Blab\Mvc\Models\Exception as Exception;

class Model
{
	protected $_reflector;
	/**
	* @readwrite
	*/
	protected $_table;
	/**
	* @readwrite
	*/
	protected $_connector;
	/**
	* @read
	*/
	protected $_types = array(
				"autonumber",
				"varchar",
				"text",
				"int",
				"decimal",
				"boolean",
				"datetime"
			);
	protected $_columns;
	protected $_primary;

	public function __construct($options=array()){

		//Parent::__construct($options);
		$this->_reflector = new Reflector($this);

		// Check options array or object

        if (is_array($options) || is_object($options)) {
            
            foreach ($options as $key => $value) {
                
                $propertyName 	= ucfirst(ltrim($key,"_"));
                $methodName		= "set{$propertyName}";
                $this->$methodName($value);
            }
        }
	}

	public function _getExceptionForImplementation($method)
	{
		return new Exception\Implementation("{$method} method not implemented");
	}

	public function setConnector($value){

		$this->_connector = $value;
	}

	public function setTable($value){

		$this->_table = $value;
	}

	public function getTable()
	{
		if (empty($this->_table))
		{
			$className = $this->_reflector->getClassShortName();
			//$this->_table = strtolower(StringMethods::singular($className));
			$this->_table = strtolower($className);
		}

		return $this->_table;
	}

	public function getConnector()
	{
		if (empty($this->_connector))
		{
			$database = Registry::get("database");
			if (!$database)
			{
				throw new Exception\Connector("No connector availible");
			}
			$this->_connector = $database->initialize();
		}

		return $this->_connector;
	}

	public function getTypes(){

		return $this->_types;
	}

	public function getColumns()
	{
		if (empty($_columns))
		{
			$primaries = 0;
			$columns = array();
			$class = $this->_reflector->getClassShortName();
			$types = $this->getTypes();
			//$inspector = new Inspector($this);
			$properties = $this->_reflector->getClassProperties();
			//print_r($properties);
			$first = function($array, $key)
			{
				if (!empty($array[$key]) && sizeof($array[$key]) == 1)
				{
					return $array[$key][0];
				}

				return null;
			};

			foreach ($properties as $property)
			{
				//echo $property;
				
        		$propertyMeta = $this->_reflector->getPropertyComment($property);
				
				if (!empty($propertyMeta["@column"]))
				{
					if (StringMethods::startWith($property,"_")) {
						
						$name = preg_replace("#^_#", "", $property);
					}else{

						$name = $property;
					}
					
					$primary = !empty($propertyMeta["@primary"]);
					$type = $first($propertyMeta, "@type");
					$length = $first($propertyMeta, "@length");
					$default = $first($propertyMeta, "@default");
					$index = !empty($propertyMeta["@index"]);
					$readwrite = !empty($propertyMeta["@readwrite"]);
					$read = !empty($propertyMeta["@read"]) || $readwrite;
					$write = !empty($propertyMeta["@write"]) || $readwrite;
					$validate = !empty($propertyMeta["@validate"]) ? $propertyMeta["@validate"] : false;
					$label = $first($propertyMeta, "@label");

					if (!in_array($type, $types))
					{
						throw new Exception\Type("{$type} is not a valid type");
					}

					if ($primary)
					{
						$primaries++;
					}
					$columns[$name] = array(
						"raw" => $property,
						"name" => $name,
						"primary" => $primary,
						"type" => $type,
						"length" => $length,
						"default" => $default,
						"index" => $index,
						"read" => $read,
						"write" => $write,
						"validate" => $validate,
						"label" => $label
					);
				}
			}

			if ($primaries !== 1)
			{
				throw new Exception\Primary("{$class} must have exactly one @primary column");
			}

			$this->_columns = $columns;
		}

		return $this->_columns;
	}

	public function getColumn($name)
    {
        if (!empty($this->_columns[$name]))
        {
            return $this->_columns[$name];
        }
        return null;
    }
    
    public function getPrimaryColumn()
    {
        if (!isset($this->_primary))
        {
            $primary;
            
            foreach ($this->columns as $column)
            {
                if ($column["primary"])
                {
                    $primary = $column;
                    break;
                }
            }
            
            $this->_primary = $primary;
        }
        
        return $this->_primary;
    }
}