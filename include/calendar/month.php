<?php

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
        if (isset($_SESSION['token']))
        {
            $client->setAccessToken($_SESSION['token']);

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
            if (isset($_SESSION['token'])) {

                $client->setAccessToken($_SESSION['token']);
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