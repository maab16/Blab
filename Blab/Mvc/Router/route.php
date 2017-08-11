<?php

namespace Blab\Mvc\Router;

use Blab\Mvc\Router\Exception as Exception;

class Route extends Route_Base
{

	/**
	 * @var string
	 * @readwrite
	 */
	protected $_pattern;

	/**
	 * @var string
	 * @readwrite
	 */
	protected $_controller;

	/**
	 * @var string
	 * @readwrite
	 */
	protected $_action;
	
	/**
	 * @var array
	 * @readwrite
	 */
	protected $_params = [];

	protected function _getExceptionForImplementation($method){

		return new Exception\Implementation("{$method} method not Implemented");
		
	}
}