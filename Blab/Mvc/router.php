<?php

namespace Blab\Mvc;

use Blab\Mvc\Router as Router;
use Blab\Mvc\Controller as Controller;
//use Blab\Events as Events;
use Blab\Libs\Registry as Registry;
use Blab\Libs\Inspector as Inspector;
use Blab\Mvc\Router\Exception as Exception;

class Router extends Router\Route implements Router\RouterInterface
{

	/**
	*@readwrite
	*/
	protected $_url;
	/**
	*@readwrite
	*/
	protected $_extension;
	/**
	*@read
	*/
	protected $_controller;
	/**
	*@read
	*/
	protected $_action;
	/**
	*@read
	*/
	protected $_params;

	protected $_routes = array();

	protected $route = "default";
	protected $method_prefix = "";
	protected $language = "en";

	public function getUrl(){

		return $this->_url;
	}

	public function getController(){

		return $this->_controller;
	}

	public function getAction(){

		return $this->_action;
	}

	public function getParams(){

		return $this->_params;
	}

	public function getRoute(){

		return $this->route;
	}

	public function getMethodPrefix(){

		return $this->method_prefix;
	}

	public function getLanguage(){

		return $this->language;
	}

	public function _getExceptionForImplementation($method){

		return new Exception\Implementation("{$method} method not implement");
	}

	public function __construct($options=array()){

		Parent::__construct($options);

		$this->dispatch();
	}
/*
	public function setUrl($value){

		$this->_url = $value;
	}
*/
	/**
	 * Set New Route
	 * @param 
	 * @return Object
	 */

	public function addRoute($route){

		$this->_routes[] = $route;
		return $this;
	}

	/**
	 * Remove Specific Route
	 * @param 
	 * @return object
	 */

	public function removeRoute($route){


		if (array_key_exists($key = array_search($route,$this->_routes), $this->_routes)) 
		{
				
			unset($this->_routes[$key]);
		}
	/*
		foreach ($this->_routes as $key => $value) {
			
			if ($value == $route) {
				
				unset($this->_routes[$key]);
			}
			
		}
	*/

		return $this;
	}

	/**
	 * Get All Available Routes
	 *
	 * @param no parameter
	 * @return array
	 */

	public function getRoutes(){

		$list = array();
		foreach ($this->_routes as $route) {

			// use $route object pattern is key and $route object class Name is value . The get_class() function is used to get $route Object Class Name
			
			$list[$route->getPattern()] = get_class($route);
		}
		return $list;
	}

	/**
	 * Dispatch The Request Url
	 *
	 * @param no parameter
	 * @return void
	 */

	public function dispatch(){
		//echo $this->_url;
		$dis = new Dispatcher(array(

			"url" => $this->_url,
			"routes"=>$this->_routes
			)
		);
		$dis->dispatch();

		$this->_controller = $dis->getController();
		$this->_action = $dis->getAction();
		$this->_params = $dis->getParams();
	}

}