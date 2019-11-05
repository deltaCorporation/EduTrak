<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$log = new ActivityLog();
$note = new Note();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $request = new Request(Input::get('requestID'));

        try {

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $note->updateRequestNote([
                'text' => Input::get('text'),
            ], Input::get('noteID'));


            $log->create([
                'userID' => $user->data()->id,
                'caseName' => $request->data()->customerID ? 'customer' : 'lead',
                'caseID' => $request->data()->customerID ? $request->data()->customerID : $request->data()->leadID,
                'section' => 'note',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'updated note in request '.$request->data()->title.'.'
            ]);

            echo json_encode(['status' => true]);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}