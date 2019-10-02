<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/../../core/ini.php';

$user = new User();

$email = Input::get('email');
$code = Input::get('code');

if($email) {
    if($user->find($email)){

        if($user->checkResetCode($code)){
            echo json_encode(['status' => 200]);
        }else{
            echo json_encode(['status' => 500]);
        }

    }else{
        echo json_encode(['status' => 404]);
    }
}else{
    echo json_encode(['status' => 403]);
}