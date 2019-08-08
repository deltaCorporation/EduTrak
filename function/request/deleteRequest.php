<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $request = new Request(Input::get('requestID'));

        try{

            $request->delete($request->data()->ID);

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $log->create([
                'userID' => $user->data()->id,
                'caseName' => $request->data()->customerID ? 'customer' : 'lead',
                'caseID' => $request->data()->customerID ? $request->data()->customerID : $request->data()->leadID,
                'section' => 'delete',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'deleted request - '.$request->data()->ID.'.'
            ]);

            Session::flash('home', 'Request deleted');

            echo json_encode(['status' => true]);

        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}