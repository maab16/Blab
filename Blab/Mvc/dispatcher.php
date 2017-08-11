<?php

namespace Blab\Mvc;

use Blab\Mvc\Controller as Controller;
use Blab\Events as Events;
use Blab\Libs\Registry as Registry;
use Blab\Libs\Inspector as Inspector;
use Blab\Mvc\Router\Exception as Exception;

class Dispatcher extends Router
{
	/**
	 *@readwrite
	 */

	protected $_routes = [];

	/**
	 * Parts url and call Controller and action
	 * @param no parameter
	 * @return void
	 */

	public function dispatch(){

		// Remove First and Last Directory Separator(/) From given $uri and Then Decoded special charecter such + charecter will decoded to a space charecter

		$url 		= urldecode(trim($this->_url,'/'));
		$default = Registry::get('default');
		// Set Default Data
		$this->_controller = $default->controller;
		$this->_action 	= $default->action;
		$this->_params = array();

		/** 
		 * Check Route . if route matched of the $url then set $controller,$action 
		 * and $parameters and call _pass method to create controller object
		 * and call $action method with parameters . 
		 * then stop working rest part of function using return statemnent
		 */

		if (!empty($this->_routes)) {
			
			foreach ($this->_routes as $route) {
				
				$matches = $route->matches($url);
				if ($matches) {
					
					$this->_controller = $route->_controller;
					$this->_action = $route->_action;
					$this->_params = $route->_params;

					return;
				}
			}
		}
		

		/**
		 * If Route doesn't matched with URL then parts URL.
		 * First part of URL must be Controller
		 * Second part of URL must be Action
		 * Rest parts of URL is set for parameters using array_slice() 
		 * Then call _pass method to create Controller Object 
		 * and call Action method with Parameters
		 */

		//Get path like /lang/controller/action/param1/param2/.../ as an array
		$pathParts = explode("/", $url);

		if (count($pathParts)) {

			// Get Controller - Next Element of array

			if (current($pathParts)) {
				
				 $controller = $this->_controller = strtolower(current($pathParts));

				// Remove the current element From the array element and set next element as current element

				array_shift($pathParts);
			}

			// Get Action - Next element of array

			if (current($pathParts)) {
				
				 $action = $this->_action = strtolower(current($pathParts));

				// Remove the current element From the array element and set next element as current element

				array_shift($pathParts);
			}

			// Params - next all element of array that rest

			$this->_params = $pathParts;
		}
	}
}