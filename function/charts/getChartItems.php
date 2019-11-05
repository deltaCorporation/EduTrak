<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$request = new Request();

if($user->isLoggedIn()) {
    if(Input::exists('get')) {

        $inStock = $request->getInStockItems(Input::get('statusID'));

        echo json_encode($inStock);

    }
}