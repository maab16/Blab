<?php

namespace Blab\Mvc\Router;

interface RouterInterface
{
	/**
	 * Set New Route
	 * @param 
	 * @return Current Object
	 */
	public function addRoute($route);

	/**
	 * Remove Specific Route
	 * @param 
	 * @return 
	 */

	public function removeRoute($route);

	/**
	 * Get Specific Route
	 * @param 
	 * @return 
	 * public function getRoute();
	 */

	/**
	 * Get All Available Routes
	 * @param 
	 * @return 
	 */

	public function getRoutes();

	/**
	 * Parts url and call Controller and action
	 * @param no parameter
	 * @return 
	 */

	public function dispatch();
}