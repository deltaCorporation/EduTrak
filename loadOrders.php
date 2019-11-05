<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$request = new Request();

if($user->isLoggedIn()){

    header('Content-Type: application/json');
    echo json_encode($request->getOrders('list', Input::get('page'), Input::get('sort'), Input::get('order'), Input::get('filters')));

}