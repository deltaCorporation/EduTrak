<?php
/*
 * Require ini file with settings
 */

require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

$user = new User();

if($user->isLoggedIn()){

    if(Input::exists()){

        $eventCRM = new Event();
        $customer = new Customer();
        $log = new ActivityLog();

        $REDIRECT_URI = $GLOBALS['config']['G_REDIRECT_URL'];
        $KEY_LOCATION = __DIR__ . '/client_secret.json';

        $SCOPES = array(
            Google_Service_Gmail::MAIL_GOOGLE_COM,
            'email',
            'profile',
            Google_Service_Calendar::CALENDAR
        );

        $client = new Google_Client();
        $client->setApplicationName("EduTrak");
        $client->setAuthConfig($KEY_LOCATION);

        // Incremental authorization
        $client->setIncludeGrantedScopes(true);

        // Allow access to Google API when the user is not present.
        $client->setAccessType('offline');
        $client->setRedirectUri($REDIRECT_URI);
        $client->setScopes($SCOPES);

        if (!isset($_SESSION['accessToken'])) {

            $token = $user->getAccessToken($user->data()->id);

            if ($token->gAPI_access_token == null) {

                // Generate a URL to request access from Google's OAuth 2.0 server:
                $authUrl = $client->createAuthUrl();

                // Redirect the user to Google's OAuth server
                header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
                exit();

            } else {

                $_SESSION['accessToken'] = json_decode($token->gAPI_access_token, true);

            }
        }

        $client->setAccessToken($_SESSION['accessToken']);

        /* Refresh token when expired */
        if ($client->isAccessTokenExpired()) {
            // the new access token comes with a refresh token as well
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            try{
                $user->update([
                    'gAPI_access_token' => json_encode($client->getAccessToken())
                ], $user->data()->id);
            }catch (Exception $e){
                die($e->getMessage());
            }
        }

        if (isset($_SESSION['accessToken'])) {

            foreach($customer->getCustomers() as $item){
                if(Input::get('customer') == $item->name){
                    $customerID = $item->id;
                }
            }

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

            $calendarId = $GLOBALS['config']['CALENDAR_ID'];
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

                    $date = new DateTime('now', new DateTimeZone('America/New_York'));
                    $date->setTimezone(new DateTimeZone('UTC'));

                    $log->create([
                        'userID' => $user->data()->id,
                        'caseName' => 'customer',
                        'caseID' => $customerID,
                        'section' => 'event',
                        'time' => $date->format('Y-m-d G:i:s'),
                        'text' => 'created new event for this customer.'
                    ]);

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

