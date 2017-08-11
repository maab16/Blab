<?php

namespace Blab\Mvc\Router\Route;

use Blab\Mvc\Router as Router;
use Blab\Libs\ArrayMethods as ArrayMethods;

class Simple extends Router\Route
{

	public function matches($url){

		$pattern = $this->_pattern;

		//Search keys from pattern
		preg_match_all("#:([a-zA-Z0-9]+)#", $pattern, $keys);
		if (sizeof($keys) && sizeof($keys[0]) && sizeof($keys[1])) {
			
			$keys = $keys[1];
		}else{

			// No keys Found . Then simply return match

			return preg_match("#^{$pattern}$#", $url);
		}

		// normalized route pattern

		$pattern = preg_replace("#(:[a-zA-Z0-9]+)#", "([a-zA-Z0-9-_]+)", $pattern);

		// Check URL values and store matched values into $values

		preg_match_all("#^{$pattern}$#", $url, $values);

		if (sizeof($values) && sizeof($values[0]) && sizeof($values[1])) {
			
			// Unset the matched url
			unset($values[0]);

			// values found modify parameters and return 
			$derived = array_combine($keys, ArrayMethods::flatten($values));
			$this->_params = array_merge($this->_params,$derived);

			return true;
		}

		return false;
	}
}