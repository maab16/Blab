<?php

namespace Blab\Libs;    
    
class ArrayMethods
{
    private function __construct()
    {
        // do nothing
    }
    
    private function __clone()
    {
        // do nothing
    }
    
    public static function clean($array)
    {
        return array_filter($array, function($item) {
            return !empty($item);
        });
    }
    
    public static function trim($array)
    {
        return array_map(function($item) {
            return trim($item);
        }, $array);
    }

    // Create Object from array
    
    public static function toObject($array)
    {
        $result = new \stdClass();
        
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $result->{$key} = self::toObject($value);
            }
            else
            {
                $result->{$key} = $value;
            }
        }
        
        return $result;
    }

    // Convert Multidimentional array into unidimention array
    public static function flatten($array,$return=array())
    {
    
        foreach ($array as $key => $value) {
            
            if (is_array($value) || is_object($value)) {
                
                $return = self::flatten($value,$return);
            }else{

                $return[]=$value;
            }
        }

        return $return;
    }

    public static function first($array){

        if (!empty($array)) {
            
            $keys = array_keys($array);

            return $array[$keys[0]];
        }

        return null;
    }

    public static function last($array){

        if (!empty($array)) {
            
            $keys = array_keys($array);

            return $array[$keys[count($keys)-1]];
        }

        return null;
    }
    
}