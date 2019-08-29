<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request(Input::get('requestID'));
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $assign = new User(Input::get('assignedTo'));

        try{

            $requests->update([
                'assignedTo' => Input::get('assignedTo')
            ], Input::get('requestID'));

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $log->create([
                'userID' => $user->data()->id,
                'caseName' => $requests->data()->customerID ? 'customer' : 'lead',
                'caseID' => $requests->data()->customerID ? $requests->data()->customerID : $requests->data()->leadID,
                'section' => 'assign',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'assign request '.$requests->data()->title.' to '.$assign->data()->firstName .' '. $assign->data()->lastName .'.'
            ]);
        }catch (Exception $e){
            die($e->getMessage());
        }

        echo json_encode(['status' => true]);

    }
}