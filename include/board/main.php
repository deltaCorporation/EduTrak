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