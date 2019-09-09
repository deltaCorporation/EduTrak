<?php

    require_once __DIR__ . '/../core/ini.php';
    require_once __DIR__ . '/../vendor/autoload.php';

//    if (php_sapi_name() != 'cli') {
//        throw new Exception('This application must be run on the command line.');
//    }

    $user = new User(30);

    date_default_timezone_set('America/Los_Angeles');

    $REDIRECT_URI = 'http://localhost:8888/EduTrak/sandbox/index.php';
    $KEY_LOCATION = __DIR__ . '/client_secret.json';
    $TOKEN_FILE = "token.txt";

    $SCOPES = array(
        Google_Service_Gmail::MAIL_GOOGLE_COM,
        'email',
        'profile'
    );

    $client = new Google_Client();
    $client->setApplicationName("ctrlq.org Application");
    $client->setAuthConfig($KEY_LOCATION);

    // Incremental authorization
    $client->setIncludeGrantedScopes(true);

    // Allow access to Google API when the user is not present.
    $client->setAccessType('offline');
    $client->setRedirectUri($REDIRECT_URI);
    $client->setScopes($SCOPES);

    if (isset($_GET['code']) && !empty($_GET['code'])) {
        try {
            // Exchange the one-time authorization code for an access token
            $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            // Save the access token and refresh token in local filesystem
            file_put_contents($TOKEN_FILE, json_encode($accessToken));

            $_SESSION['accessToken'] = $accessToken;

            try{
                $user->update([
                    'gAPI_access_token' => $client->getAccessToken(),
                ], 30);
            }catch (Exception $e){
                die($e->getMessage());
            }

            header('Location: ' . filter_var($REDIRECT_URI, FILTER_SANITIZE_URL));
            exit();
        } catch (\Google_Service_Exception $e) {
            print_r($e);
        }

    }

    if (!isset($_SESSION['accessToken'])) {

        $token = @file_get_contents($TOKEN_FILE);
        $token = '{"access_token":"ya29.Glx6B5JNkgv0F1OibBuTRO4SvDB5op3YnTADu0m-ParKGZtZR3HFOKI1WBWT_CoycEQOGXldkK5ImBBolSdI7nl60mBAH9g4NN59--0temrkgj0FczUSIbnGslAbTA","expires_in":3600,"scope":"https:\/\/www.googleapis.com\/auth\/gmail.readonly","token_type":"Bearer","created":1567681117,"refresh_token":"1\/plEU-l5ylq4eQbNRit3rG5qwh82VBXcGlgENCY1vB_A"}';

        if ($token == null) {

            // Generate a URL to request access from Google's OAuth 2.0 server:
            $authUrl = $client->createAuthUrl();

            // Redirect the user to Google's OAuth server
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit();

        } else {

            $_SESSION['accessToken'] = json_decode($token, true);

        }
    }

    $client->setAccessToken($_SESSION['accessToken']);

    /* Refresh token when expired */
    if ($client->isAccessTokenExpired()) {
        // the new access token comes with a refresh token as well
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($TOKEN_FILE, json_encode($client->getAccessToken()));
    }

    $gmail = new Google_Service_Gmail($client);

    $opt_param = array();
    $opt_param['maxResults'] = 10;
//    $opt_param['q'] = 'bcc: test@test.test';
    $opt_param['q'] = 'from: lanie@eduscape.com';

    $threads = $gmail->users_threads->listUsersThreads('me', $opt_param);

    foreach ($threads->getThreads() as $thread){
        foreach ($gmail->users_threads->get('me', $thread->id) as $message){
//            echo $message->id."\n";
//            var_dump($gmail->users_messages->get('me', $message->id)->getPayload());

            echo decodeBody($gmail->users_messages->get('me', $message->id)->getPayload()->getParts()[1]->body->data);
            echo "<br>----------------------------------------------------<br>";
//            foreach ($gmail->users_messages->get('me', $message->id)->getPayload()->getParts()[1] as $part){
//                var_dump(decodeBody($part->body->data));
//            }

//            $data = $gmail->users_messages->get('me', $message->id)->getPayload()->getBody()->data;
//            if($data){
//                echo decodeBody($data);
//            }
        }
    }

//    foreach ($threads as $thread) {
//        print $thread->getId() . " - " . $thread->getSnippet() . '<br/>';
//    }

    function decodeBody($body) {
        $rawData = $body;
        $sanitizedData = strtr($rawData,'-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if(!$decodedMessage){
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }

?>