<?php

namespace Blab\Libs;

use Blab\Mvc\Models\Blab_Model;
use Blab\Libs\Session;
use Blab\Libs\Cookie;
use Blab\Libs\Registry;

class Blab_User extends Blab_Model
{

	private	$_data,
			$_sessionName,
			$_cookieName,
			$_default,
			$_isLoggedIn = false,
			$_cartItems,
			$_cartResult,
			$_newUsersList,
			$_newUsersData;

	private static $_instanceUser=null;

	public function __construct($user=null){

		// Call The parent __construct for instantiate Database
		Parent::__construct();

		$this->_default = Registry::get('default');
		$this->_sessionName = $this->_default->sessionName;
		$this->_cookieName = $this->_default->cookieName;
		
		if (!$user) {
			
			if (Session::exists($this->_sessionName)) {
				
				$user = Session::get($this->_sessionName);

				if ($this->find($user)) {
					
					$this->_isLoggedIn = true;
				}
			}

		}else{

			if($this->find($user)){

				$this->_isLoggedIn = true;
			}
		}
	}

	public function create($fields = array()){

		return $this->_db->query()
		->into("users")
		->insert($fields);
	}

	public function get($name){

		if(input::get($name)==''){

			if ($name=='birth_day' || $name=='birth_month' || $name=='birth_year') {

				$birth_date = $this->data()->birth_date;
				
				$birth_date = explode('-',$birth_date);

				$birth_day = $birth_date[0];
				$birth_month = $birth_date[1];
				$birth_year = $birth_date[2];

				if ($name=='birth_day') {
					
					return $birth_day;
				}else if ($name=='birth_month') {
					
					return $birth_month;
				}else if ($name=='birth_year') {
					
					return $birth_year;
				}
			}

			return $this->data()->$name;

			

		}else{

			return input::get($name);
		}
	}

	public function update($fields = array(),$user_id=null){

		if (!$user_id && $this->isLoggedIn()) {
			
			$user_id = $this->data()->id;
		}

		if (!$this->_db->query()
				->from('users')
				->where(array('user_id'=>$user_id))
				->update($fields)) {
			
			throw new Exception("There was a problem to update Your details .");
			
		}else{
			return true;
		}

	}

	public function find($fieldValue=null){

		if ($fieldValue) {


			if (is_numeric($fieldValue)) {
				
				$field = 'id';
			}else if (filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
				
				$field = 'email';
			}else{

				$field = 'username';
			}

			$query = $this->_db->query()->exists('users',array($field,'=',$fieldValue));

			if ($query !== false) {
				
				foreach($query->getResults() as $this->_data){
					return true;

				}				
			}
		}

		return false;
	}

	public function login($username=null,$password=null,$remember=false){

		if (!$username && !$password && $this->exists()) {
			
			Session::set($this->_sessionName,$this->data()->username);

		}else{

			if ($this->find($username)) {
			
				if ($this->data()->password===Hash::make($password) && $this->data()->active==1) {
					
					Session::set($this->_sessionName,$this->data()->username);

					if ($remember) {
						
						$hash = Hash::unique();
						$hashChek = $this->_db->query()
									->from('users_session')
									->where(array('user_id'=>$this->data()->id))
									->firstResult();
						if (!$hashChek) {
							
							$this->_db->query()
							->into('users_session')
							->insert(array(

								'user_id'=>$this->data()->id,
								'hash'=>$hash

								));
						}else{

							$hash = $hashChek->hash;
						}

						Cookie::put($this->_cookieName,$hash,$this->_default->cookieExpiry);
						
					}

					return true;
				}

			}
		}

		return false;
	}

	public function logout(){

		$this->_db->query()
				  ->from('users_session')
				  ->where(array(
					'user_id'=>$this->data()->id
				  ))
				  ->delete();
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
		Redirect::to('/users/login/');
	}

	public function loggedInUser(){

		if (Cookie::exists($this->_cookieName) && !Session::exists($this->_sessionName)) {
		    
		    $hash = Cookie::get($this->_cookieName);

		    $cookie = $this->_db->query()
		                ->from('users_session')
		                ->where(array('hash'=>$hash))
		                ->firstResult();

		    if ($cookie) {  
		        
		        (new BLAB_User($cookie->user_id))->login();
		    }
		}
	}

	/*Additional*/

	public function carts(){
		$results = $this->_db->query()
					->from('carts')
					->where(array('user_id'=>$this->_data->id))
					->results();
		$this->_cartItems = $results ? count($results) : 0;
		$this->_cartResult = $results ? $results : 0;

		return $this;
	}

	public function getCartResult(){

		if (!isset($this->_cartResult)) {
			$this->carts();
		}
		return $this->_cartResult;
	}

	public function getCartsList(){
		if (!isset($this->_cartItems)) {
			$this->carts();
		}
		return $this->_cartItems;
	}

	public function getSingleCart($id,$tableName='carts',$field='product_id'){

		if (!isset($id)) {
			throw new \Exception("id must be needed", 1);
			
		}

		$results = $this->_db->query()
					->from($tableName)
					->where(array($field=>$id,'user_id'=>$this->data()->id))
					->firstResult();
		return $results ? $results : null;
	}

	/*End Additional*/

	public function newUsers(){

		$newUsers = $this->_db->query()
					->from('users')
					->where(array('active'=>0))
					->results();
		$this->_newUsersList = $newUsers ? count($newUsers) : 0 ;
		$this->_newUsersData = $newUsers ? $newUsers : 0 ;

		return $this;
	}

	public function getNewUsersData(){

		if (!isset($this->_newUsersData)) {
			$this->newUsers();
		}

		return $this->_newUsersData;
	}

	public function getNewUsersList(){

		if (!isset($this->_newUsersList)) {
			$this->newUsers();
		}

		return $this->_newUsersList;
	}

	public function data(){

		return $this->_data;
	}

	public static function getUserInstance(){

		if (!isset(self::$_instanceUser)) {
			
			self::$_instanceUser = new BLAB_User();
		}

		return self::$_instanceUser;

	}

	public function isLoggedIn(){

		return $this->_isLoggedIn;
	}

	public function exists(){

		return (!empty($this->_data)) ? true : false ;
	}


}