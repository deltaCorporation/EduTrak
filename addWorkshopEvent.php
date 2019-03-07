<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){

    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();
        $event = new Event();

        $redirectLink = 'info.php?case='.Input::get('case').'&id='.Input::get('id').'';



        try{

            $event->create(array(
                'workshopTitle' => Input::get('workshopTitle'),
                'date' => date('m-j-y'),
                'status' => Input::get('status'),
                'instructor' => Input::get('instructor'),
                'linkToAsanaTask' => Input::get('link'),
                'customerId' => Input::get('id'),
                
            ));

            Session::flash('home', 'New Event has been added!');

            Redirect::to($redirectLink);

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}