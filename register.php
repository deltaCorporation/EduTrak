<?php
require_once __DIR__ . '/core/ini.php';


if(Input::exists()){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'accEmail' => array(
                'required' => true,
                'email' => true
            ),
            'accName' => array(
                'required' => true
            ),
            'accLastName' => array(
                'required' => true
            ),
            'accJobTitle' => array(
                'required' => true
            ),
            'accPassword' => array(
                'required' => true,
                'min' => 6
            ),
            'accRepeatPassword' => array(
                'required' => true,
                'match' => 'accPassword'
            )
        ));

        if ($validation->passed()) {
            $user = new User();

            $salt = Hash::salt(32);

            $id = date('ymdhis');

            try{

                $user->create(array(
                    'id' => $id,
                    'email' => Input::get('accEmail'),
                    'password' => Hash::make(Input::get('accPassword'), $salt),
                    'salt' => $salt,
                    'firstName' => Input::get('accName'),
                    'lastName' => Input::get('accLastName'),
                    'gender' => Input::get('accGender'),
                    'role' => Input::get('accJobTitle'),
                    'phone' => Input::get('accPhone'),
                    'street' => Input::get('accStreet'),
                    'city' => Input::get('accCity'),
                    'country' => Input::get('accCountry'),
                    'state' => Input::get('accState'),
                    'zip' => Input::get('accZip'),
                    'facebook' => Input::get('accFacebook'),
                    'twitter' => Input::get('accTwitter'),
                    'linkedin' => Input::get('accLinkedIn'),
                    'website' => Input::get('accWebsite'),
                    'img' => Input::get('accGender').'.png',
                    'joined' => date('Y-m-d H:i:s'),
                    'personalPhone' => Input::get('accPersonalPhone'),
                    'emergencyPhone' => Input::get('accEmergencyPhone'),
                    'personalEmail' => Input::get('accPersonalEmail'),
                    'emergencyEmail' => Input::get('accEmergencyEmail'),
                    'startDate' => Input::get('accStartDate'),
                    'endDate' => Input::get('accEndDate')
                ));

                if($permissions = Input::get('permissions')){

                    if(!in_array(1001, $permissions)){
                        $user->createPermission(array(
                            'userID' => $id,
                            'groupID' => 1000,
                        ));
                    }

                    foreach ($permissions as $permission){
                        $user->createPermission(array(
                            'userID' => $id,
                            'groupID' => $permission,
                        ));
                    }

                }else{
                    $user->createPermission(array(
                        'userID' => $id,
                        'groupID' => 1000,
                    ));
                }



                Session::flash('home', 'New Employee has been created!');
                Redirect::to('index.php');

            }catch (Exception $e){
                die($e->getMessage());
            }
        } else {



            $registerErrors = $validation->errors();

            print_r($registerErrors);
        
    }

}else{
    Redirect::to('index.php');
}
?>


