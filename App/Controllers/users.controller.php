<?php

namespace App\Controllers;

use Blab\Mvc\Controllers as Controllers;
use App\Models;
use Blab\Libs\Input;
use Blab\Libs\Session;
use Blab\Libs\Registry;
use Blab\Libs\Redirect;
use Blab\Libs\Pagination;
use Blab\Libs\Blab_User;
use Blab\Libs\Permission;

class UsersController extends Controllers\Blab_Controller
{
	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new Models\User();
	}

	public function index(){

		if((new Blab_User())->isLoggedIn()){
			if(!(new Permission())->hasPermission('admin')){
				Redirect::to('/');
			}
		}

		$page = !empty($this->params[0]) ? $this->params[0] : 1;

		$limit = 5;
		/*Get All Product*/
		$this->data['all_user'] = $this->model->getAllUser($limit,$page);

		$this->data['total'] = $this->model->count('users',array('active'=>1));

		/*
		 * Pagination
		 */

		// Page Link

		$page_link  = '/users/index/';

		// pagination($opt1=table_name,$opt2=total_items,$opt3=page_link,$opt4=display_items,$opt5=where condition)
		if ($this->data['total']>0) {

			$pgn = new Pagination('users',$this->data['total'],$page_link,'','',$limit,'id','desc');

			$this->data['pagination_controll'] = $pgn->getPaginationLists();

			$this->data['pagination'] = $pgn->getPaginationData();
		}
	}

	public function new_users(){

		if((new Blab_User())->isLoggedIn()){
			if(!(new Permission())->hasPermission('admin')){
				Redirect::to('/');
			}
		}

		$page = !empty($this->params[0]) ? $this->params[0] : 1;

		$limit = 5;
		/*Get All Product*/
		$this->data['new_users'] = $this->model->getNewUsers($limit,$page);

		$this->data['total'] = $this->model->count('users',array('active'=>0));

		/*
		 * Pagination
		 */

		// Page Link

		$page_link  = '/users/new_users/';

		// pagination($opt1=table_name,$opt2=total_items,$opt3=page_link,$opt4=display_items,$opt5=where condition)
		if ($this->data['total']>0) {

			$pgn = new Pagination('users',$this->data['total'],$page_link,'','',$limit,'id','desc');

			$this->data['pagination_controll'] = $pgn->getPaginationLists();

			$this->data['pagination'] = $pgn->getPaginationData();
		}
	}

	public function profile(){
		if(!(new Blab_User())->isLoggedIn()){
			Redirect::to('/users/login/');
		}
		/*Get Single User Data for Update Page*/

		if (!empty($this->params[0])) {
			$this->data['single_user'] = $this->model->getUserInfo($this->params[0],'users');
		}
	}

	public function settings(){
		/*Check User Logged In or Not*/
		if(!(new Blab_User())->isLoggedIn()){
			Redirect::to('/users/login/');
		}
		/*Get Single User Data for Update Page*/

		if (!empty($this->params[0])) {
			$this->data['single_user'] = $this->model->getUserInfo($this->params[0],'users');
		}
		/*Update User Data*/
		if (Input::exists()) {	
			$this->data['update_error'] = $this->model->updateUser($_POST);
		}
	}

	public function permission(){
		if((new Blab_User())->isLoggedIn()){
			$user = (new Blab_User())->data();
			if(!(new Permission())->hasPermission('admin')){
				Redirect::to('/');
			}
		}else{

			Redirect::to('/users/login/');
		}

		/* Permissions*/

		$this->data['permissions'] = $this->model->getAllPermission();

		/*Get All Status for User*/

		$this->data['status'] = $this->model->getAllStatus();

		/*Get User Permission*/
		$this->data['user_permission'] = $this->model->getUserPermission($this->params[0]);
		$this->data['user_status'] = $this->model->getUserStatus($this->params[0]);
		if (Input::exists()) {
			$this->model->setPermission();
			$this->model->setUserStatus();
		}
	}

	public function approve(){
		if((new Blab_User())->isLoggedIn()){
			if(!(new Permission())->hasPermission('admin')){
				Redirect::to('/');
			}
		}

		if (!empty($this->params[0])) {
			$this->model->approveUser($this->params[0]);
		}
	}

	public function create(){
		if((new Blab_User())->isLoggedIn()){
			if(!(new Permission())->hasPermission('admin')){
				Redirect::to('/');
			}
		}

		if (isset($_POST['signup'])) {
			
			$this->data['signup_error'] = $this->model->createUser($_POST);
		}
	}

	public function register(){

		if (isset($_POST['signup'])) {
			
			$this->data['signup_error'] = $this->model->setUser($_POST);
		}elseif(isset($_POST['login'])){

			$this->data['login_error'] = $this->model->logInUser($_POST);
		}
	}

	public function login(){

		if (Input::exists()) {
			
			//$default = Registry::get('default');
			//$tokenName = $default->tokenName;

			//Session::set($default->tokenName,Input::get('token'));

			
			$this->data['login_error'] = $this->model->logInUser($_POST);
		}
	}

	public function logout(){

		$this->model->logOutUser();
	}

	public function delete(){
		if((new Blab_User())->isLoggedIn()){
			if(!(new Permission())->hasPermission('admin')){
				Redirect::to('/');
			}
		}

		if (!empty($this->params[0])) {
			$this->model->deleteUser($this->params[0]);
		}
		
	}
}