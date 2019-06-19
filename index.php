<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

// ********************************************************  //
// Get these values from https://console.developers.google.com
// Be sure to enable the Analytics API
// ********************************************************    //
$client_id = '79089015940-tgbv8mgfkf0vahefgo35r0hevlflig3g.apps.googleusercontent.com';
$client_secret = 'zqkm4eq_B6wFkmHz1s7EJvt7';
$redirect_uri = 'http://localhost:8888/EduTrak/index.php';

$client = new Google_Client();
$client->setApplicationName("Client_Library_Examples");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType('offline');   // Gets us our refreshtoken

$client->setScopes(array('https://www.googleapis.com/auth/calendar.readonly'));

if (isset($_GET['code'])) {

    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

$user = new User();


if($user->isLoggedIn()){
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    
        <meta charset="UTF-8">
        <title>EduTrak</title>

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/style.css" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/remodal.css" rel="stylesheet">
        <link href="view/css/remodal-default-theme.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
            <div id="logo">EduTrak</div>
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

    <?php include_once __DIR__ . '/include/ntf.php'; ?>
    <aside id="msg-sidebar">
        <div class="msg-sidebar-header">
            <div class="msg-close">&times;</div>
            <h2>Massages</h2>
        </div>
        <div class="msg-sidebar-content">

        </div>
    </aside>

    <?php

include_once __DIR__ . '/include/addSidebar.php';

?>

    <section id="index-board">
        <div id="index-board-header" class="index-board-block block-1">
            <div>

            </div>
            <div>
                <span>
                    <?php echo date("l" ); ?>
                </span>
                <span>
                    <?php echo date("F j"); ?>
                </span>
                <span>
                    <?php echo date("S"); ?>
                </span>
            </div>
        </div>
        <div id="index-board-followUp" class="index-board-block block-2">
            <h3>
                <div></div>
                <div>Follow Up Companies</div>
            </h3>
            <div id="index-board-followUp-content">

                <?php

                    $leads = new Lead();
                    $i = 0;

                    foreach ($leads->getLeads() as $lead){
                        if($lead->followUpDate > date('Y-m-d')){

                            $date = strtotime($lead->followUpDate);
                            $remaining = $date - time();

                            $daysLeft = ceil($remaining / 86400);

                            if($daysLeft == 0){
                                $daysLeft = 'Today';
                            }else{
                                $daysLeft = 'days left: ' . $daysLeft;
                            }

                            echo "
                            
                                <a href='info.php?case=lead&id={$lead->id}' class='index-board-followUp-item'>
                                    <div>{$lead->company}</div>
                                    <div>{$daysLeft}</div>
                                </a>
                            
                            ";

                            $i++;
                        }
                    }

                if ($i == 0){
                    echo '

                                    <div style="display: grid; padding: .5rem 0; text-align: center">
                                        <span style="display: grid; align-items: center; color: grey; font-size: .9rem">No Companies to Follow up</span>
                                    </div>';
                }

                ?>

            </div>
        </div>
        <div id="index-board-upcoming-events" class="index-board-block block-2">
            <h3>
                <div></div>
                <div>Upcoming events</div>
            </h3>
            <div id="index-board-upcoming-events-content">

                <?php

                    $events = new Event();
                    $i = 0;

                    if($events->getEvents()) {
                        foreach ($events->getUpcomingEvents() as $event) {

                            $newDate = date("Ymd", strtotime($event->date));

                            if($newDate >= date('Ymd')){
                                    if($i < 5){
                                        echo"
                                            <div class='index-board-last-event-wrapper'>
                                                <a href='info.php?case=customer&id=".$event->customerID."&tab=event'>
                                                    <div>
                                                        <div class='index-board-event-customer'>".$event->name."</div>
                                                        <div class='index-board-event-workshop'>".$event->workshopTitle."</div>
                                                    </div>
                                                    <div class='index-board-event-instructors'>";

                                                            foreach ($events->getInstructors($event->id) as $instructor){
                                                                echo "<div>".$instructor->firstName. " " .$instructor->lastName. "</div>";
                                                            }


                                                            echo "</div>
                                                    <div class='index-board-event-info-bar'>
                                                       
                                                        <div class='index-board-event-date'>
                                                            <div></div>
                                                            <div>".date("m-d-Y", strtotime($event->date))."</div>
                                                        </div>
                                                        
                                                        <div class='index-board-event-attendees'>
                                                            <div></div>
                                                            <div>".$event->attendeesNumber."</div>
                                                        </div>
                                                        <div class='event-status-".$event->statusID." index-board-event-status'>
                                                            <div></div>
                                                            <div>".$event->status."</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            ";

                                        $i++;

                                    }
                                }
                            }

                            if($i == 0){
                                echo '

                                    <div style="display: grid; padding: .5rem 0; text-align: center">
                                        <span style="display: grid; align-items: center; color: grey; font-size: .9rem">No events</span>
                                    </div>';
                            }

                        }else{
                        echo '

                                    <div style="display: grid; padding: .5rem 0; text-align: center">
                                        <span style="display: grid; align-items: center; color: grey; font-size: .9rem">No events</span>
                                    </div>';
                    }


                ?>

            </div>
        </div>
        <div id="index-board-last-events" class="index-board-block block-2">
            <h3>
                <div></div>
                <div>Recently added events</div>
            </h3>
            <div id="index-board-last-events-content">
                <?php

                $events = new Event();
                $i = 0;

                if($events->getEvents()){
                    foreach ($events->getEvents() as $event){

                        if($i < 5){
                            echo"
                        <div class='index-board-last-event-wrapper'>
                            <a href='info.php?case=customer&id=".$event->customerID."&tab=event'>
                                <div>
                                    <div class='index-board-event-customer'>".$event->name."</div>
                                    <div class='index-board-event-workshop'>".$event->workshopTitle."</div>
                                </div>
                                <div class='index-board-event-instructors'>";

                            foreach ($events->getInstructors($event->id) as $instructor){
                                echo "<div>".$instructor->firstName. " " .$instructor->lastName. "</div>";
                            }


                            echo "</div>
                                <div class='index-board-event-info-bar'>
                                   
                                    <div class='index-board-event-date'>
                                        <div></div>
                                        <div>".date("m-d-Y", strtotime($event->date))."</div>
                                    </div>
                                    
                                    <div class='index-board-event-attendees'>
                                        <div></div>
                                        <div>".$event->attendeesNumber."</div>
                                    </div>
                                    <div class='event-status-".$event->statusID." index-board-event-status'>
                                        <div></div>
                                        <div>".$event->status."</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        ";
                        }elseif ($i == 0){
                            echo '

                                    <div style="display: grid; padding: .5rem 0; text-align: center">
                                        <span style="display: grid; align-items: center; color: grey; font-size: .9rem">No events</span>
                                    </div>';
                        }

                        $i++;

                    }
                }else{
                    echo '

                                    <div style="display: grid; padding: .5rem 0; text-align: center">
                                        <span style="display: grid; align-items: center; color: grey; font-size: .9rem">No events</span>
                                    </div>';
                }

                ?>
            </div>
        </div>
        <div class="index-board-block block-2"></div>
        <div class="index-board-block block-3"></div>
        <div class="index-board-block block-3"></div>
        <div class="index-board-block block-3"></div>
    </section>

    <footer id="footer">

    </footer>


    <div class="flash-msg <?php if(Session::exists('home')){ echo 'show-msg';} ?>">
        <?php

        if(Session::exists('home')) {

            echo Session::flash('home');
        }
            ?>

    </div>





    <!-- Remodals -->

    <?php

        include_once __DIR__ . '/include/newEmployee.php';

        include_once __DIR__ . '/include/newLead.php';

        include_once __DIR__ . '/include/newCustomer.php';

        include_once __DIR__ . '/include/newContact.php';

        include_once __DIR__ . '/include/newEvent.php';

        include_once __DIR__ . '/include/newItem.php';

        include_once __DIR__ . '/include/infoProfile.php';

        include_once __DIR__ . '/include/newHardware.php';

    ?>

    </body>
    <script>
        $('#home').addClass('link-selected');
    </script>
    </html>

    

    <?php

include __DIR__ . '/include/scripts.php';

}else{

    require_once __DIR__ . '/login.php';

    ?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EduTrak | Login page</title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/login-style.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

    <section class="left-sec">
        <div class="image-cover">

            <img id="logo" src="view/img/Edu%20Man%20white.png">

            <h1 class="title">Welcome to <br> EduTrak</h1>

            <p class="text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas non porttitor sem, a tempor dui.
                Aenean sagittis faucibus nisl, eu tempus felis elementum quis. Pellentesque dapibus eu tellus nec viverra.
                Sed sit amet nisl ut massa malesuada consequat. Maecenas hendrerit orci risus, et lacinia eros sagittis nec.

            </p>

        </div>
    </section>

    <section class="right-sec">

        <div class="tab">
            <a class="tablinks" onclick="openCity(event, 'login')" id="defaultOpen">Login</a>
        </div>

        <form action="" method="post">
            <div id="login" class="tabcontent">
                <div class="login-left">
                    <h2>We will need...</h2>
                    <div class="login-form">
                        <div class="login-forms">
                            <div class="login-field">
                                <input type="text" name="email" id="email" autocomplete="off" value="<?php echo Input::get('email')?>" placeholder="Your email address">
                                <div><?php if(isset($loginErrors['email'])) echo $loginErrors['email']; ?></div>
                            </div>
                            <div class="login-field">
                                <input type="password" name="password" id="password" placeholder="Your password">
                                <div><?php if(isset($loginErrors['password'])) echo $loginErrors['password']; ?></div>
                            </div>
                            <label class="remember-me" for="remember">
                                <input type="checkbox" name="remember" id="remember"> Remember me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="login-middle">
                    <div class="vertical-line"></div>
                    <div class="login-middle-text">Or</div>
                    <div class="vertical-line"></div>
                </div>

                <div class="login-right">
                    <h2>Also You can...</h2>
                    <div class="login-google">
                        <button type="button">
                            Contact us for more information
                        </button>
                    </div>
                </div>
                <div class="login-submit">
                    <input type="hidden" name="token" value="<?php echo Token::generateLogin(); ?>">
                    <input type="submit" value="Login">
                </div>
            </div>
        </form>

    </section>

    </body>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "grid";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
    
    
    

    </html>
<?php
include __DIR__ . '/include/scripts.php';




}

	
?>