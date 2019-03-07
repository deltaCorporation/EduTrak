<?php

require_once __DIR__ . '/core/ini.php';




if (Input::exists()){
    
    
    

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array('required' => true, 'email' => true),
            'password' => array('required' => true)
        ));

        if ($validation->passed()){

            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;

            $login = $user->login(Input::get('email'), Input::get('password'), $remember);

            if ($login){
                Redirect::to('connect.php');
            }else{
                $loginErrors = array(
                    'email' => 'Wrong email or password',
                    'password' => 'Wrong email or password'
                );
                $defaultLogin = 'defaultOpen';
                $defaultRegister = '';
            }


        }else{
            $loginErrors = $validation->errors();
        }

    
}
?>

