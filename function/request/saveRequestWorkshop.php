<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();

if($user->isLoggedIn()) {
    if (Input::exists()) {

            try{

                foreach (Input::get('data') as $key => $workshop){

                    $requests->updateWorkshop([
                        'workshopDescription' => $workshop['description'],
                        'workshopLearnerOutcomes' => $workshop['learnerOutcomes'],
                        'workshopPrerequisites' => $workshop['prerequisites'],
                        'workshopPrice' => $workshop['price']
                    ], $key);


                }

                echo json_encode(['status' => true]);

            }catch (Exception $e){
                die($e->getMessage());
            }

    }
}