<?php

require __DIR__ . '/core/ini.php';

$user = new User();
$user->logOut();



Redirect::to('index.php');