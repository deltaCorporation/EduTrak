<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if (Input::exists('get')) {

        $event = new Event(Input::get('q'));

        echo "
        
            <div class='add-window-form-section-row'>
                <div class='add-window-form-section-cell form-x-16'>
                    <label>Workshop Title</label>
                    <input type='text' name='workshopTitle' value='{$event->data()->workshopTitle}' >
                    <div style='width: 100%' class='autocomplete-wrapper'></div>
                </div>
            </div>
            
            <div class='add-window-form-section-row'>
                <div class='add-window-form-section-cell form-x-4'>
                    <label>Date</label>
                    <input type='date' name='date' value='{$event->data()->date}' >
                </div>
                <div class='add-window-form-section-cell form-x-4'>
                    <label>Status</label>
                    <select name='statusID'>";

                    foreach ($event->getStatuses() as $status){
                        if($event->data()->statusID == $status->id){
                            echo "<option value='{$status->id}' selected>{$status->status}</option>";
                        }else{
                            echo "<option value='{$status->id}'>{$status->status}</option>";
                        }
                    }

                    echo "
                    </select>
                </div>
                <div class='add-window-form-section-cell form-x-4'>
                    <label>Number of Attendees</label>
                    <input type='text' name='numberOfAttendees' value='{$event->data()->attendeesNumber}' >
                </div>
            </div>
            
            <div class='add-window-form-section-row'>
                <div class='add-window-form-section-cell form-x-16'>
                    <label>Link to Asana </label>
                    <input type='text' name='link' value='{$event->data()->linkToAsanaTask}' >
                </div>
            </div>
            
            <div id='instructor-row-update' class='add-window-form-section-row'>
                
            ";

                    $i = 0;

            foreach ($event->getInstructors(Input::get('q')) as $instructor){

                $name = $instructor->firstName . ' ' . $instructor->lastName;

                echo "
                    <div class='add-window-form-section-cell form-x-4'>
                    ";

                if($i == 0){
                    echo "<label>Instructors</label>";
                }else{
                    echo "<label></label>";
                }

                echo "<select name='instructors[]'>
                    ";

                foreach ($user->getUsersPermissions() as $person) {
                    if ($person->permission == 'instructor') {

                        $name2 = $person->firstName . " " . $person->lastName;

                        if($name == $name2){
                            echo "<option selected value='" . $person->id . "'>" . $person->firstName . " " . $person->lastName . "</option>";
                        }else{
                            echo "<option value='" . $person->id . "'>" . $person->firstName . " " . $person->lastName . "</option>";
                        }
                    }
                }

                echo "
                        </select>
                    </div>
                    
                    ";

                $i++;
            }

            echo "
                   
                </div>
                
                <div class='add-window-form-section-row'>
                    <div class='add-window-form-section-cell form-x-4'>
                        <button onclick='addInstructor(\"instructor-row-update\")' type='button'>Add Instructors</button>
                    </div>
                    <div class='add-window-form-section-cell form-x-1'>
                        <button onclick='removeInstructor(\"instructor-row-update\")' type='button' class='remove-instructor'></button>
                    </div>
                </div>
               
               <input type='hidden' name='id' value='{$event->data()->id}'>
               
               <div class='pup-up-window-footer'>
                    <div></div>
                    <button type='submit' class='pup-up-window-button'>Save</button>
               </div>
            ";

    }
}

