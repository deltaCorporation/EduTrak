<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

$user = new User();

$REDIRECT_URI = $GLOBALS['config']['G_REDIRECT_URL'];
$KEY_LOCATION = __DIR__ . '/client_secret.json';

$SCOPES = array(
    Google_Service_Gmail::MAIL_GOOGLE_COM,
    'email',
    'profile',
    Google_Service_Calendar::CALENDAR
);

$client = new Google_Client();
$client->setApplicationName("EduTrak");
$client->setAuthConfig($KEY_LOCATION);

// Incremental authorization
$client->setIncludeGrantedScopes(true);

// Allow access to Google API when the user is not present.
$client->setAccessType('offline');
$client->setRedirectUri($REDIRECT_URI);
$client->setScopes($SCOPES);

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

$calendar = new Calendar();
$inventory = new Inventory();

$tagOptions = '';
if($grups = $inventory->getFilterItems('workshopGroups')){
    foreach ($grups as $group){
        $tagOptions .= "'". $group->workshopGroups . "', ";
    }
    $tagOptions = substr($tagOptions, 0, -2);
}

if($user->isLoggedIn()){

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CRM</title>

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/style.css" rel="stylesheet">
        <link href="view/css/tagify.css" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/remodal.css" rel="stylesheet">
        <link href="view/css/remodal-default-theme.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="view/js/jQuery.tagify.min.js"></script>
        <script src="view/js/tagify.js"></script>

        <script src="view/js/remodal.js"></script>



    </head>
    <body>

    <?php include __DIR__.'/include/header.php'; ?>

    <div class="dropdown">
        <div id="myDropdown" class="dropdown-content">
            <a href="#" data-remodal-target="profile" class="profile-ico">Profile</a>
            <a href="#" class="settings-ico">Settings<span class="notification-sign-yellow">!</span></a>
            <a href="logout.php" class="logout-ico">Log out</a>
        </div>
    </div>

    <aside id="index-sidebar">
        <div class="sidebar-header">
            <div id="logo">Eduscape CRM</div>
            <button id="close-nav" onclick="w3_close()">&times;</button>
        </div>

        <nav class="sidebar-nav">
            <button class="sidebar-dropdown-btn">menu
                <span class="sidebar-dropdown-icon">&#9660</span>
            </button>
            <div class="sidebar-dropdown-container">
                <a href="#">submenu</a>
                <a href="#">submenu</a>
            </div>
            <a href="#">menu</a>
            <a href="#">menu</a>
            <button class="sidebar-dropdown-btn">menu
                <span class="sidebar-dropdown-icon">&#9660</span>
            </button>
            <div class="sidebar-dropdown-container">
                <a href="#">submenu</a>
                <a href="#">submenu</a>
                <a href="#">submenu</a>
            </div>
            <a href="#">menu</a>
        </nav>

    </aside>

    <?php  include_once __DIR__ . '/include/ntf.php'; ?>

    <aside id="msg-sidebar">
        <div class="msg-sidebar-header">
            <div class="msg-close">&times;</div>
            <h2>Massages</h2>
        </div>
        <div class="msg-sidebar-content">

        </div>
    </aside>

    <?php include_once __DIR__ . '/include/addSidebar.php'; ?>

    <section id="content">

        <?php

        $calendar = new Calendar();

        if (isset($_GET['type']) and !empty($_GET ['type'])){

            $type = $_GET ['type'];

            if($type == 'week'){

                include_once __DIR__ . '/include/calendar/week.php';

            }elseif ($type == 'day'){

                include_once __DIR__ . '/include/calendar/day.php';

            }else{

                //TODO SOMETHING

            }

        }else{

            include_once __DIR__ . '/include/calendar/month.php';

        }

        ?>

    </section>

    <footer id="footer"></footer>


    <div class="flash-msg <?php if(Session::exists('home')){ echo 'show-msg';} ?>">
        <?php if(Session::exists('home')) { echo Session::flash('home'); } ?>
    </div>

    <!-- Remodals -->

        <?php

        include_once __DIR__ . '/include/newEmployee.php';

        include_once __DIR__ . '/include/newLead.php';

        include_once __DIR__ . '/include/newCustomer.php';

        include_once __DIR__ . '/include/newContact.php';

        include_once __DIR__ . '/include/newEvent.php';

        include_once __DIR__ . '/include/newWorkshop.php';

        include_once __DIR__ . '/include/newItem.php';

        include_once __DIR__ . '/include/infoProfile.php';

        include __DIR__ . '/include/scripts.php';


        ?>

    </body>
    <script>
        $('.tags').tagify({
            whitelist: [<?php echo $tagOptions ?>],
            enforceWhitelist: true,
            autoComplete: true
        });

        $('#calendar').addClass('link-selected');
    </script>
    </html>

    <?php

}else{

    Redirect::to('index.php');

}