<?php

namespace Blab\Libs;
class StringMethods
{
    private static $_delimiter = "#";
    
    private function __construct()
    {
        // do nothing
    }
    
    private function __clone()
    {
        // do nothing
    }
    
    private static function _normalize($pattern)
    {
        return self::$_delimiter.trim($pattern, self::$_delimiter).self::$_delimiter;
    }

    public function startWith($string,$search){

        if (empty($string) || empty($search)) {
            
            throw new \Exception("Invalid Argument");
        }

            //echo strpos($string, $search);
            return (strpos($string, $search)==0) ? true : false;
    }
    
    public static function getDelimiter()
    {
        return self::$_delimiter;
    }
    
    public static function setDelimiter($delimiter)
    {
        self::$_delimiter = $delimiter;
    }
    
    public static function match($string, $pattern)
    {
        preg_match_all(self::_normalize($pattern), $string, $matches, PREG_PATTERN_ORDER);
        
        if (!empty($matches[1]))
        {
            return $matches[1];
        }
        
        if (!empty($matches[0]))
        {
            return $matches[0];
        }
        
        return null;
    }
    
    public static function split($string, $pattern, $limit = null)
    {
        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
        return preg_split(self::_normalize($pattern), $string, $limit, $flags);
    }

    private static $_singular = array(
        "(matr)ices$" => "\\1ix",
        "(vert|ind)ices$" => "\\1ex",
        "^(ox)en" => "\\1",
        "(alias)es$" => "\\1",
        "([octop|vir])i$" => "\\1us",
        "(cris|ax|test)es$" => "\\1is",
        "(shoe)s$" => "\\1",
        "(o)es$" => "\\1",
        "(bus|campus)es$" => "\\1",
        "([m|l])ice$" => "\\1ouse",
        "(x|ch|ss|sh)es$" => "\\1",
        "(m)ovies$" => "\\1\\2ovie",
        "(s)eries$" => "\\1\\2eries",
        "([^aeiouy]|qu)ies$" => "\\1y",
        "([lr])ves$" => "\\1f",
        "(tive)s$" => "\\1",
        "(hive)s$" => "\\1",
        "([^f])ves$" => "\\1fe",
        "(^analy)ses$" => "\\1sis",
        "((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$" => "\\1\\2sis",
        "([ti])a$" => "\\1um",
        "(p)eople$" => "\\1\\2erson",
        "(m)en$" => "\\1an",
        "(s)tatuses$" => "\\1\\2tatus",
        "(c)hildren$" => "\\1\\2hild",
        "(n)ews$" => "\\1\\2ews",
        "([^u])s$" => "\\1"
    );
    
    private static $_plural = array(
        "^(ox)$" => "\\1\\2en",
        "([m|l])ouse$" => "\\1ice",
        "(matr|vert|ind)ix|ex$" => "\\1ices",
        "(x|ch|ss|sh)$" => "\\1es",
        "([^aeiouy]|qu)y$" => "\\1ies",
        "(hive)$" => "\\1s",
        "(?:([^f])fe|([lr])f)$" => "\\1\\2ves",
        "sis$" => "ses",
        "([ti])um$" => "\\1a",
        "(p)erson$" => "\\1eople",
        "(m)an$" => "\\1en",
        "(c)hild$" => "\\1hildren",
        "(buffal|tomat)o$" => "\\1\\2oes",
        "(bu|campu)s$" => "\\1\\2ses",
        "(alias|status|virus)" => "\\1es",
        "(octop)us$" => "\\1i",
        "(ax|cris|test)is$" => "\\1es",
        "s$" => "s",
        "$" => "s"
    );
    
    public static function singular($string)
    {
        $result = $string;
        
        foreach (self::$_singular as $rule => $replacement)
        {
            $rule = self::_normalize($rule);
        
            if (preg_match($rule, $string))
            {
                $result = preg_replace($rule, $replacement, $string);
                break;
            }
        }
        
        return $result;
    }
    
    function plural($string)
    {
        $result = $string;
        
        foreach (self::$_plural as $rule => $replacement)
        {
            $rule = self::_normalize($rule);
        
            if (preg_match($rule, $string))
            {
                $result = preg_replace($rule, $replacement, $string);
                break;
            }
        }
        
        return $result;
    }
}