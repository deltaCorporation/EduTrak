<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();

if($user->isLoggedIn()) {
    if (Input::exists()) {

        try{

            $requests->update([
                'quoteTitle' => Input::get('quoteTitle'),
            ], Input::get('requestID'));

        }catch (Exception $e){
            die($e->getMessage());
        }

    }
}