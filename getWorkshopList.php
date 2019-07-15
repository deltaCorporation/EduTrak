<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if(Input::exists('get')) {

        $inventory = new Inventory();

        echo json_encode($inventory->getWorkshops());

    }
}