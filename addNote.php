<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){

    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();
        $note = new Note();
        

        if(Input::get('contactNotePrivate')){
            $visibility = 'private';
        }else{
            $visibility = 'public';
        }

        if(Input::get('case') == 'employee')
            $redirectLink = 'profile.php?id='.Input::get('id').'';
        else
            $redirectLink = 'info.php?case='.Input::get('case').'&id='.Input::get('id').'';

	if(Input::get('contactNoteProtected')){
            $visibility = 'protected';
            $redirectLink = 'profile.php?id='.Input::get('id').'';
        }

        try{
        
        if(Input::get('case') == 'lead' && Input::get('contactNoteCall')){
            
            $lead = new Lead(Input::get('id'));
            
            $lead->update(array(
            	 'lastContacted' => date('n/j/y')
          	),Input::get('id'));
            	 
            }elseif (Input::get('case') == 'contact' && Input::get('contactNoteCall')){
            	 $contact = new Contact(Input::get('id'));
            	 $customer = new Customer($contact->data()->customerID);
            
            $contact->update(array(
            	 'lastContacted' => date('n/j/y')
          	),Input::get('id'));
          	
          	$customer->update(array(
            	 'lastContacted' => date('n/j/y')
          	),$contact->data()->customerID);
            
            }
            
            $note->create(array(
                'title' => Input::get('contactNoteTitle'),
                'content' => Input::get('contactNoteContent'),
                'section' => Input::get('case'),
                'visibility' => $visibility,
                'userID' => $user->data()->id,
                'type' => Input::get('contactNoteCall'),
                'createdOn' => date('n/j/y'),
                'contactsID' => Input::get('id'),
            ));
            
          

            Session::flash('home', 'New Note has been added!');
            Session::flash('note', 'defaultOpen');

            Redirect::to($redirectLink);

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}