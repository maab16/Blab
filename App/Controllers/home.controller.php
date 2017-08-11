<?php

namespace App\Controllers;

use Blab\Mvc\Controllers as Controllers;
use App\Models;

class HomeController extends Controllers\Blab_Controller
{
	public function __construct($data = array()){

		parent::__construct($data);
		$this->model = new Models\Home();
	}

	public function index(){

		//echo "OK! Home Index";
	}

	public function contact(){

		//echo "Hello Gaust";
	}

	public function view(){

		//echo "Here is View";
	}
}