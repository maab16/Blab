<?php

namespace Blab\Mvc\Router\Route;

use Blab\Mvc\Router as Router;

class Regex extends Router\Route
{
	/**
	*@readwrite
	*/
	protected $_keys;

	public function matches($url){

		$pattern = $this->pattern;

		// Check URL values

		preg_match_all("#^{$pattern}$#", $url, $values);

		if (sizeof($values) && sizeof($values[0]) && sizeof($values[1])) {
			
			// Values Found , modify parameters and return

			$derived = array_combine($this->keys, $values[1]);
			$this->parameters = array_merge($this->parameters,$derived);

			return true;
		}

		return false;
	}
}