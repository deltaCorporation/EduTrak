<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    
        $validate = new Validate();
        $validation = $validate->check($_POST, array(

        ));

        if($validation->passed()){

            $user = new User();
            $contact = new Contact(Input::get('contactId'));
            $log = new ActivityLog();

            $tags = '';
            if(Input::get('tags') !== ''){
                foreach (json_decode(Input::get('tags')) as $tag){
                    $tags .= $tag->value . ', ';
                }
                $tags = substr($tags, 0, -2);
            }

            try{

                $contact->update(array(
                    'firstName' => Input::get('firstName'),
                    'lastName' => Input::get('lastName'),
                    'jobTitle' => Input::get('jobTitle'),
                    'category' => Input::get('category'),
                    'customer' => Input::get('customer'),
                    'description' => Input::get('description'),
                    'tags' => $tags,
                    'officePhone' => Input::get('officePhone'),
                    'phoneExt' => Input::get('phoneExt'),
                    'mobilePhone' => Input::get('mobilePhone'),
                    'email' => Input::get('email'),
                    'street' => Input::get('street'),
                    'city' => Input::get('city'),
                    'country' => Input::get('country'),
                    'state' => Input::get('state'),
                    'zip' => Input::get('zip'),
                    'facebook' => Input::get('facebook'),
                    'twitter' => Input::get('twitter'),
                    'linkedIn' => Input::get('linkedIn'),
                    'website' => Input::get('website'),
                    'followUpDate' => Input::get('followUpDate'),
                    'modifiedBy' => $user->data()->firstName.' '.$user->data()->lastName,
                    'modifiedOn' => date('m/d/Y'),
                ),Input::get('contactId'));

                $date = new DateTime('now', new DateTimeZone('America/New_York'));
                $date->setTimezone(new DateTimeZone('UTC'));

                $log->create([
                    'userID' => $user->data()->id,
                    'caseName' => 'contact',
                    'caseID' => $contact->data()->id,
                    'section' => 'update',
                    'time' => $date->format('Y-m-d G:i:s'),
                    'text' => 'updated contact.'
                ]);

                if(($contact->data()->followUpDate !== Input::get('followUpDate')) && Input::get('followUpDate') !== ''){

                    $followUpDate = Input::get('followUpDate');

                    $log->create([
                        'userID' => $user->data()->id,
                        'caseName' => 'contact',
                        'caseID' => $contact->data()->id,
                        'section' => 'followup',
                        'time' => $date->format('Y-m-d G:i:s'),
                        'text' => 'update follow up date to '.date('m/d/y', strtotime($followUpDate)).'.'
                    ]);
                }

                Session::flash('home', 'Contact has been updated!');
                Redirect::to("info.php?case=contact&id=".Input::get('contactId'));

            }catch (Exception $e){
                die($e->getMessage());
            }

        }

    
}else{
    Redirect::to(404);
}