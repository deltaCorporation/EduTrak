<?php



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
                <?php echo $calendar->getFullMonth().' '.$calendar->getDay()?>
            </div>
            <a href="?type=day&year=<?php echo $calendar->getPrevYearFromDay()?>&month=<?php echo $calendar->getPrevMonth($calendar->getDay())?>&day=<?php echo $calendar->getPrevDay() ?>">
                <i class="fas fa-caret-left fa-2x white"></i>
            </a>
            <h2><?php echo $calendar->getFullMonth() .' '. $calendar->getYear();?></h2>
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

            if (isset($_SESSION['accessToken'])) {

                // Print the next 10 events on the user's calendar.
                $calendarId = $GLOBALS['config']['CALENDAR_ID'];

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
			
			<a href='info.php?case=customer&id=".$event->getDescription()."' class=\"calendar-month-event-title\">".$event->getSummary()."</a>
			
			";
                            }else{
                                echo "
			
			<div class=\"calendar-month-event-title\">".$event->getSummary()."</div>
			
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
        <div id="calendar-day-wrapper">
            <div id="calendar-day-sub-header">
                <span><?php echo $calendar->getDay() ?></span>
                <span><?php echo $calendar->getFullDay() ?></span>
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
    </div>

