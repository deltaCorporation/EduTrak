<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/../../core/ini.php';
require __DIR__ . '/../../vendor/autoload.php';

$user = new User();
$mail = new PHPMailer(true);

$email = Input::get('email');
$resetCode = rand(100000, 999999);

if($email) {
    if($user->find($email)){

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '9c64eee2d917ae';
            $mail->Password = '8131edcf4fc937';
            $mail->Port = 2525;

            //Recipients
            $mail->setFrom('no-reply@elevationlearningllc.com', 'Mailer');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'EduTrak password reset code';
            $mail->Body = '<b>'.$resetCode.'</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            $user->update([
                'resetCode' => $resetCode
            ], $user->data()->id);

            echo json_encode(['status' => 200]);

        } catch (Exception $e) {
            die($e->getMessage());
        }

    }else{
        echo json_encode(['status' => 404]);
    }
}else{
    echo json_encode(['status' => 403]);
}