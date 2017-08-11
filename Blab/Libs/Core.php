<?php

namespace Blab\Libs;
use Blab\Libs\Inspector as Inspector;
use Blab\Libs\StringMethods as StringMethods;
use Blab\Libs\ArrayMethods as ArrayMethods;
use Blab\core\exception as exception;

class Core
{
    /**
     * Store inspector object for getting properties and methods Meta Data
     *@var object
     */

    private $_inspactor;

    /**
     * Call Magic Method __set() and Set properties Data .
     * @param array  
     */

    public function __construct($options=array()){

        // Instantiat Inspector Class for getting Properties Meta Data

        $this->_inspactor = new Inspector($this);

        // Check options array or object

        if (is_array($options) || is_object($options)) {
            
            foreach ($options as $key => $value) {
                
                $propertyName = ucfirst(ltrim($key,"_"));
                $this->$propertyName=$value;
            }
        }
    }

    /**
     * If undefined Method is Called Then Megic Method __call() automatically worked 
     * Create Magic Method __call() for getters/setters
     * @param String $name
     * @param array  $options
     */

    public function __call($name , $options){


        if (empty($this->_inspactor)) {
            
            throw new Exception("Call Parent::__construct");
        }

        // Convert getters and setters Method Name into smaller case

        $methodName = $name;

        // Check exists get keyword in getter Method 

        if (strpos($methodName,"get")!==false && strpos($methodName,"get")==0) {

            // Match Pattern and return Property Name from Method Name
            
            $getMaches = StringMethods::match($methodName,"^get([a-zA-Z]+)$");

            //Check getMatches array  element number greater than 0 . You can count array element using sizeof(arrayName) function
            if (count($getMaches)>0){
                
                $normalized     = lcfirst($getMaches[0]);
                
                //Check Given  Property exists in this class if false return null

                $propertyName = (property_exists($this, $normalized)) ? $normalized 
                                : (property_exists($this, "_{$normalized}") ? "_{$normalized}" : null );

                // If property is Private Then no access and raise Exception
                if ($this->_inspactor->isPropertyPrivate($propertyName)) {
                    
                    throw $this->_getExceptionForProperty($propertyName);
                }
                if (null !== $propertyName) {
                    //Get Property Meta Data
                    $propertyMeta = $this->_inspactor->getPropertyMeta($propertyName);
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

            // Check exists set keyword in setter Method 

        }elseif(strpos($methodName,"set")!==false && strpos($methodName,"set")==0){
            // Match Pattern and return Property Name from Method Name
            $setMatches = StringMethods::match($methodName,"^set([a-zA-Z]+)$");
            //Check setMatches array  element number greater than 0 . You can count array element using sizeof(arrayName) function
            if (count($setMatches)>0) {
                
                $normalized     = lcfirst($setMatches[0]);
                //Check Given  Property exists in this class if false return null
                $propertyName = (property_exists($this, $normalized)) ? $normalized 
                                : (property_exists($this, "_{$normalized}") ? "_{$normalized}" : null );
                // If Property is Private Then No access is av ailable outside Class
                if ($this->_inspactor->isPropertyPrivate($propertyName)) {
                    
                    throw $this->_getExceptionForProperty($propertyName);
                }
                // If propertName is null then raise exception
                if (is_null($propertyName)) {
                    
                    throw $this->_getExceptionForWriteonly($propertyName);
                    
                }
                //Get Property Meta Data
                $propertyMeta = $this->_inspactor->getPropertyMeta($propertyName);
                //print_r($propertyMeta);
                // Property Meta Data is not empty then set value into property and return object otherwise raise exception
                if (!empty($propertyMeta["@read"]) || !empty($propertyMeta["@readwrite"])) {

                    $this->$propertyName = $options[0];
                    return $this;
                }else{

                    throw $this->_getExceptionForProperty($propertyName);
                }
            }
        }


        throw $this->_getExceptionForImplementation($methodName);
    }

    // Megtic Method __set() is used to convert request into setter

    public function __set($name , $value){
        // Upper Case First Charecter of property name
        $propertyName   = ucfirst(ltrim($name,"_"));
        //set setMethodName using set keyword before PropertyName
        $methodName     = "set{$propertyName}";
        // Call setter method . if setter method doesn't exists then go to request into __call() method and return property value
        return $this->$methodName($value);
    }

    // Megtic Method __get() is used to call getter method from request

    public function __get($name){
        // Upper Case First Charecter of property name
        $propertyName   = ucfirst(ltrim($name,"_"));
        //set getMethod Name using get keyword before Property Name
        $methodName     = "get{$propertyName}";
        // Call getter method . if getter method doesn't exists then go to request into __call() method and return property value
        
        return $this->$methodName();
    }

    protected function _getExceptionForReadonly($property){

        return new Exception\ReadOnly("{$property} is read-only");
    }

    protected function _getExceptionForWriteonly($property){

        return new Exception\WriteOnly("{$property} is write-only");
    }

    protected function _getExceptionForProperty(){

        return new Exception\Property("Invalid property");
    }

    protected function _getExceptionForImplementation($method){

        return new Exception\Argument("{$method} method not implemented");
    }
}