<?php

namespace Blab\Libs;

use Blab\Mvc\Models\Blab_Model;

/**
* 
*/
class Permission extends BLAB_Model
{

	public function getPermission($permission){

		// Check User Logged in or not
		$default = Registry::get('default');

		if (Session::exists($default->sessionName)) {
			
			$username = Session::get($default->sessionName);
			// Check user exists
			if($users = $this->_db->query()->exists('users',array('username','=',$username))){
				if ($users->getAffectedRows()) {

					// Store Current User Data
					
					$user = $users->getResults()[0];

					// Check User Permission

					if($groups = $this->_db->query()->exists('groups',array('id','=',$user->grp))){

						if ($groups->getAffectedRows()) {

							// Store User Permission Data with json decode formate
							$group = $groups->getResults()[0];
							$permissions = json_decode($group->permission,true);
							// Check given permission is exists

							// var_dump($permissions[0] !== $permission);
							// die();

							if (array_key_exists($permission,$permissions)) {

								if ($permissions[$permission]==true) {
								
									return true;
								}
								
							}
						}
					}
				}
			}
		}

		return false;
	}

	public function hasPermission($permission){

		return $this->getPermission($permission);
	}
}