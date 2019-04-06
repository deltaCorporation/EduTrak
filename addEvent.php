<?php
/*
 * Require ini file with settings
 */




require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()){

    if(Input::exists()){

        $eventCRM = new Event();
        $customer = new Customer();

        require_once __DIR__ . '/google/vendor/autoload.php';

        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

            foreach($customer->getCustomers() as $item){
                if(Input::get('customer') == $item->name){
                    $customerID = $item->id;
                }
            }


            $client->setAccessToken($_SESSION['access_token']);

            $optParams = array();

            $service = new Google_Service_Calendar($client);

            $event = new Google_Service_Calendar_Event(array(
                'summary' => Input::get('eventTitle'),
                'description' => $customerID,
                'start' => array(
                    'date' => Input::get('startDate'),
                ),
                'end' => array(
                    'date' => Input::get('endDate'),
                ),

                /*
                'attendees' => array(
                    array('email' => ''),
                )
                */
            ));

            $calendarId = 'eduscapelearning.com_pddrarllh8a8jaj9p552tv6s9g@group.calendar.google.com';
            $event = $service->events->insert($calendarId, $event);

            if($event){

                $newDate = date('Y-m-d', strtotime(Input::get('startDate')));
                $id = date('ymdhis');

                try{

                    $eventCRM->create(array(
                        'id' => $id,
                        'workshopTitle' => Input::get('workshopTitle'),
                        'date' => $newDate,
                        'statusID' => Input::get('status'),
                        'linkToAsanaTask' => Input::get('link'),
                        'attendeesNumber' => Input::get('numOfAttendees'),
                        'customerID' => $customerID,

                    ));

                    foreach($_POST['instructors'] as $instructor){

                        $eventInstructors = new Event();

                        $eventInstructors->addInstructors(array(
                            'eventID' => $id,
                            'userID' => $instructor,
                        ));

                    }





                    $ntf = new Notification();

                    $users = new User();

                    foreach ($users->getUsers() as $item){
                        if($user->hasPermission('admin') && $item->id != $user->data()->id || $user->hasPermission('superAdmin') && $item->id != $user->data()->id){
                            $ntf->create(array(
                                'content' => $user->data()->firstName.' created new event for customer ' .Input::get('customer'),
                                'ntfDate' => date('m/j/Y h:i A'),
                                'ntfLink' => 'info.php?case=customer&id='.$customerID,
                                'seen' => 0,
                                'userID' => $item->id
                            ));
                        }
                    }

                    Session::flash('home', 'New Event has been created!');
                    Redirect::to('info.php?case=customer&id='.$customerID.'&tab=event');

                }catch (Exception $e){
                    die($e->getMessage());
                }


            }

            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/calendar.php';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

        } else {
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/calendar.php';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

    }

}else{

    Redirect::to('index.php');

}

