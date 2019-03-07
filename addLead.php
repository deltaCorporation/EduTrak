<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            
        ));

        if($validation->passed()){

            $user = new User();
            $lead = new Lead();
            
            $id = date('ymdhis');

            try{

                $lead->create(array(
                	'id' => $id,
                    'firstName' => Input::get('firstName'),
                    'lastName' => Input::get('lastName'),
                    'jobTitle' => Input::get('title'),
                    'category' => Input::get('category'),
                    'company' => Input::get('customer'),
                    'reachedUsBy' => Input::get('reachedUsBy'),
                    'partner' => Input::get('partner'),
                    'partnerRep' => Input::get('partnerRep'),
                    'assignedTo' => Input::get('assignedTo'),
                    'description' => Input::get('description'),
                    'tags' => Input::get('tags'),
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
                    'createdOn' => date('n/j/y'),
                    'lastContacted' => 'Not contacted',
                    'modifiedBy' => '-',
                    'modifiedOn' => '-',
                ));

                if(
                    Input::get('category') == 'Public School' ||
                    Input::get('category') == 'Private School' ||
                    Input::get('category') == 'Diocese' ||
                    Input::get('category') == 'District'
                ){

                    $additionalLead = new Lead();

                    $additionalLead->createAdditionalInfo(array(
                        'goalsAndInitiatives' => Input::get('goalsAndInitiatives'),
                        'numSchools' => Input::get('numSchools'),
                        'numStudents' => Input::get('numStudents'),
                        'numTeachers' => Input::get('numTeachers'),
                        'numTrain' => Input::get('numTrain'),
                        'schoolTech' => Input::get('schoolTech'),
                        'studentsDevices' => Input::get('studentDevices'),
                        'teachersDevices' => Input::get('teachersDevices'),
                        'PDDates' => Input::get('PDDates'),
                        'PDType' => Input::get('PDType'),
                        'leadID' => $id,
                    ));

                }
                
                if(Input::get('assignedTo') != ''){
                	
                	$ntf = new Notification();

                	$ntf->create(array(
                		'content' => $user->data()->firstName.' assigned new lead to you!',
                		'ntfDate' => date('m/j/Y h:i A'),
                		'ntfLink' => 'info.php?case=lead&id='.$id,
                		'seen' => 0,
                		'userID' => Input::get('assignedTo')
             
                	));
                	
                }

                Session::flash('home', 'New lead has been created!');
                Redirect::to('leads.php');

            }catch (Exception $e){
                die($e->getMessage());
            }

        }

   
}else{
    Redirect::to(404);
}