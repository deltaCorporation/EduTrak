<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    
        $validate = new Validate();
        $validation = $validate->check($_POST, array(

        ));

        if($validation->passed()){

            $user = new User();
            $contact = new Contact();
            $customer = new Customer();
            
            $customerID = null;
            $id = date('ymdhis');
            
            foreach ($customer->getCustomers() as $customer) {
            	
             	if ($customer->name == Input::get('customer')){
             	 	$customerID = $customer->id;
             	}
            }

            $tags = '';
            if(Input::get('tags') !== ''){
                foreach (json_decode(Input::get('tags')) as $tag){
                    $tags .= $tag->value . ', ';
                }
                $tags = substr($tags, 0, -2);
            }

            try{

                $contact->create(array(
                    'id' => $id,
                    'customerID' => $customerID,
                    'firstName' => Input::get('firstName'),
                    'lastName' => Input::get('lastName'),
                    'jobTitle' => Input::get('title'),
                    'category' => Input::get('category'),
                    'customer' => Input::get('customer'),
                    'description' => Input::get('description'),
                    'tags' => $tags,
                    'officePhone' => Input::get('officePhone'),
                    'phoneExt' => Input::get('extension'),
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
                    'createdBy' => $user->data()->firstName.' '.$user->data()->lastName,
                    'createdOn' => date('m/d/Y'),
                    'lastContacted' => 'Not contacted',
                    'modifiedBy' => '-',
                    'modifiedOn' => '-',
                ));

                Session::flash('home', 'New Contact has been created!');
                Redirect::to('contacts.php');

            }catch (Exception $e){
                die($e->getMessage());
            }

        }

    
}else{
    Redirect::to(404);
}