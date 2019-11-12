<!-- help with auto loading classes  -->
<?php
// allowing people to log in
//echo "inside here";
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '123456',
        'db' => 'camagru'
        //'port' => '8080'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

//standard php library
spl_autoload_register(function ($class) {
    require_once 'classes/'.$class .'.php';
});

require_once 'functions/sanitize.php';
require_once 'classes/config.php';
require_once 'classes/DB.php';

if (cookie::exists(config::get('remember/cookie_name')) && !Session::exists(config::get('session/session_name'))){
    //echo "remember me";
   $hash = cookie::get(config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
    if($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}
//require_once 'register.php';
//require_once 'classes/validate.php';
//require_once 'classes/user.php';
//require_once 'classes/token.php';
//require_once 'classes/session.php';
//echo "inside here init \n";

