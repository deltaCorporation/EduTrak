<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $request = new Request(Input::get('requestID'));

        try{

            $request->delete($request->data()->ID);

            Session::flash('home', 'Request deleted');

            echo json_encode(['status' => true]);

        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}