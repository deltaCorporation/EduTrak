<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$lead = new Lead();


$maintenance = false;

if($user->isLoggedIn()){

    header('Content-Type: application/json');
    echo json_encode($lead->getLeads('list', Input::get('page'), Input::get('sort'), Input::get('order'), Input::get('filters')));

}