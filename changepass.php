<?php

    require_once __DIR__ . '/core/ini.php';

    $user = new User();

    if(!$user->isLoggedIn()){
        Redirect::to('index.php');
    }

    if(Input::exists()){
        

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'current_pass' => array(
                    'required' => true,
                    'min' => 6
                ),
                'new_pass' => array(
                    'required' => true,
                    'min' => 6
                ),
                'new_pass_again' => array(
                    'required' => true,
                    'match' => 'new_pass'
                )
            ));

            if($validation->passed()){

                try{

                    if(Hash::make(Input::get('current_pass'), $user->data()->salt) !== $user->data()->password){
                        echo 'Current password is wrong!';
                    }else{

                        $salt = Hash::salt(32);

                        $user->update(array(
                            'password' => Hash::make(Input::get('new_pass'), $salt),
                            'salt' => $salt
                        ));

                        Session::flash('home', 'Your password has been changed!');
                        Redirect::to('index.php');
                    }

                }catch (Exception $e){
                    $e->getMessage();
                }

            }else{
                foreach ($validation->errors() as $error){
                    echo " {$error} <br>";
                }
            

        }
    }
?>

<form action="" method="post">
    <div class="field">
        <label for="current_pass">Current password</label>
        <input type="password" name="current_pass" id="current_pass">
    </div>
    <div class="field">
        <label for="new_pass">New password</label>
        <input type="password" name="new_pass" id="new_pass">
    </div>
    <div class="field">
        <label for="new_pass_again">Repeat password</label>
        <input type="password" name="new_pass_again" id="new_pass_again">
    </div>

    
    <input type="submit" value="Change">
</form>
