<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request(Input::get('requestID'));
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        try{

            $requests->update([
                'statusID' => Input::get('statusID')
            ], Input::get('requestID'));

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $status = $requests->getStatusByID(Input::get('statusID'));

            $log->create([
                'userID' => $user->data()->id,
                'caseName' => $requests->data()->customerID ? 'customer' : 'lead',
                'caseID' => $requests->data()->customerID ? $requests->data()->customerID : $requests->data()->leadID,
                'section' => 'status',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'changed request '.$requests->data()->title.' status on '.$status->name.'.'
            ]);
        }catch (Exception $e){
            die($e->getMessage());
        }

        echo json_encode($status);

    }
}