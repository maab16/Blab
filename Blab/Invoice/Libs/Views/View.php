<?php

namespace Blab\Invoice\Libs\Views;

use Twig_Environment;
use Twig_Loader_Filesystem;

class View
{
	protected $data;

	protected $viewPath;

	public function __construct($path=null){

		if (!file_exists($path)) {
			
			throw new \Exception("Template file isn't found in path".$path);	
		}

		$this->viewPath = $path;
	}

	public function render($filename, array $data = []){

		$this->viewPath .= DIRECTORY_SEPARATOR . $filename;

		$data = $data;

		ob_start();

		include($this->viewPath);
		$content = ob_get_clean();
		//echo $content;

		ob_clean();

		return $content;
	}

	// public function __construct($view){

	// 	$this->twig = new \Twig_Environment(
	// 			new Twig_Loader_Filesystem($view)
	// 		);
	// }

	// public function render($view, array $data = []){
	// 	return $this->twig->render($view,$data);
	// }
}