<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if(Input::get('password')){

        try {

            $salt = Hash::salt(32);

            $user->update(array(
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'accActivated' => 1
            ), $user->data()->id);

            Redirect::to('index.php');

        }catch (Exception $e){
            die($e->getMessage());
        }

    }else{
        Redirect::to('index.php');
    }
}else{
    Redirect::to('index.php');
}