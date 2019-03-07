<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'Eduscape_CRM',
        'pass' => 'password1',
        'db' => 'Eduscape_CRM',
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_time' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_account' => 'token_account',
        'token_login' => 'token_login',
        'token_lead' => 'token_lead',
        'token_contact' => 'token_contact',
        'token_customer' => 'token_customer'
    ),
    'img_path' => array(
        'profile' => 'view/img/profile/'
    )
);

spl_autoload_register(function ($class){
    require_once __DIR__ . '/../class/'. $class .'.php';
});

require_once __DIR__. '/../function/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists('session/session_name')){
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array(Config::get('remember/cookie_name'), '=', $hash));

    if($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}