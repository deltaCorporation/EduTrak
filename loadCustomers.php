<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$customer = new Customer();

if($user->isLoggedIn()){

    header('Content-Type: application/json');
    echo json_encode($customer->getCustomers('list', Input::get('page'), Input::get('sort'), Input::get('order'), Input::get('filters')));

}