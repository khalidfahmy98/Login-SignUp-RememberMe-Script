<?php 
session_start();
$GLOBALS['config'] = array(
    'mysql' => array(
        'host'      =>  '127.0.0.1',
        'username'  =>  'root',
        'password'  =>  '',
        'db'        =>  'oopscript'
    ),
    'remember' => array (
        'cookie_name'   => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array (
        'session_name' => 'user',
        'token_name'   => 'token'
    )
);
spl_autoload_register(function($class){
    require_once "classes/" . $class . ".php";
});
require_once 'functions/sanitize.php';

if( cookie::exists(config::get('remember/cookie_name')) && !session::exists(config::get('session','session_name')) ){
    $hash = cookie::get(config::get('remember/cookie_name'));
    $hashCheck = database::getInstance()->get('user_session',array('hash','=',$hash));
    if($hashCheck->count()){
        $user = new user($hashCheck->first()->user_id);
        $user->login();
    }
}