<?php

namespace Blab\Libs;

class Session
{

	protected static $flash_message;

	public static function setFlash($message){

		self::$flash_message = $message;
	}

	public static function hasFlash(){

		return !is_null(self::$flash_message);
	}

	public static function flashMessage(){

		echo self::$flash_message;

		self::$flash_message = null;
	}

	public static function set($key,$value){

		$_SESSION[$key] = $value;
	}

	public static function exists($name){

		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name,$value){

		return $_SESSION[$name]=$value;

	}

	public static function get($name){

		if (isset($_SESSION[$name])) {
			
			return $_SESSION[$name];

		}

		return null;
	}

	public static function delete($name){

		if (self::exists($name)) {
			
			unset($_SESSION[$name]);
		}
	}

	public static function flash($name , $value=''){

		if (!self::exists($name)) {

			self::put($name , $value);
		
		}else{

			$session = self::get($name);
			self::delete($name);
			return $session;
		}
	}

	public static function destroy(){

		session_destroy();
	}
}