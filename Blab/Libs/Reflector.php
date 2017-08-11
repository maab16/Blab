<?php

namespace Blab\Libs;

use Blab\Reflection\ClassInfo;
use Blab\Reflection\ClassPropertyInfo;
use Blab\Reflection\ClassMethodInfo;
use Blab\Libs\StringMethods;

class Reflector
{
	protected $class;

	protected $properties = array();

	protected $methods = array();

    protected $classComments = array();
    protected $propertyComments = array();
    protected $methodComments = array();

	public function __construct($class){

		$this->class = $class;
	}

	protected function _isPropertyPrivate($propertyName){

        $reflection = new ClassPropertyInfo($this->class,$propertyName);
        return $reflection->isPrivate();
    }

    protected function _isPropertyProtected($propertyName){

        $reflection = new ClassPropertyInfo($this->class,$propertyName);
        return $reflection->isProtected();
    }

    protected function _isPropertyPublic($propertyName){

        $reflection = new ClassPropertyInfo($this->class,$propertyName);
        return $reflection->isPublic();
    }
        
    protected function _getClassComment(){

        $reflection = new ClassInfo($this->class);
        return $reflection->getDocComment();
    }
        
    protected function _getClassProperties(){

        $reflection = new ClassInfo($this->class);
        return $reflection->getProperties();
    }
        
    protected function _getClassMethods(){

        $reflection = new ClassInfo($this->class);
        return $reflection->getMethods();
    }
        
    protected function _getPropertyComment($property){

        $reflection = new ClassPropertyInfo($this->class, $property);
        return $reflection->getDocComment();
    }
        
    protected function _getMethodComment($method){

            $reflection = new ClassMethodInfo($this->class, $method);
            return $reflection->getDocComment();
    }

    protected function _parseComment($comment){

		$meta = array();
        $pattern = "(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_]*)";
        $matches = StringMethods::match($comment, $pattern);
            
        if ($matches != null){

            foreach ($matches as $match){

                $parts = ArrayMethods::clean(
                    ArrayMethods::trim(
                        StringMethods::split($match, "[\s]", 2)
                    )
                );
                    
                $meta[$parts[0]] = true;
                    
                if (sizeof($parts) > 1){

                    $meta[$parts[0]] = ArrayMethods::clean(
                        ArrayMethods::trim(
                            StringMethods::split($parts[1], ",")
                        )
                    );
                }
            }
        }
            
        return $meta;
	}

	public function getClassShortName(){

		$reflection = new ClassInfo($this->class);
		return $reflection->getShortName();
	}

	public function getPropertyComment($property){

        $comment = $this->_getPropertyComment($property);
        if (!empty($comment)){

            $this->propertyComments[$property] = $this->_parseComment($comment);
            //print_r($meta["properties"][$property]);

            return $this->propertyComments[$property];
        }
	}

	public function isPropertyPrivate($propertyName){

            return $this->_isPropertyPrivate($propertyName);
        }

        public function isPropertyProtected($propertyName){

            return $this->_isPropertyProtected($propertyName);
        }

        public function isPropertyPublic($propertyName){

            return $this->_isPropertyPublic($propertyName);
        }
        
        public function getClassMeta()
        {
            if (!isset($this->_meta["class"]))
            {
                $comment = $this->_getClassComment();
                
                if (!empty($comment))
                {
                    $this->_meta["class"] = $this->_parseComment($comment);
                }
                else
                {
                    $this->_meta["class"] = null;
                }
            }
            
            return $this->_meta["class"];
        }
        
        public function getClassProperties()
        {
            
            if (empty($this->_properties))
            {
                $properties = $this->_getClassProperties();
                
                foreach ($properties as $property)
                {
                    $this->_properties[] = $property->getName();
                }
                
            }
            
            return $this->_properties;

        }
        
        public function getClassMethods()
        {
            if (empty($this->_methods))
            {
                $methods = $this->_getClassMethods();
                
                foreach ($methods as $method)
                {
                    $this->_methods[] = $method->getName();
                }
            }
            
            return $this->_properties;
        }
        
        public function getPropertyMeta($property)
        {
            if (!isset($this->_meta["properties"][$property]))
            {
                $comment = $this->_getPropertyComment($property);
                
                if (!empty($comment))
                {
                    $this->_meta["properties"][$property] = $this->_parseComment($comment);
                }
                else
                {
                    $this->_meta["properties"][$property] = null;
                }
            }
            
            return $this->_meta["properties"][$property];
        }
        
        public function getMethodMeta($method)
        {    
            if (!isset($_meta["actions"][$method]))
            {
                $comment = $this->_getMethodComment($method);
                
                if (!empty($comment))
                {
                    $_meta["methods"][$method] = $this->_parseComment($comment);
                }
                else
                {
                    $_meta["methods"][$method] = null;
                }
            }
            
            return $_meta["methods"][$method];
        }
}