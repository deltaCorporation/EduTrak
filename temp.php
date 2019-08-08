<div id="index-board-followUp" class="index-board-block block-2">
    <h3>
        <div></div>
        <div>Follow Up Companies/Schools</div>
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

                $date = date('m/d/Y', strtotime($lead->followUpDate));

                echo "
                            
                                <a href='info.php?case=lead&id={$lead->id}' class='index-board-followUp-item'>
                                    <div>{$lead->company}</div>
                                    <div>{$date}</div>
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