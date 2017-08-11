<?php

namespace Blab\Mvc\Router;

interface RouteInterface
{

	public function getController($name);

	public function setController($name,$value);

	public function getAction($name);

	public function setAction($name,$value);

	public function getParams();

	public function setParams();
}