<?php

	require_once __DIR__ . '/core/ini.php';
	
	$user = new User();
	
	if($user->isLoggedIn()){
		if($id = Input::get('id')){
		
			$event = new Event($id);

			$link = 'info.php?case=customer&id='.$event->data()->customerID.'&tab=event';

            try{

                $event->update(array(
                    'workshopTitle' => Input::get('workshopTitle'),
                    'date' => Input::get('date'),
                    'statusID' => Input::get('statusID'),
                    'attendeesNumber' => Input::get('numberOfAttendees'),
                    'linkToAsanaTask' => Input::get('link'),
                ), $id);

                foreach ($event->getInstructors($id) as $instructor){
                    $event->deleteInstructors($instructor->id);
                }

                foreach(Input::get('instructors') as $instructor){

                    $event->addInstructors(array(
                        'eventID' => $id,
                        'userID' => $instructor
                    ));

                }

                Redirect::to($link);

            }catch (Exception $e){
                die($e->getMessage());
            }

		}
	}
	
	