<?php
	
namespace Blab\Mvc\Views;

use Blab\Mvc\Bootstrap as Bootstrap;

	class View
	{

		protected $data;
		protected $path;

		protected static function getDefaultViewPath(){

			$router = Bootstrap::getRouter();

			if (!$router) {
				
				return false;
			}

			$controller_dir = $router->getController();
			$template_name = $router->getMethodPrefix().$router->getAction().'.php';

			return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
		}

		public function __construct($data = array(),$path=null){

			if(!$path){

				$path = self::getDefaultViewPath();
			}

			if (!file_exists($path)) {

				//Session::setFlash("Opps!Your Looking file Not Exists.");
				//Redirect::to('/');
				
				throw new \Exception("Template file isn't found in path".$path);
				
			}

			$this->path = $path;
			$this->data = $data;
		}

		public function render(){

			$data = $this->data;
			ob_start();
			include($this->path);
			$content = ob_get_clean();
			ob_clean();
			
			return $content;
		}
	}