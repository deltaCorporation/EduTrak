<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $customer = null;
        $lead = null;

        if(Input::get('case') === 'customer'){
            $customer = New Customer(Input::get('id'));
        }else{
            $lead = New Lead(Input::get('id'));
        }

        try{

            $requestID = date('dhms');

            $requests->create([
                'id' => $requestID,
                'statusID' => Input::get('kanban') ? Input::get('statusID') : 1,
                'insertDate' => date('Y-m-d'),
                'createdBy' => $user->data()->id,
                'leadID' => Input::get('case') === 'lead' ? $lead->data()->id : null,
                'customerID' => Input::get('case') === 'customer' ? $customer->data()->id : null,
                'assignedTo' => $user->data()->id,
                'title' => Input::get('title')
            ]);

            $id = $customer ? $customer->data()->id : $lead->data()->id;

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $request = new Request($requestID);

            $log->create([
                'userID' => $user->data()->id,
                'caseName' => $customer ? 'customer' : 'lead',
                'caseID' => $id,
                'section' => 'request',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'created request '.$request->data()->title.'.'
            ]);

            if(Input::get('kanban')){
                echo json_encode(['status' => true]);
            }else{
                Session::flash('home', 'New request has been created!');
                Redirect::to('../../info.php?case='.Input::get('case').'&id=' . $id .'&tab=request');
            }

        }catch (Exception $e){
            die($e->getMessage());
        }

    }else {
        Redirect::to('index.php');
    }
}