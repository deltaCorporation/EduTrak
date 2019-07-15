<?php

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

            if (isset($_SESSION['token'])) {

                $client->setAccessToken($_SESSION['token']);

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