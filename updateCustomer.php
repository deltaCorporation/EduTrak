<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    

        $validate = new Validate();
        $validation = $validate->check($_POST, array(

        ));

        if($validation->passed()){

            $user = new User();
            $customer = new Customer(Input::get('customerId'));

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

                try {

                    $customer->update(array(
                        'name' => Input::get('name'),
                        'category' => Input::get('category'),
                        'partnerRep' => Input::get('partnerRep'),
                        'description' => Input::get('description'),
                        'tags' => Input::get('tags'),
                        'partner' => Input::get('partner'),
                        'parentCustomer' => Input::get('parentCustomer'),
                        'officePhone' => Input::get('officePhone'),
                        'phoneExt' => Input::get('phoneExt'),
                        'mobilePhone' => Input::get('mobilePhone'),
                        'email' => Input::get('email'),
                        'fax' => Input::get('fax'),
                        'accountsPayableInfo' => Input::get('accountsPayableInfo'),
                        'street' => Input::get('street'),
                        'city' => Input::get('city'),
                        'state' => Input::get('state'),
                        'country' => Input::get('country'),
                        'zip' => Input::get('zip'),
                        'facebook' => Input::get('facebook'),
                        'twitter' => Input::get('twitter'),
                        'linkedIn' => Input::get('linkedIn'),
                        'website' => Input::get('website'),
                        'modifiedBy' => $user->data()->firstName . ' ' . $user->data()->lastName,
                        'modifiedOn' => date('n/j/y'),
                        'logo' => $logo
                    ), Input::get('customerId'));

                    if (Input::get('category') == 'Public School' ||
                        Input::get('category') === 'Private School' ||
                        Input::get('category') === 'Diocese' ||
                        Input::get('category') === 'District') {

                        if ($customer->getAdditionalInfo(Input::get('customerId'))) {

                            $customer->updateAdditionalInfoCustomer(array(
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
                            ), Input::get('customerId'));

                        } else {
                            $customer->createAdditionalInfo(array(
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
                                'customerID' => Input::get('customerId')
                            ));
                        };
                    }

                    Session::flash('home', 'Customer has been updated!');
                    Redirect::to('info.php?case=customer&id=' . Input::get('customerId'));

                } catch (Exception $e) {
                    die($e->getMessage());
                }

        }

    
}else{
    Redirect::to(404);
}