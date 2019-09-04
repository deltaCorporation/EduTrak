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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    </head>
    <body>

    <?php include __DIR__.'/include/header.php'; ?>

    <div class="dropdown">
        <div id="myDropdown" class="dropdown-content">
            <a href="#" data-remodal-target="profile" class="profile-ico">Profile</a>
            <a href="#" class="settings-ico">Settings</a>
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
    <div id="board-wrapper">

        <!-- DASHBOARD HEADER START -->
        <div id="index-board-header" class="index-board-block block-1">
            <div></div>
            <div>
                <span><?php echo date("l" ); ?></span>
                <span><?php echo date("F j"); ?></span>
                <span><?php echo date("S"); ?></span>
            </div>
            <ul>
                <li>
                    <button data-link="main" type="button" onclick="changeDashboard('main', this)"><i class="fas fa-th-list"></i></button>
                </li>
                <?php if($user->hasPermission('sales')): ?>
                    <li>
                        <button data-link="kanban" type="button" onclick="changeDashboard('kanban', this)"><i class="fab fa-trello"></i></button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- DASHBOARD HEADER END -->

        <section data-type="kanban" id="kanban-board" class="board">

            <?php foreach ($user->getKanbanColumns($user->data()->section) as $column): ?>

            <section data-id="<?php echo $column->ID ?>" data-kanban="column" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h4 data-kanban="header"><?php echo $column->name ?></h4>
                <button class="kanban-new-request" data-kanban="new-request" data-request-status="<?php echo $column->ID ?>">
                    <i class="fas fa-plus"></i>
                </button>
                <?php foreach ($user->getKanbanRequests($column->ID, $user->data()->id) as $item): ?>
                    <div id="<?php echo $item->ID ?>" data-kanban="item" draggable="true" ondragstart="drag(event)">
                        <a href="request.php?case=<?php echo $item->leadID ? 'lead' : 'customer' ?>&id=<?php echo $item->ID ?>">
                            <div data-kanban="item-header" ><?php echo $item->title ?></div>
                            <div data-kanban="item-footer" >
                                <span><?php echo $item->leadCompany ? $item->leadCompany : $item->customerCompany ?></span>
                                <span><?php echo $item->leadCompany ? '<i class="far fa-dot-circle"></i>' : '<i class="fas fa-dollar-sign"></i>' ?></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </section>

            <?php endforeach; ?>
        </section>

        <section data-type="main" id="index-board" class="board">

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
                                <a href='info.php?case=<?php echo $company->caseName ?>&id=<?php echo $company->ID ?>' class='index-board-followUp-item'>
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

    </div>

    <footer id="footer">

    </footer>

    <div class="overlay"></div>
    <div class="flash-msg <?php if(Session::exists('home')){ echo 'show-msg';} ?>">
        <?php

        if(Session::exists('home')) {

            echo Session::flash('home');
        }
            ?>

    </div>

    <!-- NEW REQUEST POPUP -->

    <div data-kanban="new-request-popup">
        <div class="request-popup-header">
            <h2>Create Request</h2>
            <div>
                <button class="request-popup-close"></button>
            </div>
        </div>
        <form class="request-popup-content">
            <div class="request-popup-section">
                <label for="request-title">Request Title</label>
                <input data-new-request="title" required id="request-title" type="text" name="title">
            </div>
            <div class="request-popup-section">
                <label for="request-title">Lead/Customer Name</label>
                <select data-new-request="company" id="company-select" class="js-example-basic-single">
                    <?php foreach ($user->getAllCompanies() as $company): ?>
                        <option value="<?php echo $company->ID ?>-<?php echo $company->caseName ?>"><?php echo $company->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" data-new-request="status" value="">
            <div class="request-popup-footer">
                <button id="add-request" type="button"><i class="fa-spin fas fa-spinner"></i>Create</button>
            </div>
        </form>
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
    <?php include __DIR__ . '/include/scripts.php'; ?>
    <script>

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        $('.tags').tagify({
            whitelist: [<?php echo $tagOptions ?>],
            enforceWhitelist: true,
            autoComplete: true
        });

        $('#home').addClass('link-selected');

        <?php if($user->hasPermission('sales')): ?>
            $("button[data-link='kanban']").click();
        <?php else: ?>
            $("button[data-link='main']").click();
        <?php endif; ?>
    </script>
    </html>



    <?php


}else{

    require_once __DIR__ . '/login.php';

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="google-site-verification" content="Q7P8qM_XSFxL5aBL7WN4AsxdqsI7CPrZcnGNY52Kr0Y" />
        <title>EduTrak | Login page</title>

        <link rel="shortcut icon" type="image/x-icon" href="https://eduscape.com/wp-content/uploads/2017/04/edu-favicon.jpg">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/login-style.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

    <section class="left-sec">
        <div class="image-cover"></div>
    </section>

    <section class="right-sec">
        <div id="login">
            <h1 class="title">EduTrak</h1>
            <form action="" method="post">
                    <div class="login-field">
                        <input type="text" name="email" id="email" autocomplete="off" value="<?php echo Input::get('email')?>" placeholder="Your email address">
                        <div><?php if(isset($loginErrors['email'])) echo $loginErrors['email']; ?></div>
                    </div>
                    <div class="login-field">
                        <input type="password" name="password" id="password" placeholder="Your password">
                        <div><?php if(isset($loginErrors['password'])) echo $loginErrors['password']; ?></div>
                    </div>
<!--                    <label class="remember-me" for="remember">-->
<!--                        <input type="checkbox" name="remember" id="remember"> Remember me-->
<!--                    </label>-->
                    <div class="login-submit">
                        <input type="hidden" name="token" value="<?php echo Token::generateLogin(); ?>">
                        <input type="submit" value="Login">
                    </div>
            </form>
        </div>

    </section>

    </body>
    </html>
<?php

}

	
?>