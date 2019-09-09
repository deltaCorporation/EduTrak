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

                if (!isset($_SESSION['accessToken'])) {

                    $token = $user->getAccessToken($user->data()->id);

                    if ($token->gAPI_access_token == null) {

                        // Generate a URL to request access from Google's OAuth 2.0 server:
                        $authUrl = $client->createAuthUrl();

                        // Redirect the user to Google's OAuth server
                        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
                        exit();

                    } else {

                        $_SESSION['accessToken'] = json_decode($token->gAPI_access_token, true);

                    }
                }

                $client->setAccessToken($_SESSION['accessToken']);

                /* Refresh token when expired */
                if ($client->isAccessTokenExpired()) {
                    // the new access token comes with a refresh token as well
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

                    try{
                        $user->update([
                            'gAPI_access_token' => json_encode($client->getAccessToken())
                        ], $user->data()->id);
                    }catch (Exception $e){
                        die($e->getMessage());
                    }
                }

                Redirect::to('index.php');

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

