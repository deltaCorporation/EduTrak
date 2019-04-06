<?php

$instructors = new User();

?>

<form action="addEvent.php" method="post" id="add-event-window" class="add-window">
    <div class="add-window-header event-bg-color">
        <div class="add-window-header-icon event-icon"></div>
        <div class="add-window-header-title">Create new event</div>
        <button type="button" class="add-window-close window-close"></button>
    </div>
    <div id="eventMainInfo" class="add-window-form">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-6">
                <label>Event title</label>
                <input type="text" name="eventTitle" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-6">
                <label>Customer name</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)" type="text" style="width:90%;" class="autocomplete-input" name="customer">
                <div class="autocomplete-wrapper"></div>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-3">
                <label>Start date</label>
                <input type="date" name="startDate" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>End date</label>
                <input type="date" name="endDate" placeholder="" required>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-6">
                <label>Workshop title</label>
                <input onfocus="getWorkshops(this)" onkeyup="getWorkshops(this)" class="autocomplete-input" type="text" name="workshopTitle" placeholder="">
                <div style="width: 100%" class="autocomplete-wrapper"></div>
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Status:</label>
                <select name="status">
                    <option value="1002">Pending</option>
                    <option value="1001">Confirmed</option>
                    <option value="1000">Delivered</option>
                    <option value="1003">On Hold</option>
                    <option value="1004">Cancelled</option>
                </select>
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Number of Attendees</label>
                <input type="number" name="numOfAttendees" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-8">
                <label>Link to Asana task:</label>
                <input type="url" name="link" placeholder="">
            </div>
        </div>

        <div id="instructor-row" class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-3">
                <label>Instructors</label>
                <select name="instructors[]">
                    <option disabled selected>Select Instructor</option>
                    <?php

                        foreach ($user->getUsersPermissions() as $instructor){
                            if($instructor->permission == 'instructor'){
                                echo "<option value='".$instructor->id."'>".$instructor->firstName . " " . $instructor->lastName ."</option>";
                            }
                        }

                    ?>

                </select>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-2">
                <button onclick="addInstructor('instructor-row')" type="button">Add Instructors</button>
            </div>
            <div class="add-window-form-section-cell form-x-1">
                <button onclick="removeInstructor('instructor-row')" type="button"><i class="fas fa-times remove-instructor"></i></button>
            </div>
        </div>

    </div>
    <div class="add-window-footer">
        <div class="add-window-footer">
            <button id="eventDefaultOpen" onclick="openWindowTab(event, 'eventMainInfo')" type="button" class="add-window-tab defaultOpen">Main Fields</button>
            <div></div>
            <div></div>
            <button type="reset" class="add-window-button-cancel window-close">Cancel</button>
            <button type="submit" class="add-window-button-save">Save</button>
        </div>
    </div>
</form>