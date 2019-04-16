<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){

    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();

        $id = date('Ymdhis');

        try{

            $inventory->create(array(

            ));

            Session::flash('home', 'New Hardware Item has been created!');
            Redirect::to('hardware.php');

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}