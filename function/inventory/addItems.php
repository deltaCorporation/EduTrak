<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();
$log = new ActivityLog();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        $itemID = Input::get('itemID');
        $qty = (int)Input::get('qty');
        $lastItemID = $requests->getLastItem() ? $requests->getLastItem()->ID : null;
        $itemName = $requests->getTypeByID($itemID)->name;

        if($lastItemID){
            $lastItemIDNo = (int)substr($lastItemID, 2);
        }else{
            $lastItemIDNo = 0;
        }


        for($i = 0; $i < $qty; $i++){
            $lastItemIDNo++;

            $newItemID = str_pad($lastItemIDNo, 5,'0', STR_PAD_LEFT);

            try{

                $requests->createItem([
                    'ID' => 'PE'.$newItemID,
                    'itemTypeID' => $itemID,
                    'statusID' => 1,
                    'createdBy' => $user->data()->id
                ]);

            }catch (Exception $e){
                die($e->getMessage());
            }
        }

        $date = new DateTime('now', new DateTimeZone('America/New_York'));
        $date->setTimezone(new DateTimeZone('UTC'));

        $log->create([
            'userID' => $user->data()->id,
            'section' => 'item',
            'time' => $date->format('Y-m-d G:i:s'),
            'text' => 'added '.$qty.' '.$itemName.'s to inventory.'
        ]);

        echo json_encode(['status' => true]);
    }
}