<?php

namespace App\Models;

use Blab\Libs\Blab_User;
use Blab\Libs\Input;
use Blab\Libs\Token;
use Blab\Libs\Hash;
use Blab\Libs\Session;
use Blab\Libs\Redirect;

class User extends Blab_User
{

	public function getAllUser($limit,$page){

            return $this->_db->query()
                      ->from('users',[
	                        'users.id'				=>'id',
	                        'users.email'			=>'email',
	                        'profiles.fname'		=>'first_name',
	                        'profiles.lname'		=>'last_name',
	                        'profiles.user_image'	=>'user_image',
	                        'profiles.company'		=>'company',
	                        'profiles.mobile'		=>'mobile',
	                        'profiles.country_code'	=>'country',
	                        'profiles.city'			=>'city',
	                        'profiles.website'		=>'website',
	                        'groups.group_name'		=>'permission',
	                        'user_status.title'		=>'status',
	                  ])
	                  ->where(array('active'=>1))
                      ->join('INNER','profiles','profiles.user_id=users.id')
                      ->join('INNER','groups','groups.id=users.grp')
                      ->join('INNER','user_status','status_id=users.active')
                      ->limit($limit,$page)
                	  ->order(array('id'=>'DESC'))
                      ->results();
	}

	public function getNewUsers($limit,$page){

            return $this->_db->query()
                      ->from('users',[
	                        'users.id'				=>'id',
	                        'users.email'			=>'email',
	                        'profiles.fname'		=>'first_name',
	                        'profiles.lname'		=>'last_name',
	                        'profiles.user_image'	=>'user_image',
	                        'profiles.company'		=>'company',
	                        'profiles.mobile'		=>'mobile',
	                        'profiles.country_code'	=>'country',
	                        'profiles.city'			=>'city',
	                        'profiles.website'		=>'website',
	                        'groups.group_name'		=>'permission',
	                        'user_status.title'		=>'status',
	                  ])
	                  ->where(array('active'=>0))
                      ->join('INNER','profiles','profiles.user_id=users.id')
                      ->join('INNER','groups','groups.id=users.grp')
                      ->join('INNER','user_status','status_id=users.active')
                      ->limit($limit,$page)
                	  ->order(array('id'=>'DESC'))
                      ->results();
	}

	public function getUserInfo($id,$tableName="users"){
		return $this->_db->query()
                      ->from($tableName,[
	                        'users.id'				=>'id',
	                        'users.username'		=>'username',
	                        'users.email'			=>'email',
	                        'profiles.user_image'	=>'user_image',
	                        'profiles.fname'		=>'first_name',
	                        'profiles.lname'		=>'last_name',
	                        'profiles.company'		=>'company',
	                        'profiles.mobile'		=>'mobile',
	                        'profiles.phone'		=>'phone',
	                        'profiles.website'		=>'website',
	                        'profiles.country_code'	=>'country',
	                        'profiles.city'			=>'city',
	                        'profiles.address'		=>'address',
	                        'groups.group_name'		=>'permission',
	                        'user_status.title'		=>'status',
	                  ])
	                  ->where(array('users.id'=>$id),'=')
                      ->join('INNER','profiles','profiles.user_id='.$id)
                      ->join('INNER','groups','groups.id=users.grp')
                      ->join('INNER','user_status','status_id=users.active')
                      ->firstResult();
	}

	public function updateUser($source){

		$input = new Input();
								
		$validation = $input->check($source,array(
			'email'=>array(
					'required'=>true,
					'min'=>15,
					'email'=>'username',
					'unique'=>'users'
					),							
		));

		if ($validation->passed()) {

			$salt = hash::salt(32);

			$id = input::get('id');

			$user_image = $_FILES['image']['name'];
			$image_tmp = $_FILES['image']['tmp_name'];
			move_uploaded_file($image_tmp,'assets/images/users/'.$user_image);

			try{
				$user = $this->_db->query()
						->into("users")
						->where(array('id'=> $id))
						->update([
								'email'=>Input::get('email'),
								'updated_at'=>date('Y-m-d')
							]
						);

				$user = $this->_db->query()
						->from("users")
						->where(array('username'=>Input::get('username')),'=')
						->firstResult();

				$profile = $this->_db->query()
						->into("profiles")
						->where(array('user_id'=> $id))
						->update([
								'fname'			=>Input::get('fname'),
								'lname'			=>Input::get('lname'),
								'user_image'	=>$user_image,
								'country_code'	=>Input::get('country_code'),
								'city'			=>Input::get('city'),
								'phone'			=>Input::get('phone'),
								'mobile'		=>Input::get('mobile'),
								'address'		=>Input::get('address'),
								'company'		=>Input::get('company'),
								'website'		=>Input::get('website')
							]
						);
				if ($user || $profile) {
					Session::setFlash('Your registration Successfully.');
					Redirect::to("/users/settings/$id/");
										
				}
			} catch (Exception $e) {

				die($e->getMessage());
										
			}

		}else{

			return $validation->errors();
		}
	
	}

	public function getAllPermission(){

		return $this->_db->query()
                ->from('groups',[
	                  'id',
	                  'group_name'
	              ])
	            ->results();
	}

	public function getAllStatus(){
		return $this->_db->query()
                ->from('user_status',[
	                  'status_id',
	                  'title'
	              ])
	            ->results();
	}

	public function getUserStatus($user_id){
		return $this->_db->query()
				->from('users',['active'])
				->where(array('id'=>$user_id))
				->firstResult();
	}

	public function getUserPermission($id){

		return $this->_db->query()
            ->from('users',['id','username','grp'])
            ->where(array('id'=>$id))
            ->firstResult();
	}

	public function approveUser($id){
		$approveUser = $this->_db->query()
						->into("users")
						->where(array('id'=> $id))
						->update([
							'active'=>1,
						]
					);
		if ($approveUser) {
			Redirect::to('/users/');
		}
	}

	public function setPermission(){
		$setUserPermission = $this->_db->query()
							->into("users")
							->where(array('id'=> Input::get('id')))
							->update([
								'grp'			=>Input::get('permission'),
								'updated_at'	=>date('Y-m-d')
							]
						);
		if ($setUserPermission) {
			Redirect::to('/users/');
		}
	}

	public function setUserStatus(){
		$setUserPermission = $this->_db->query()
							->into("users")
							->where(array('id'=> Input::get('id')))
							->update([
								'active'		=>Input::get('status'),
								'updated_at'	=>date('Y-m-d')
							]
						);
		if ($setUserPermission) {
			Redirect::to('/users/');
		}
	}

	public function setUser($source){

		$input = new Input();
								
		$validation = $input->check($source,array(
			'username'=>array(
					'required'	=>true,
					'min'		=>5,
					'max'		=>255,
					'unique'	=>'users'
					),
			'email'=>array(
					'required'	=>true,
					'min'		=>15,
					'email'		=>'username',
					'unique'	=>'users'
					),
			'password'=>array(

					'required'		=>true,
					'min'			=>8,
					'preg_match'	=>'password'
					),
			're_password'=>array(

					'required'		=>true,
					'matches'		=>'password'
					),							
		));
		if ($validation->passed()) {

			$salt = hash::salt(32);

			try{

				$result = $this->create(array(

										"username"		=> Input::get('username'),
										"password"		=> Hash::make(Input::get('password')),
										"salt"			=> '',
										"email"			=> Input::get('email'),
										"active"		=> 1,
										"grp" 			=> 1,
										"created_at"	=> date("Y-m-d"),
										"updated_at"	=> date("Y-m-d"),
										));
				$user = $this->_db->query()
						->from("users")
						->where(array('username'=>Input::get('username')),'=')
						->firstResult();

				$this->_db->query()
				->into("profiles")
				->insert(array('user_id'=> $user->id));
									
				Session::setFlash('Your registration Successfully.');
				Redirect::to('/users/login');
										
			} catch (Exception $e) {

				die($e->getMessage());
										
			}

		}else{

			return $validation->errors();
		}
	}

	public function createUser($source){

		$input = new Input();
								
		$validation = $input->check($source,array(
			'username'=>array(
					'required'	=>true,
					'min'		=>5,
					'max'		=>255,
					'unique'	=>'users'
					),
			'email'=>array(
					'required'	=>true,
					'min'		=>15,
					'email'		=>'username',
					'unique'	=>'users'
					),
			'password'=>array(

					'required'		=>true,
					'min'			=>8,
					'preg_match'	=>'password'
					),
			're_password'=>array(

					'required'	=>true,
					'matches'	=>'password'
					),							
		));
		if ($validation->passed()) {

			$salt = hash::salt(32);

			try{

				$result = $this->create(array(

										"username"		=>Input::get('username'),
										"password"		=>Hash::make(Input::get('password')),
										"salt"			=>'',
										"email"			=>Input::get('email'),
										"active"		=>1,
										"grp" 			=> 1,
										"created_at"	=>date("Y-m-d"),
										"updated_at"	=>date("Y-m-d"),
										));
				$user = $this->_db->query()
						->from("users")
						->where(array('username'=>Input::get('username')),'=')
						->firstResult();

				$profile = $this->_db->query()
							->into("profiles")
							->insert(array('user_id'=> $user->id));

				Session::setFlash('Your registration Successfully.');
				Redirect::to('/users/');
										
			} catch (Exception $e) {

				die($e->getMessage());
										
			}

		}else{

			return $validation->errors();
		}
	}

	public function logInUser($source){

		
		if (Token::check(Input::get('token'))) {
			
			$input = new Input();

			$validation = $input->check($source,array(
				'username'=>array(
						'required'	=>true,
						'min'		=>5,
						'max'		=>255
						),
				'password'=>array(
						'required'		=>true,
						'min'			=>8,
						'preg_match'	=>'password'
						)						
			));
			if ($validation->passed()) {
				/*
				if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
					$url = "https://www.google.com/recaptcha/api/siteverify";
					$privatekey = "6Lc8Mw0TAAAAAH0jajVKd9w-Wuk7abFnKdOETrNk";
					$ip = $_SERVER['REMOTE_ADDR'];
					$response = $_POST['g-recaptcha-response'];

					$rsp = file_get_contents($url ."?secret=".$privatekey."&response=".$response."&remoteip=".$ip);
					$data = json_decode($rsp);

					if (isset($data->success) && $data->success==true) {
				*/
						$remember = (Input::get('remember')==='on') ? true : false;

						$login = $this->login(Input::get('username'),Input::get('password'),$remember);

						if($login) {
							Redirect::to('/dashboard/');
												
						}else{

							echo "<script>alert('Username or Password Combination Does not Match.')</script>";
							echo "<script>window.open('/users/login/' , '_self')</script>";
						}
				/*							
					}else{

						echo "Captche Doesn't Set";
					}
				}else{

					Session::setFlash("Please Select Captcha !!");
				}

			*/
			}else{

				return $validation->errors();
			}
		}else{

			echo "<script>alert('Token Does not Set')</script>";
			echo "<script>window.open('/users/login/' , '_self')</script>";
		}
	}

	public function logOutUser(){

		$this->logout();
	}

	public function deleteUser($id){

		$deleteProfile = $this->_db->query()
					->from('profiles')
					->where(array('user_id'=>$id),'=')
					->delete();
		$deleteUserSession = $this->_db->query()
					->from('users_session')
					->where(array('user_id'=>$id),'=')
					->delete();
		$deleteUser = $this->_db->query()
					->from('users')
					->where(array('id'=>$id),'=')
					->delete();

		if ($deleteUser) {
			
			echo "<script>alert('Data Deleted Successfully.')</script>";
			Redirect::to('/users/');
		}

	}

	public function count($tableName,$where=array()){

		return $this->_db->query()
				->from($tableName)
				->where($where)
	            ->countRows();
	}

}