<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/google/vendor/autoload.php';

$client = new Google_Client();



$client->setAuthConfig('client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setAccessType("offline");

$user = new User();
$calendar = new Calendar();

if($user->isLoggedIn()){
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CRM</title>

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/style.css" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/remodal.css" rel="stylesheet">
        <link href="view/css/remodal-default-theme.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="view/js/remodal.js"></script>



    </head>
    <body>

    <header id="header">
        <button id="open-nav" onclick="w3_open()">&#9776;</button>
        <li>
            <a href="index.php" class="tooltip">
<i class="fas fa-home"></i>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <a href="calendar.php" class="link-selected tooltip">
<i class="far fa-calendar-alt"></i>
                <span class="tooltiptext">Calendar</span>
            </a>
            <?php

            if ($user->hasPermission('superAdmin')){
            echo '
              <a href="employees.php" class="tooltip">
<i class="fas fa-users"></i>
                <span class="tooltiptext">Employees</span>
            </a>

            
            ';


            } ?>
            <a href="leads.php" class="tooltip">
<i class="far fa-dot-circle"></i>
                <span class="tooltiptext">Leads</span>
            </a>
            <a href="contacts.php" class="tooltip">
<i class="far fa-address-book"></i>
                <span class="tooltiptext">Contacts</span>
            </a>
            <a href="customers.php" class="tooltip">
<i class="fas fa-dollar-sign"></i>
                <span class="tooltiptext">Customers</span>
            </a>
<a href="inventory.php" class="tooltip">
<i class="fas fa-boxes"></i>
                <span class="tooltiptext">Inventory</span>
            </a>
        </li>
       <form class="search" action="#" method="get">
            <input id="txt1" class="search-input" type="text" name="search" placeholder="Search" onkeyup="showHint(this.value)">


            <div id="txtHint" class="search-box">

        </div>

        <script>
		function showHint(str) {
		  var xhttp;
		  if (str.length == 0) {
		    document.getElementById("txtHint").innerHTML = "";
		    return;
		  }
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		      document.getElementById("txtHint").innerHTML = this.responseText;
		    }
		  };
		  xhttp.open("GET", "search.php?q="+str, true);
		  xhttp.send();
		}
		</script>
		        </form>
        <div class="tooltip msg-open">
<i class="fas fa-envelope"></i>
            <span class="tooltiptext">Inbox</span>
        </div>
        <div class="tooltip ntf-open" id="ntf">
<i class="fas fa-bell">
				<?php

				$ntf = new Notification();

				$i = 0;

				foreach($ntf->getNotifications() as $ntf){
					if($ntf->userID == $user->data()->id && $ntf->seen == 0){
						$i++;
					}
				}

				if($i != 0){
					echo '<span class="ntf-count">'.$i.'</span>';
				}

			 ?>




</i>
            <span class="tooltiptext">Notifications</span>
        </div>
        <div class="tooltip add-open">
<i class="fas fa-plus-circle"></i>
            <span class="tooltiptext">Add</span>
        </div>
        <div class="profile">
            <div class="profile-name drop-menu" onclick="myFunction()"><?php echo escape($user->data()->firstName).' '.escape($user->data()->lastName)?></div>
            <div class="profile-image drop-menu" onclick="myFunction()" style="background: url('<?php echo 'view/img/profile/'.escape($user->data()->img) ?>') no-repeat center; background-size: 5vh;"></div>
        </div>
    </header>

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

    <?php

include_once __DIR__ . '/include/addSidebar.php';

?>

    <section id="content">


<?php

        $calendar = new Calendar();


if (isset($_GET['type']) and !empty($_GET ['type'])){


        $type = $_GET ['type'];

        if($type == 'week'){

            if(isset($_GET['month']) && isset($_GET['year']) && isset($_GET['day'])){
                if(!empty($_GET['month']) && !empty($_GET['year']) && !empty($_GET['day'])){
                    if($_GET['month'] > 12 || $_GET['month'] < 1 && $_GET['day'] > 31 || $_GET['day'] < 1) {
                        $month = date('n');
                        $year = date('Y');
                        $lastDay = date('j');
                    }else{
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                        $lastDay = $_GET['day'];
                    }
                }else{
                    $month = null;
                    $year = null;
                    $lastDay = null;
                }
            }else{
                $month = null;
                $year = null;
                $lastDay = null;
            }

            $calendar = new Calendar($month, $year);

            ?>


            <div id="calendar-wrapper">
                <div id="calendar-header">
                    <div class="calendar-title">
                        <div class="calendar-title-event"><?php echo $calendar->getFullMonth().' '.$calendar->getDay()?></div>
                        <div class="calendar-add-event">

                        </div>
                    </div>
                    <a href="?type=week&year=<?php echo $calendar->getPrevYearFromWeek($lastDay)?>&month=<?php echo $calendar->getPrevMonthFromWeek($lastDay) ?>&day=<?php echo $calendar->getPrevWeek($lastDay) ?>">
                        <i class="fas fa-caret-left fa-2x white"></i>
                    </a>
                    <h2><?php echo $calendar->getFullMonth() .' '. $calendar->getYear() ;

                        ?> </h2>
                    <a href="?type=week&year=<?php echo $calendar->getNextYearFromWeek($lastDay)?>&month=<?php echo $calendar->getNextMonthFromWeek($lastDay) ?>&day=<?php echo $calendar->getNextWeek($lastDay) ?>">
                        <i class="fas fa-caret-right fa-2x white"></i>
                    </a>
                    <div class="today-btn">
                        <a href="calendar.php?type=week">Today</a>
                    </div>
                    <div class="calendar-nav">
                        <a href="calendar.php" class="">Month</a>
                        <a href="calendar.php?type=week" class="current-view">Week</a>
                        <a href="calendar.php?type=day" class="">Day</a>


                    </div>
                </div>
                <div id="calendar-week-events">
                    <?php

                    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {




                        $client->setAccessToken($_SESSION['access_token']);

                        // Print the next 10 events on the user's calendar.
                        $calendarId = 'eduscapelearning.com_pddrarllh8a8jaj9p552tv6s9g@group.calendar.google.com';

                        $timeBack = date('Y') - 1;

			if($year == null && $month == null){
				$year = date('Y');
				$month = date('n');
			}

    $timeMin = $year.'-'.$month.'-1\Th:i:sP';

    $optParams = array(
        'maxResults' => 300,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date($timeMin),
    );

                        $service = new Google_Service_Calendar($client);
                        $results = $service->events->listEvents($calendarId, $optParams);
                        if (count($results->getItems()) == 0) {
                            print "No upcoming events found.\n";
                        } else {

                            $i = 0;

                            foreach ($results->getItems() as $event) {
                                $start = $event->start->dateTime;
                                $start = substr($start,0, -15);



                                if (empty($start)) {
                                    $start = $event->start->date;

                                }

                                if($calendar->getDay() < 10){
                                    if($calendar->getMonth() >= 10){
                                        $todayDate = $calendar->getYear().'-'.$calendar->getMonth().'-0'.$calendar->getDay();
                                    }else{
                                        $todayDate = $calendar->getYear().'-0'.$calendar->getMonth().'-0'.$calendar->getDay();
                                    }
                                }else{
                                    if($calendar->getMonth() >= 10){
                                        $todayDate = $calendar->getYear().'-'.$calendar->getMonth().'-'.$calendar->getDay();
                                    }else{
                                        $todayDate = $calendar->getYear().'-0'.$calendar->getMonth().'-'.$calendar->getDay();
                                    }
                                }




                                if($start == $todayDate){
                                    echo "
                            <div class=\"calendar-month-event\">";

		if(is_numeric($event->getDescription())){
			echo "
			
			<a href='info.php?case=customer&id=".$event->getDescription()."' class=\"calendar-month-event-title\">
				<i class=\"fas fa-calendar-alt\"></i>".$event->getSummary()."
			</a>
			
			";
		}else{
			echo "
			
			<div class=\"calendar-month-event-title\">
				<i class=\"fas fa-calendar-alt\"></i>".$event->getSummary()."
			</div>
			
			";
		}

    echo "<div class=\"calendar-month-event-time\"><i class=\"far fa-clock\"></i>".$calendar->eventStartTime($event->start->dateTime)." - ".$calendar->eventEndTime($event->end->dateTime)."</div>
    <div class=\"calendar-month-event-desription\">";

    if(!is_numeric($event->getDescription())){
    	echo $event->getDescription();
    }

    echo "</div>
</div>
";

                        $i++;
                                }




                            }

                            if($i == 0){
                                echo "<div class=\"calendar-month-event-title\">No events for today</div>";
                            }


                        }



                    }else{
                        echo '<span>Please login with your google account</span>';
                    }

                    ?>
                </div>
                <div id="calendar-week-header">
                    <div class="calendar-week-day-title"></div>

                    <?php

                    foreach ($calendar->getWeek($lastDay) as $day){


                                if ($day['day'] == date('j') && $calendar->getMonth() == date('n')) {
                                    echo "<div class='calendar-week-day-title calendar-week-today-day'>" . date('D', mktime(0, 0, 0, $day['month'], $day['day'], $day['year'])) . "</div>";
                                } else {
                                    echo "<div class='calendar-week-day-title'>" . date('D', mktime(0, 0, 0, $day['month'], $day['day'], $day['year'])) . "</div>";
                                }




                    }

                    ?>

                    <div class="calendar-week-day-title"></div>


                    <?php






                    foreach ($calendar->getWeek($lastDay) as $day){

                        if($day['day'] == date('j') && $day['month'] == date('n')){
                            echo "<div class='calendar-week-day-num calendar-week-today-day'>{$day['day']}</div>";
                        }else{
                            echo "<div class='calendar-week-day-num'>{$day['day']}</div>";
                        }

                    }





                    ?>



                </div>
                <div id="calendar-week-content">

                <div class="calendar-week-all-day-events">

                        <div class='calendar-week-all-day-event'></div>


                        <?php

                        foreach ($calendar->getWeek($lastDay) as $day){
                            echo "<div class='calendar-week-all-day-event'>";

                                        foreach ($results->getItems() as $event) {
				        	$start = $event->start->dateTime;
				                $start = substr($start,0, -15);

				                $weekDay = substr($event->start->dateTime,0,10);



						if (empty($start)) {
				                	$start = $event->start->date;
				                	$weekDay = substr($event->start->date,0,10);
						}

						if($weekDay == $day['year'].'-'.$day['month'].'-'.$day['day']){

							if (empty($event->start->dateTime)) {
								echo "<div>".$event->getSummary()."</div>";
							}

						}
						}

                                    echo "</div>";
                        }

                        ?>

                    </div>

                    <div class="calendar-week-aside">

                        <?php

                            for ($i = 1; $i <= 12; $i++ ){
                                echo " <div class='calendar-week-time'>{$i}am</div>";
                            }

                            for ($i = 1; $i <= 11; $i++ ){
                                echo " <div class='calendar-week-time'>{$i}pm</div>";
                            }

                        ?>

                    </div>


                    <?php

                    function setEvent($start, $end){
                        $location['top'] = substr($start, 11, 2) * 7;

                        $location['day'] = substr($start, 0, 10);

                        if(substr($start, 14, 2) != 0){
                            $location['top'] += 3.4;
                        }

                        $location['height'] = substr($end, 11, 2) * 7 - $location['top'];

                        if(substr($end, 14, 2) != 0){
                            $location['height'] += 3.5;
                        }


                        return $location;

                    }

                        for($i = $day['day']-6; $i <= $day['day']; $i++){
                            echo "<div class='calendar-week-day'>
                                    <div class='calendar-week-events'>
                                ";

                                foreach ($results->getItems() as $event) {
			        	$start = $event->start->dateTime;
			                $start = substr($start,0, -15);

			                $weekDay = substr($event->start->dateTime,0,10);

					if (empty($start)) {
			                	$start = $event->start->date;
			                	$weekDay = substr($event->start->date,0,10);
					}



						if(!empty($event->start->dateTime)){
							if(setEvent($event->start->dateTime, $event->end->dateTime)['day'] == $day['year'].'-'.$day['month'].'-'.$i){
								echo "<div class='week-event'style='
							            height:".setEvent($event->start->dateTime, $event->end->dateTime)['height'].'vh'.";
							            top: ".setEvent($event->start->dateTime, $event->end->dateTime)['top'].'vh'."
							            '>".$event->getSummary()."</div>";
							}
						}



				}





                            for($j = 1; $j <= 24; $j++){
                                echo "<div class='calendar-week-cell'></div>";
                            }

                            echo "</div></div>";
                        }

                    ?>

                </div>
            </div>

<?php

        }elseif ($type == 'day'){

            if(isset($_GET['month']) && isset($_GET['year']) && isset($_GET['day'])){
                if(!empty($_GET['month']) && !empty($_GET['year']) && !empty($_GET['day'])){
                    if($_GET['month'] > 12 || $_GET['month'] < 1 || $_GET['day'] > 31 || $_GET['day'] < 1) {
                        $month = date('n');
                        $year = date('Y');
                        $day = date('j');
                    }else{
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                        $day = $_GET['day'];
                    }
                }else{
                    $month = date('n');
                    $year = date('Y');
                    $day = date('j');
                }
            }else{
                $month = date('n');
                $year = date('Y');
                $day = date('j');
            }

            $calendar = new Calendar($month, $year, $day);

            ?>

<div id="calendar-wrapper">
    <div id="calendar-header">
        <div class="calendar-title">
            <div class="calendar-title-event"><?php echo $calendar->getFullMonth().' '.$calendar->getDay()?></div>
            <div class="calendar-add-event">

            </div>
        </div>
        <a href="?type=day&year=<?php echo $calendar->getPrevYearFromDay()?>&month=<?php echo $calendar->getPrevMonth($calendar->getDay())?>&day=<?php echo $calendar->getPrevDay() ?>">
            <i class="fas fa-caret-left fa-2x white"></i>
        </a>
        <h2><?php echo $calendar->getFullMonth() .' '. $calendar->getYear() ;

            ?></h2>
        <a href="?type=day&year=<?php echo $calendar->getNextYearFromDay()?>&month=<?php echo $calendar->getNextMonth($calendar->getDay())?>&day=<?php echo $calendar->getNextDay() ?>">
            <i class="fas fa-caret-right fa-2x white"></i>
        </a>
        <div class="today-btn">
            <a href="calendar.php?type=day">Today</a>
        </div>
        <div class="calendar-nav">
            <a href="calendar.php" class="">Month</a>
            <a href="calendar.php?type=week" class="">Week</a>
            <a href="calendar.php?type=day" class="current-view">Day</a>


        </div>
    </div>
    <div id="calendar-day-events">
        <?php

                    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {




                        $client->setAccessToken($_SESSION['access_token']);

                        // Print the next 10 events on the user's calendar.
                        $calendarId = 'eduscapelearning.com_pddrarllh8a8jaj9p552tv6s9g@group.calendar.google.com';

                        $timeBack = date('Y') - 1;

    $timeMin = $year.'-'.$month.'-1\Th:i:sP';

    $optParams = array(
        'maxResults' => 300,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date($timeMin),
    );
                        $service = new Google_Service_Calendar($client);
                        $results = $service->events->listEvents($calendarId, $optParams);
                        if (count($results->getItems()) == 0) {
                            print "No upcoming events found.\n";
                        } else {

                            $i = 0;

                            foreach ($results->getItems() as $event) {
                                $start = $event->start->dateTime;
                                $start = substr($start,0, -15);




                                if (empty($start)) {
                                    $start = $event->start->date;

                                }

                                if($calendar->getDay() < 10){
                                    if($calendar->getMonth() >= 10){
                                        $todayDate = $calendar->getYear().'-'.$calendar->getMonth().'-0'.$calendar->getDay();
                                    }else{
                                        $todayDate = $calendar->getYear().'-0'.$calendar->getMonth().'-0'.$calendar->getDay();
                                    }
                                }else{
                                    if($calendar->getMonth() >= 10){
                                        $todayDate = $calendar->getYear().'-'.$calendar->getMonth().'-'.$calendar->getDay();
                                    }else{
                                        $todayDate = $calendar->getYear().'-0'.$calendar->getMonth().'-'.$calendar->getDay();
                                    }
                                }




                                if($start == $todayDate){
                                    echo "
                            <div class=\"calendar-month-event\">";

		if(is_numeric($event->getDescription())){
			echo "
			
			<a href='info.php?case=customer&id=".$event->getDescription()."' class=\"calendar-month-event-title\">
				<i class=\"fas fa-calendar-alt\"></i>".$event->getSummary()."
			</a>
			
			";
		}else{
			echo "
			
			<div class=\"calendar-month-event-title\">
				<i class=\"fas fa-calendar-alt\"></i>".$event->getSummary()."
			</div>
			
			";
		}

    echo "<div class=\"calendar-month-event-time\"><i class=\"far fa-clock\"></i>".$calendar->eventStartTime($event->start->dateTime)." - ".$calendar->eventEndTime($event->end->dateTime)."</div>
    <div class=\"calendar-month-event-desription\">";

    if(!is_numeric($event->getDescription())){
    	echo $event->getDescription();
    }

    echo "</div>
</div>
";

                        $i++;
                                }




                            }

                            if($i == 0){
                                echo "<div class=\"calendar-month-event-title\">No events for today</div>";
                            }


                        }



                    }else{
                        echo '<span>Please login with your google account</span>';
                    }

                    ?>
    </div>
    <div id="calendar-day-header">
        <div class="calendar-day-day-title"><?php echo $calendar->getFullDay() ?></div>

        <div class="calendar-day-day-num"><?php echo $calendar->getDay() ?></div>
    </div>
    <div id="calendar-day-content">
        <div class="all-day-events">

        <?php

        	foreach ($results->getItems() as $event) {
        	$start = $event->start->dateTime;
                $start = substr($start,0, -15);

		if (empty($start)) {
                	$start = $event->start->date;
		}

		if($start == $todayDate){

			if(empty($event->start->dateTime)){
				echo "<div>".$event->getSummary()."</div>";
			}

		}

	}

        ?>


        </div>
        <div class="calendar-day-aside">
            <?php

            for ($i = 1; $i <= 12; $i++ ){
                echo " <div class='calendar-week-time'>{$i}am</div>";
            }

            for ($i = 1; $i <= 11; $i++ ){
                echo " <div class='calendar-week-time'>{$i}pm</div>";
            }

            ?>
        </div>

        <?php

        echo "<div class='calendar-day-events'>";

        function setEvent($start, $end){
                $location['top'] = substr($start, 11, 2) * 7;

                if(substr($start, 14, 2) != 0){
                    $location['top'] += 3.5;
                }

                $location['height'] = substr($end, 11, 2) * 7 - $location['top'];

                if(substr($end, 14, 2) != 0){
                    $location['height'] += 3.5;
                }

                return $location;

            }

        foreach ($results->getItems() as $event) {
        	$start = $event->start->dateTime;
                $start = substr($start,0, -15);

		if (empty($start)) {
                	$start = $event->start->date;
		}

		if($start == $todayDate){

			if(!empty($event->start->dateTime)){
				echo "<div class='day-event'style='
			            height:".setEvent($event->start->dateTime, $event->end->dateTime)['height'].'vh'.";
			            top: ".setEvent($event->start->dateTime, $event->end->dateTime)['top'].'vh'."
			            '>".$event->getSummary()."</div>";
			}

		}

	}


            for($j = 1; $j <= 24; $j++){
                echo "

                        <div class='calendar-day-cell'></div>
                        
                        ";
            }

            echo "</div>";


        ?>


    </div>
</div>


<?php

        }else {



        }

}else{

    if(isset($_GET['month']) && isset($_GET['year'])){
        if(!empty($_GET['month']) && !empty($_GET['year'])){
            if($_GET['month'] > 12 || $_GET['month'] < 1) {
                $month = date('n');
                $year = date('Y');
                $day = 1;
            }else{
                $month = $_GET['month'];
                $year = $_GET['year'];
                $day = $_GET['day'];
            }
        }else{
            $month = date('n');
                $year = date('Y');
                $day = date('j');
        }
    }else{
        $month = date('n');
                $year = date('Y');
                $day = date('j');
    }

    $calendar = new Calendar($month, $year, $day);

?>

<div id="calendar-wrapper">
    <div id="calendar-header">
        <div class="calendar-title">
            <div class="calendar-title-event"><?php echo $calendar->getFullMonth().' '.$calendar->getDay()?></div>
            <div class="calendar-add-event">

            </div>
        </div>
        <a href="?day=1&month=<?php echo $calendar->getPrevMonth(); ?>&year=<?php echo $calendar->getPrevYear(); ?>">
            <i class="fas fa-caret-left fa-2x white"></i>
        </a>
        <h2> <?php echo $calendar->getFullMonth() .' '. $calendar->getYear() ;

            ?>
        </h2>
        <a href="?day=1&month=<?php echo $calendar->getNextMonth(); ?>&year=<?php echo $calendar->getNextYear(); ?>">
            <i class="fas fa-caret-right fa-2x white"></i>
        </a>
        <div class="today-btn">
            <a href="calendar.php">Today</a>
        </div>
        <div class="calendar-nav">
            <a href="calendar.php" class="current-view">Month</a>
            <a href="calendar.php?type=week" class="">Week</a>
            <a href="calendar.php?type=day" class="">Day</a>
        </div>
    </div>
    <div id="calendar-month-events">

        <?php
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            if($client->isAccessTokenExpired()) {
                session_destroy();
                header('Location: index.php');
            }
            $calendarId = 'eduscapelearning.com_pddrarllh8a8jaj9p552tv6s9g@group.calendar.google.com';



            $timeMin = $year.'-'.$month.'-1\Th:i:sP';
            $optParams = array(
                'maxResults' => 300,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date($timeMin),
            );
            $service = new Google_Service_Calendar($client);
            $results = $service->events->listEvents($calendarId, $optParams);
            if (count($results->getItems()) == 0) {
                print "No upcoming events found1.\n";
            } else {
                $i = 0;
                foreach ($results->getItems() as $event) {
                    $start = $event->start->dateTime;
                    $start = substr($start,0, -15);
                    if (empty($start)) {
                        $start = $event->start->date;
                    }
                    if($calendar->getDay() < 10){
                        if($calendar->getMonth() >= 10){
                            $todayDate = $calendar->getYear().'-'.$calendar->getMonth().'-0'.$calendar->getDay();
                        }else{
                            $todayDate = $calendar->getYear().'-0'.$calendar->getMonth().'-0'.$calendar->getDay();
                        }
                    }else{
                        if($calendar->getMonth() >= 10){
                            $todayDate = $calendar->getYear().'-'.$calendar->getMonth().'-'.$calendar->getDay();
                        }else{
                            $todayDate = $calendar->getYear().'-0'.$calendar->getMonth().'-'.$calendar->getDay();
                        }
                    }
                    if($start == $todayDate){
                        echo "
                            <div class=\"calendar-month-event\">";
                        if(is_numeric($event->getDescription())){
                            echo "
			
			<a href='info.php?case=customer&id=".$event->getDescription()."' class=\"calendar-month-event-title\">
				<i class=\"fas fa-calendar-alt\"></i>".$event->getSummary()."
			</a>
			
			";
                        }else{
                            echo "
			
			<div class=\"calendar-month-event-title\">
				<i class=\"fas fa-calendar-alt\"></i>".$event->getSummary()."
			</div>
			
			";
                        }
                        echo "<div class=\"calendar-month-event-time\"><i class=\"far fa-clock\"></i>".$calendar->eventStartTime($event->start->dateTime)." - ".$calendar->eventEndTime($event->end->dateTime)."</div>
    <div class=\"calendar-month-event-desription\">";

                        if(!is_numeric($event->getDescription())){
                            echo $event->getDescription();
                        }

                        echo "</div>
</div>
";
                        $i++;
                    }
                }
                if($i == 0){
                    echo "<div class=\"calendar-month-event-title\">No events for today2</div>";
                }
            }
        }else{
            echo '<span>Please login with your google account</span>';
        }
        ?>

    </div>

    <div id="calendar-month-sub-header">
        <div class="calendar-month-header-cell">Sun</div>
        <div class="calendar-month-header-cell">Mon</div>
        <div class="calendar-month-header-cell">Tue</div>
        <div class="calendar-month-header-cell">Wed</div>
        <div class="calendar-month-header-cell">Thu</div>
        <div class="calendar-month-header-cell">Fri</div>
        <div class="calendar-month-header-cell">Sat</div>
    </div>
    <div id="calendar-month-content">

        <?php

        foreach($calendar->allDays() as $key => $day) {

            $todayDay = '';

            if ($key <= 7 and $day >= 7) {
                $differentDay = 'different-day';
                if($day < 10){

                    if($calendar->getPrevMonth() >= 10){
                        $date = $calendar->getYear() . '-' . $calendar->getPrevMonth() . '-0' . $day;
                    }else{
                        $date = $calendar->getYear() . '-0' . $calendar->getPrevMonth() . '-0' . $day;
                    }


                }else{
                    if($calendar->getPrevMonth() >= 10){
                        $date = $calendar->getYear() . '-' . $calendar->getPrevMonth() . '-' . $day;
                    }else{
                        $date = $calendar->getYear() . '-0' . $calendar->getPrevMonth() . '-' . $day;
                    }
                }

                $monthLink = $calendar->getPrevMonth();

            } elseif ($key > 30 and $day < 12) {
                $differentDay = 'different-day';
                if($day < 10){

                    if($calendar->getNextMonth() >= 10){
                        $date = $calendar->getYear() . '-' . $calendar->getNextMonth() . '-0' . $day;
                    }else{
                        $date = $calendar->getYear() . '-0' . $calendar->getNextMonth() . '-0' . $day;
                    }


                }else{
                    if($calendar->getNextMonth() >= 10){
                        $date = $calendar->getYear() . '-' . $calendar->getNextMonth() . '-' . $day;
                    }else{
                        $date = $calendar->getYear() . '-0' . $calendar->getNextMonth() . '-' . $day;
                    }
                }

                $monthLink = $calendar->getNextMonth();

            } else {
                $differentDay = '';

                if($day < 10){

                    if($calendar->getMonth() >= 10){
                        $date = $calendar->getYear() . '-' . $calendar->getMonth() . '-0' . $day;
                    }else{
                        $date = $calendar->getYear() . '-0' . $calendar->getMonth() . '-0' . $day;
                    }

                }else{
                    if($calendar->getMonth() >= 10){
                        $date = $calendar->getYear() . '-' . $calendar->getMonth() . '-' . $day;
                    }else{
                        $date = $calendar->getYear() . '-0' . $calendar->getMonth() . '-' . $day;
                    }
                }

                if ($day == date('j')) {
                    if ($month == date('n')) {
                        $todayDay = 'today-day';
                    } elseif ($month == null) {
                        $todayDay = 'today-day';
                    }
                }

                $monthLink = $calendar->getMonth();

            }




            echo "

                            <a href='?day={$day}&month={$monthLink}&year={$calendar->getYear()}' class='calendar-cell $todayDay'>
                                <div class='calendar-day $differentDay'>
                                $day
                                    
                            
                            ";

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $k = 0;
            $j = 0;
            foreach ($results->getItems() as $event) {
                $start = $event->start->dateTime;
                $start = substr($start, 0, -15);


                if (empty($start)) {
                    $start = $event->start->date;

                }

                if($start == $date){

			if($k < 2){

		                    printf("
		                        <div class='calendar-month-event-cell'>
		    <i class=\"fas fa-circle\"></i>
		    %s</div>
		                    ", $event->getSummary());
			$k++;
			}
		$j++;
                }



            }

            if($j > 2){
            	echo '<div class="calendar-month-event-cell-more">'.($j-2).' more</div>';
            }



        }

            echo "       </div>
                            </a>";
        }
        ?>

    </div>
</div>


<?php
}

?>





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

include __DIR__ . '/include/scripts.php';

    ?>

    </body>
    </html>



    <?php

}else{

    Redirect::to('index.php');

}