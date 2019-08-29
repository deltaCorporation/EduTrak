<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$note = new Note();

if($user->isLoggedIn()) {
    if(Input::exists('get')) {

        $notes = $note->getRequestNotes(Input::get('requestID'));

        echo json_encode($notes);

    }
}