<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){

    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();
        $employee = new User(Input::get('id'));

        if(Input::get('password')){
            $salt = Hash::salt(32);
            $password = Hash::make(Input::get('password'), $salt);
        }

        try{

            $employee->update(array(
                'firstName' => Input::get('firstName'),
                'lastName' => Input::get('lastName'),
                'password' => $password ? $password : $employee->data()->password,
                'salt' => $salt ? $salt : $employee->data()->salt,
                'email' => Input::get('email'),
                'gender' => Input::get('gender'),
                'role' => Input::get('role'),
                'phone' => Input::get('phoneNumber'),
                'street' => Input::get('street'),
                'city' => Input::get('city'),
                'country' => Input::get('country'),
                'state' => Input::get('state'),
                'zip' => Input::get('zip'),
                'facebook' => Input::get('facebook'),
                'twitter' => Input::get('twitter'),
                'linkedin' => Input::get('LinkedIn'),
                'website' => Input::get('Website'),
                'personalPhone' => Input::get('personalPhone'),
                'personalEmail' => Input::get('personalEmail'),
                'emergencyPhone' => Input::get('emergencyPhone'),
                'emergencyEmail' => Input::get('emergencyEmail'),
                'startDate' => Input::get('startDate'),
                'endDate' => Input::get('endDate')
            ),Input::get('id'));

            Session::flash('home', 'Employee has been updated!');
            Redirect::to('employees.php');

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}