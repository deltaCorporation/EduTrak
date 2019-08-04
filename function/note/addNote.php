<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$note = new Note();

if($user->isLoggedIn()) {
    if (Input::exists('post')) {

        try{

            if(Input::get('call') === 'true'){
                switch (Input::get('section')){
                    case 'lead':
                        $lead = new Lead();
                        $lead->update([
                            'lastContacted' => date('m/d/Y')
                        ],Input::get('id'));
                        break;

                    case 'customer':
                        $customer = new Customer();
                        $customer->update([
                            'lastContacted' => date('m/d/Y')
                        ],Input::get('id'));
                        break;

                    case 'contact':
                        $contact = new Contact(Input::get('id'));

                        $contact->update(array(
                            'lastContacted' => date('m/d/Y')
                        ),Input::get('id'));

                        if($contact->data()->customerID){
                            $customer = new Customer($contact->data()->customerID);

                            $customer->update(array(
                                'lastContacted' => date('m/d/Y')
                            ),$contact->data()->customerID);
                        }
                        break;
                }
            }

            $note->create([
               'title' => Input::get('title'),
                'content' => Input::get('text'),
                'section' => Input::get('section'),
                'visibility' => Input::get('private') === 'true' ? 'private' : 'public',
                'type' => Input::get('call') === 'true' ? 'call' : '',
                'userID' => $user->data()->id,
                'createdOn' => date('m/d/Y'),
                'contactsID' => Input::get('id')
            ]);

            echo json_encode(['status' => true]);
        }catch (Exception $e){
            die($e->getMessage());
        }

    }else {
        Redirect::to('index.php');
    }
}