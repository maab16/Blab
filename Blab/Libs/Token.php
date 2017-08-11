<?php

namespace Blab\Libs;

class Token
{
	
	public static function generate(){
		$default = Registry::get('default');
		return Session::put($default->tokenName,md5(uniqid()));
	}

	public static function check($token){
		$default = Registry::get('default');

		$tokenName = $default->tokenName;

		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
				
			Session::delete($tokenName);

			return true;
		}
		return false;
	}
}