<?php

namespace Blab\Mvc;

use Blab\Libs\Session;
use Blab\Libs\Redirect;
use Blab\Libs\Registry;
use Blab\Libs\Blab_User;

class Bootstrap
{

	protected static $router;

	public static $db;

	public static function getRouter(){

		return self::$router;
	}

	public static function run($url){

		// Initial Router
		self::$router = new Router(array(

				"url"=>$url,
			));

		//Lang::load(self::$router->getLanguage());
		
		$controllerName = ucfirst(self::$router->getController()."Controller");
	
		$controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

		// Calling controllers method
		$controller = "\App\Controllers\\{$controllerName}";
		$controller_object = new $controller();

		if (method_exists($controller_object, $controller_method)) {
							
			/*
			 * Set Data for View
			 * Set View Path
			 */
			$view_path = $controller_object->$controller_method();
			
			$view_object = new Views\View($controller_object->getData(),$view_path);
			$content = $view_object->render();
			
		}else{
			//Redirect::to('/'.self::$router->getController().'/');
			throw new \Exception('Method '.$controller_method . ' of class '.$controllerName . ' does not exists .');
		}

		//Set Dashboard Layout

		if (self::$router->getController()=='dashboard') {
			
			$default = Registry::get('default');
			
			if (Session::exists($default ->sessionName)) {
				
				$user = new Blab_User(Session::get($default ->sessionName));
				if ($user->isLoggedIn()) {
					
					$layout = self::$router->getController();

				}else{

					Redirect::to('/users/login/');
				}
			}else{

				Redirect::to('/users/login/');
			}

			$layout = Registry::get('default')->dashboardRoute;
			
		}else{

			// Set Default Root Layout

			$layout = Registry::get('default')->defaultRoute;
		}

		$layout_path = VIEWS_PATH.DS.$layout.'.php';
		$layout_view_object = new Views\View(compact('content'),$layout_path);
		echo $layout_view_object->render();
	}
}