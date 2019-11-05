<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $items = Input::get('items');
        $request = new Request(Input::get('requestID'));


        foreach ($items as $key => $item){
        $itemCount = (int)$item;
            for($i = 0; $i < $itemCount; $i++){
                $item = $request->getAvailableItemByID(explode('-', $key)[1]);

                try{
                    $request->updateItem([
                        'requestID' => Input::get('requestID'),
                        'statusID' => 2
                    ], $item->ID);

                    $date = new DateTime('now', new DateTimeZone('America/New_York'));
                    $date->setTimezone(new DateTimeZone('UTC'));

                    $log->create([
                        'userID' => $user->data()->id,
                        'caseName' => $request->data()->customerID ? 'customer' : 'lead',
                        'caseID' => $request->data()->customerID ? $request->data()->customerID : $request->data()->leadID,
                        'section' => 'item',
                        'time' => $date->format('Y-m-d G:i:s'),
                        'text' => 'added item '.$item->name.' in request '.$request->data()->title.'.'
                    ]);


                }catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        echo json_encode(['status' => true]);
    }
}