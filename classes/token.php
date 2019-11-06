<!-- for cross site request forgery -->
<?php

class token{
	public static function generate(){
		return Session::put(config::get('session/token_name'), md5(uniqid()));
	}

	public static function check($token){
		$tokenName = config::get('session/token_name');

		if (Session::exists($tokenName) && $token === Session::get($tokenName)){
			Session::delete($tokenName);
			return true;
		}
		return false;
	}
 }