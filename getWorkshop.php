<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if(Input::exists('get')) {

        $inventory = new Inventory(Input::get('workShopID'));

        echo json_encode($inventory->data());

    }
}