<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if (Input::exists()) {

        try{
            $user->updateUserTravelInfo(array(
                Input::get('field') => Input::get('value')
            ), Input::get('id'));
        }catch (Exception $e){
            die($e->getMessage());
        }

    }else{
        Redirect::to('index.php');
    }
}else{
    Redirect::to('index.php');
}