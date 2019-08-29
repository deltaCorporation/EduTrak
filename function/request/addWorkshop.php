<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $workshop = new Inventory(Input::get('workshopID'));
        $request = new Request(Input::get('requestID'));

        try {

            $requests->createRequestWorkshop([
                'requestID' => Input::get('requestID'),
                'workshopTitle' => $workshop->data()->titleOfOffering,
                'workshopDescription' => $workshop->data()->description,
                'workshopLearnerOutcomes' => $workshop->data()->learnerOutcomes,
                'workshopPrerequisites' => $workshop->data()->prerequisites,
                'workshopPrice' => $workshop->data()->msrp === null ? 0 : $workshop->data()->msrp
            ]);

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $log->create([
                'userID' => $user->data()->id,
                'caseName' => $request->data()->customerID ? 'customer' : 'lead',
                'caseID' => $request->data()->customerID ? $request->data()->customerID : $request->data()->leadID,
                'section' => 'workshop',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'added workshop '.$workshop->data()->titleOfOffering.' for request '.$request->data()->title.'.'
            ]);

            echo json_encode(['status' => true]);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}