<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();

if($user->isLoggedIn()) {
    if (Input::exists('get')) {

        try{

            $requests->update([
                'statusID' => Input::get('statusID')
            ], Input::get('requestID'));

        }catch (Exception $e){
            die($e->getMessage());
        }

        echo json_encode($requests->getStatusByID(Input::get('statusID')));

    }
}