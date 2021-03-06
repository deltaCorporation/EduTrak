<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    

        $validate = new Validate();
        $validation = $validate->check($_POST, array(

        ));

        if($validation->passed()){

            $user = new User();
            $customer = new Customer();
            $log = new ActivityLog();

            $id = date('ymdhis');

            if($_FILES["logo"]["size"] !== 0){
                $target_dir = "view/img/logos/";
                $target_file = $target_dir . basename($_FILES["logo"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                }

                move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);

            }

            $tags = '';
            if(Input::get('tags') !== ''){
                foreach (json_decode(Input::get('tags')) as $tag){
                    $tags .= $tag->value . ', ';
                }
                $tags = substr($tags, 0, -2);
            }

            try{

                    $customer->create(array(
                        'id' => $id,
                        'name' => Input::get('name'),
                        'category' => Input::get('category'),
                        'partnerRep' => Input::get('partnerRep'),
                        'description' => Input::get('description'),
                        'tags' => $tags,
                        'partner' => Input::get('partner'),
                        'parentCustomer' => Input::get('parentCustomer'),
                        'officePhone' => Input::get('officePhone'),
                        'phoneExt' => Input::get('extension'),
                        'mobilePhone' => Input::get('mobilePhone'),
                        'email' => Input::get('email'),
                        'fax' => Input::get('fax'),
                        'accountsPayableInfo' => Input::get('accPayInfo'),
                        'street' => Input::get('street'),
                        'city' => Input::get('city'),
                        'state' => Input::get('state'),
                        'country' => Input::get('country'),
                        'zip' => Input::get('zip'),
                        'facebook' => Input::get('facebook'),
                        'twitter' => Input::get('twitter'),
                        'linkedIn' => Input::get('linkedIn'),
                        'website' => Input::get('website'),
                        'lastContacted' => 'Not contacted',
                        'createdBy' => $user->data()->firstName.' '.$user->data()->lastName,
                        'createdOn' => date('m/d/Y'),
                        'modifiedBy' => '-',
                        'modifiedOn' => '-',
                        'logo' => basename($_FILES["logo"]["name"])
                    ));

                    if(
                        Input::get('category') == 'Public School' ||
                        Input::get('category') == 'Private School' ||
                        Input::get('category') == 'Diocese' ||
                        Input::get('category') == 'District'
                    ){

                        $additionalCustomer = new Customer();

                        $additionalCustomer->createAdditionalInfo(array(
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
                            'customerID' => $id,
                        ));

                    }

                $date = new DateTime('now', new DateTimeZone('America/New_York'));
                $date->setTimezone(new DateTimeZone('UTC'));

                $log->create([
                    'userID' => $user->data()->id,
                    'caseName' => 'customer',
                    'caseID' => $id,
                    'section' => 'create',
                    'time' => $date->format('Y-m-d G:i:s'),
                    'text' => 'created customer.'
                ]);

                    Session::flash('home', 'New Customer has been created!');
                    Redirect::to('customers.php');

                }catch (Exception $e) {
                    die($e->getMessage());
                }
        }

    
}else{
    Redirect::to(404);
}