<?php

namespace App\Controllers;

use Blab\Mvc\Controllers\Blab_Controller;
use App\Models;
use Blab\Mvc\Bootstrap;
use Blab\Libs\Pagination;
use Blab\Libs\Redirect;
use Blab\Libs\Blab_User;
use Blab\Libs\Permission;

class DashboardController extends BLAB_Controller
{
		
	function __construct($data=array()){
		
		Parent::__construct($data);
		$this->model = new Models\Dashboard();
	}

	public function index(){

		if(!(new Blab_User())->isLoggedIn()){
			Redirect::to('/users/login/');
		}else{
			$user = (new Blab_User())->data();
		}

	}
}