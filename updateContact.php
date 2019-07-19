<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    
        $validate = new Validate();
        $validation = $validate->check($_POST, array(

        ));

        if($validation->passed()){

            $user = new User();
            $contact = new Contact(Input::get('contactId'));

            try{

                $contact->update(array(
                    'firstName' => Input::get('firstName'),
                    'lastName' => Input::get('lastName'),
                    'jobTitle' => Input::get('jobTitle'),
                    'category' => Input::get('category'),
                    'customer' => Input::get('customer'),
                    'description' => Input::get('description'),
                    'tags' => Input::get('tags'),
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
                    'modifiedOn' => date('n/j/y'),
                ),Input::get('contactId'));

                Session::flash('home', 'Contact has been updated!');
                Redirect::to("info.php?case=contact&id=".Input::get('contactId'));

            }catch (Exception $e){
                die($e->getMessage());
            }

        }

    
}else{
    Redirect::to(404);
}