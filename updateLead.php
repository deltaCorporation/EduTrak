<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            
        ));

        if($validation->passed()){

            $user = new User();
            $lead = new Lead(Input::get('leadId'));

            $logo = Input::get('logoOLD');

            if($_FILES["logo"]["size"] !== 0) {
                $target_dir = "view/img/logos/";
                $target_file = $target_dir . basename($_FILES["logo"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                }

                move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);

                $logo = basename($_FILES["logo"]["name"]);
            }

            try{

                $lead->update(array(
                    'firstName' => Input::get('firstName'),
                    'lastName' => Input::get('lastName'),
                    'jobTitle' => Input::get('title'),
                    'category' => Input::get('category'),
                    'company' => Input::get('customer'),
                    'archDiocese' => Input::get('archDiocese'),
                    'reachedUsBy' => Input::get('reachedUsBy'),
                    'eventName' => Input::get('eventName'),
                    'partner' => Input::get('partner'),
                    'partnerRep' => Input::get('partnerRep'),
                    'assignedTo' => Input::get('assignedTo'),
                    'description' => Input::get('description'),
                    'tags' => Input::get('tags'),
                    'officePhone' => Input::get('officePhone'),
                    'phoneExt' => Input::get('ext'),
                    'mobilePhone' => Input::get('mobilePhone'),
                    'email' => Input::get('email'),
                    'street' => Input::get('street'),
                    'city' => Input::get('city'),
                    'country' => Input::get('country'),
                    'state' => Input::get('state'),
                    'zip' => Input::get('zip'),
                    'followUpDate' => Input::get('followUpDate'),
                    'facebook' => Input::get('facebook'),
                    'twitter' => Input::get('twitter'),
                    'linkedIn' => Input::get('linkedIn'),
                    'website' => Input::get('website'),
                    'modifiedBy' => $user->data()->firstName.' '.$user->data()->lastName,
                    'modifiedOn' => date('m/d/Y'),
                    'logo' => $logo
               
                    
                ),Input::get('leadId'));

                if( Input::get('category') == 'Public School' ||
                    Input::get('category') === 'Private School' ||
                    Input::get('category') === 'Diocese' ||
                    Input::get('category') === 'District'){

                    if($lead->getAdditionalInfo(Input::get('leadId'))) {

                        $lead->updateAdditionalInfo(array(
                            'goalsAndInitiatives' => Input::get('goalsAndInitiatives'),
                            'numSchools' => Input::get('numSchools'),
                            'numStudents' => Input::get('numStudents'),
                            'numTeachers' => Input::get('numTeachers'),
                            'numTrain' => Input::get('numTrain'),
                            'schoolTech' => Input::get('schoolTech'),
                            'studentsDevices' => Input::get('studentsDevices'),
                            'teachersDevices' => Input::get('teachersDevices'),
                            'PDDates' => Input::get('PDDates'),
                            'PDType' => Input::get('PDType')
                        ), Input::get('leadId'));

                    }else{
                        $lead->createAdditionalInfo(array(
                            'goalsAndInitiatives' => Input::get('goalsAndInitiatives'),
                            'numSchools' => Input::get('numSchools'),
                            'numStudents' => Input::get('numStudents'),
                            'numTeachers' => Input::get('numTeachers'),
                            'numTrain' => Input::get('numTrain'),
                            'schoolTech' => Input::get('schoolTech'),
                            'studentsDevices' => Input::get('studentsDevices'),
                            'teachersDevices' => Input::get('teachersDevices'),
                            'PDDates' => Input::get('PDDates'),
                            'PDType' => Input::get('PDType'),
                            'leadID' => Input::get('leadId')
                        ));
                    }
;
                }

                Session::flash('home', 'Lead has been updated!');
                Redirect::to("info.php?case=lead&id=".Input::get('leadId'));

            }catch (Exception $e){
                die($e->getMessage());
            }

        }

   
}else{
    Redirect::to(404);
}