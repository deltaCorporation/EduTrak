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
$client_id = '79089015940-4c5ahkbrnu9m81fsibtli29ltmiisrrc.apps.googleusercontent.com';
$client_secret = 'JrQJuDAfIqVuGoCECt7zqhZN';
$redirect_uri = 'http://localhost:8888/EduTrak/index.php';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType('offline');   // Gets us our refreshtoken
$client->setApprovalPrompt('force');

$client->setScopes(array('https://www.googleapis.com/auth/calendar'));

if (isset($_GET['code'])) {

    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

$user = new User();
$inventory = new Inventory();
$leads = new Lead();
$log = new ActivityLog();
$events = new Event();

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
        <meta name="google-site-verification" content="Q7P8qM_XSFxL5aBL7WN4AsxdqsI7CPrZcnGNY52Kr0Y" />
        <title>EduTrak</title>

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

        <!-- DASHBOARD HEADER START -->
        <div id="index-board-header" class="index-board-block block-1">
            <div></div>
            <div>
                <span><?php echo date("l" ); ?></span>
                <span><?php echo date("F j"); ?></span>
                <span><?php echo date("S"); ?></span>
            </div>
        </div>
        <!-- DASHBOARD HEADER END -->

        <!-- DASHBOARD ACTIVITY LOG START -->
        <div id="index-board-log" class="index-board-block block-3">
            <h3>
                <div></div>
                <div>Activity Log</div>
            </h3>
            <div id="index-board-log-content">
                <?php if($boardLogs = $log->getBoardActivityLog()): ?>
                    <?php foreach ($boardLogs as $key => $logs) : ?>

                        <div class="activity-log-section-board">
                            <h3><?php echo $key ?></h3>
                            <div class="activity-log-content-board">
                                <?php foreach ($logs as $log): ?>

                                    <?php

                                    $date = new DateTime($log['time'], new DateTimeZone('UTC'));
                                    $date->setTimezone(new DateTimeZone('America/New_York'));

                                    ?>

                                    <a href="info.php?case=<?php echo $log['case'] ?>&id=<?php echo $log['caseID'] ?>" class="activity-log-board">
                                        <span><?php echo $date->format('g:ia'); ?></span>
                                        <span style="background-color: #<?php echo $log['case'] === 'lead' ? '3e4a6e' : ($log['case'] === 'customer' ? 'e29a46' : '8ba65c') ?>"><?php echo $log['case'] ?></span>
                                        <span><?php echo $log['icon'] ?></span>
                                        <span><?php echo $log['userName'] ?></span>
                                        <span><?php echo $log['text'] ?></span>
                                        <span><?php echo $log['name'] ?></span>
                                    </a>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="dashboard-no-results">
                        <span>No logs</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- DASHBOARD ACTIVITY LOG END -->

        <!-- DASHBOARD FOLLOW UP START -->
        <div id="index-board-followUp" class="index-board-block block-5">
            <h3>
                <div></div>
                <div>Follow Up Companies/Schools</div>
            </h3>
            <div id="index-board-followUp-content">
                <?php if($companies = $leads->getFollowUpLeads()): ?>
                <?php $i = 0; ?>
                    <?php foreach ($companies as $company): ?>
                        <?php if($company->followUpDate > date('Y-m-d')): ?>
                            <a href='info.php?case=lead&id=<?php echo $company->ID ?>' class='index-board-followUp-item'>
                                <span style="background-color: #<?php echo $company->caseName === 'lead' ? '3e4a6e' : 'e29a46' ?>"><?php echo $company->caseName ?></span>
                                <span><?php echo $company->name ?></span>
                                <span><?php echo date('m/d/y', strtotime($company->followUpDate)) ?></span>
                            </a>
                        <?php $i++ ?>
                        <?php endif; ?>
                    <?php endforeach ?>
                    <?php if($i === 0): ?>
                        <div class="dashboard-no-results">
                            <span>No companies or schools to follow up</span>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="dashboard-no-results">
                        <span>No companies or schools to follow up</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- DASHBOARD FOLLOW UP END -->

        <!-- DASHBOARD UPCOMING EVENTS START -->
        <div id="index-board-upcoming-events" class="index-board-block block-4">
            <h3>
                <div></div>
                <div>Upcoming events</div>
            </h3>
            <div id="index-board-upcoming-events-content">

                <?php $i = 0; ?>

                <?php if($events->getEvents()): ?>
                    <?php foreach ($events->getUpcomingEvents() as $event): ?>
                        <?php $newDate = date("Ymd", strtotime($event->date)); ?>
                        <?php if($newDate >= date('Ymd')): ?>
                            <?php if($i < 5): ?>

                                <a href='info.php?case=customer&id=<?php echo $event->customerID ?>&tab=event' class='index-board-last-event-wrapper'>
                                    <div>
                                        <span><?php echo $event->name ?></span>
                                        <span><?php echo $event->workshopTitle ?></span>
                                        <div>
                                            <?php foreach ($events->getInstructors($event->id) as $instructor): ?>
                                                <span><?php echo $instructor->firstName. " " .$instructor->lastName; ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <span><?php echo date("m/d/y", strtotime($event->date)) ?></span>
                                        <span><?php echo (int)$event->attendeesNumber === 0 ? '' : 'Attendees: '. $event->attendeesNumber ?></span>
                                        <span class="event-status-<?php echo $event->statusID ?>"><?php echo $event->status ?></span>
                                    </div>
                                </a>

                                <?php $i++ ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if($i == 0): ?>
                        <div class="dashboard-no-results">
                            <span>No upcoming events</span>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="dashboard-no-results">
                        <span>No upcoming events</span>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- DASHBOARD UPCOMING EVENTS END -->

        <!-- DASHBOARD LAST EVENTS START -->
        <div id="index-board-last-events" class="index-board-block block-4">
            <h3>
                <div></div>
                <div>Recently added events</div>
            </h3>
            <div id="index-board-last-events-content">

                <?php $i = 0; ?>

                <?php if($events->getEvents()): ?>
                    <?php foreach ($events->getEvents() as $event): ?>
                        <?php if($i < 5): ?>

                            <a href='info.php?case=customer&id=<?php echo $event->customerID ?>&tab=event' class='index-board-last-event-wrapper'>
                                <div>
                                    <span><?php echo $event->name ?></span>
                                    <span><?php echo $event->workshopTitle ?></span>
                                    <div>
                                        <?php foreach ($events->getInstructors($event->id) as $instructor): ?>
                                            <span><?php echo $instructor->firstName. " " .$instructor->lastName; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div>
                                    <span><?php echo date("m/d/y", strtotime($event->date)) ?></span>
                                    <span><?php echo (int)$event->attendeesNumber === 0 ? '' : 'Attendees: '. $event->attendeesNumber ?></span>
                                    <span class="event-status-<?php echo $event->statusID ?>"><?php echo $event->status ?></span>
                                </div>
                            </a>

                            <?php $i++ ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if($i == 0): ?>
                        <div class="dashboard-no-results">
                            <span>No upcoming events</span>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="dashboard-no-results">
                        <span>No upcoming events</span>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- DASHBOARD LAST EVENTS START -->

        <div></div>
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
        $('.tags').tagify({
            whitelist: [<?php echo $tagOptions ?>],
            enforceWhitelist: true,
            autoComplete: true
        });

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
        <meta name="google-site-verification" content="Q7P8qM_XSFxL5aBL7WN4AsxdqsI7CPrZcnGNY52Kr0Y" />
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