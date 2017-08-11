<?php

namespace Blab\Config\Driver;

use Blab\Config as Configuration;
use Blab\Libs\ArrayMethods as ArrayMethods;
use Blab\Config\Exception as Exception;

class Ini extends Configuration\Driver
{

	protected function _pair($config,$key,$value){
		// Check is exists dot(.) notatiom
		if (strstr($key,".")) {
			//slice before first dot notation and store $parts[0]
			$parts = explode(".", $key,2);

			if (empty($config[$parts[0]])) {
					
				$config[$parts[0]] = array();
			}
			// If still dot in $parts[1] then call _pair() recursively(again call _pair() function)
			$config[$parts[0]] = $this->_pair($config[$parts[0]],$parts[1],$value);
		}else{

			$config[$key] = $value;
		}

		return $config;
	}

	public function parse($path){

		if (empty($path)) {
			
			throw new Exception\Argument("\$path Argument is not Valid");
		}

		if (!isset($this->_parsed[$path])) {
			
			$config = array();
			// Strat output buffering that means STOP output Display
			ob_start();
			if(!file_exists($path.".ini")){
				
				throw new \Exception("file not fount in path ".$path);
			}
			include($path.".ini");
			$content = ob_get_contents();// Get all buffering contents
			ob_end_clean();// Stop output Buffering

			$results = parse_ini_string($content);//Get file content Data . Data must be String

			if (false == $results) {
				
				throw new Exception\Syntax("Could Not parse Configuration file");
			}

			foreach ($results as $key => $value) {
				
				$config = $this->_pair($config,$key,$value);
			}
			//Convert Data Array To Object
			$this->_parsed[$path] = ArrayMethods::toObject($config);
		}
		return $this->_parsed[$path];
	}

	
}