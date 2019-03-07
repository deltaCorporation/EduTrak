<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists('post')){
    if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'role' => array(
                    'min' => 2,
                    'max' => 40
            )
        ));

        if($validation->passed()){

             try{
                $user->update(array(
                    'name' => Input::get('name'),
                    'role' => Input::get('role')
                ));

            }catch (Exception $e){
                $e->getMessage();
            }

        }else{
            foreach ($validation->errors() as $error){
                echo " {$error} <br>";
            }
        }

        $image = new Image();

        if($image->exists($_FILES['img']['name'])){

            $image->check(500000, array('jpg', 'png', 'jpeg', 'gif'));


            if($image->passed()){


                try{

                    $extension = $image->upload(Config::get('img_path/profile'), 'profile'.$user->data()->id);
                    $user->update(array(
                        'img' => 'profile'.$user->data()->id.'.'.$extension
                    ));

                }catch (Exception $e){
                    $e->getMessage();
                }

            }else{
                foreach ($image->errors() as $error){
                    echo " {$error} <br>";
                }
            }

        }

        if($validation->passed() || $image->passed()){
            Session::flash('home', 'Your details have been updated');
            Redirect::to('index.php');
        }

    }
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="field">
        <label for="name">Name </label>
        <input name="name" type="text" id="name" value="<?php echo escape($user->data()->name); ?>">
    </div>

    <div class="field">
        <label for="role">Role </label>
        <input name="role" type="text" id="role" value="<?php echo escape($user->data()->role); ?>">
    </div>

    <div class="field">
        <label for="img">Upload profile picture </label>
        <input name="img" type="file" id="img" value="">
    </div>

    <input type="submit" value="Update">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>




