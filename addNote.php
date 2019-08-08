<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){

    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();
        $note = new Note();
        $log = new ActivityLog();

        if(Input::get('contactNotePrivate')){
            $visibility = 'private';
        }else{
            $visibility = 'public';
        }

        if(Input::get('case') == 'employee')
            $redirectLink = 'profile.php?id='.Input::get('id').'';
        else
            $redirectLink = 'info.php?case='.Input::get('case').'&id='.Input::get('id').'&tab=notes';

	if(Input::get('contactNoteProtected')){
            $visibility = 'protected';
            $redirectLink = 'profile.php?id='.Input::get('id').'';
        }

        try{
        
        if(Input::get('case') == 'lead' && Input::get('contactNoteCall')){
            
            $lead = new Lead(Input::get('id'));
            
            $lead->update(array(
            	 'lastContacted' => date('m/d/Y')
          	),Input::get('id'));
            	 
            }elseif (Input::get('case') == 'contact' && Input::get('contactNoteCall')){
            	 $contact = new Contact(Input::get('id'));
            	 $customer = new Customer($contact->data()->customerID);
            
            $contact->update(array(
            	 'lastContacted' => date('m/d/Y')
          	),Input::get('id'));
          	
          	$customer->update(array(
            	 'lastContacted' => date('m/d/Y')
          	),$contact->data()->customerID);
            
            }
            
            $note->create(array(
                'title' => Input::get('contactNoteTitle'),
                'content' => Input::get('contactNoteContent'),
                'section' => Input::get('case'),
                'visibility' => $visibility,
                'userID' => $user->data()->id,
                'type' => Input::get('contactNoteCall'),
                'createdOn' => date('m/d/Y'),
                'contactsID' => Input::get('id'),
            ));

            $date = new DateTime('now', new DateTimeZone('America/New_York'));
            $date->setTimezone(new DateTimeZone('UTC'));

            $log->create([
                'userID' => $user->data()->id,
                'caseName' => Input::get('case'),
                'caseID' => Input::get('id'),
                'section' => 'note',
                'time' => $date->format('Y-m-d G:i:s'),
                'text' => 'created note.'
            ]);

            if(Input::get('contactNoteCall')){
                $log->create([
                    'userID' => $user->data()->id,
                    'caseName' => Input::get('case'),
                    'caseID' => Input::get('id'),
                    'section' => 'call',
                    'time' => $date->format('Y-m-d G:i:s'),
                    'text' => 'contacted '.Input::get('case')
                ]);
            }

            Session::flash('home', 'New Note has been added!');

            Redirect::to($redirectLink);

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}