<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        if(Input::get('case') === 'customer'){
            $customer = New Customer(Input::get('id'));
        }else{
            $lead = New Lead(Input::get('id'));
        }

        try{

            $requestID = date('dhms');

            $requests->create([
                'id' => $requestID,
                'statusID' => 1,
                'insertDate' => date('Y-m-d'),
                'createdBy' => $user->data()->id,
                'leadID' => $lead ? $lead->data()->id : null,
                'customerID' => $customer ? $customer->data()->id : null
            ]);

            foreach (Input::get('data') as $workshop){

                $requests->createRequestWorkshop([
                    'requestID' => $requestID,
                    'workshopTitle' => $workshop['title'],
                    'workshopDescription' => $workshop['description'],
                    'workshopLearnerOutcomes' => $workshop['learnerOutcomes'],
                    'workshopPrerequisites' => $workshop['prerequisites'],
                    'workshopPrice' => $workshop['msrp']
                ]);

            }

            $id = $customer ? $customer->data()->id : $lead->data()->id;

            Session::flash('home', 'New request has been created!');
            Redirect::to('../../info.php?case='.Input::get('case').'&id=' . $id);

        }catch (Exception $e){
            die($e->getMessage());
        }

    }else {
        Redirect::to('index.php');
    }
}