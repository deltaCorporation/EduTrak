<?php

$customer = new Customer($id);
$note = new Note();
$events = new Event();

if ($customer->exists()) {

    $customerCategories = array('Company', 'Public School', 'Private School', 'Diocese', 'Partner');

    ?>

    <div class="contact-information">
        <div class="contact-sidebar-information">

            <div class="contact-sidebar-information-name">
                <i class="fas fa-id-badge"></i>
                <span><?php echo $customer->data()->name ?></span>
            </div>

            <div class="customer-sidebar-information-submenu">

                <a href="tel:01<?php echo $customer->data()->phone ?>"><i class="fas fa-phone"></i></a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo $customer->data()->email ?>"
                   target="_blank"><i class="fas fa-envelope"></i></a>

                <a href="#delete"><i class="fas fa-trash"></i></a>
                <a href="#"><i class="fas fa-receipt"></i></a>

            </div>

            <div class="contact-sidebar-information-h6">
                <h6>Customer ID</h6>
                <span><?php echo $customer->data()->id ?></span>
            </div>

            <div class="contact-sidebar-information-h6">
                <h6>Last Contacted</h6>
                <span><?php echo $customer->data()->lastContacted ?></span>
            </div>

            <div class="contact-sidebar-information-h6">
                <h6>Created By</h6>
                <span><?php echo $customer->data()->createdBy ?></span>
            </div>

            <div class="contact-sidebar-information-h6">
                <h6>Created On</h6>
                <span><?php echo $customer->data()->createdOn ?></span>
            </div>

            <div class="contact-sidebar-information-h6">
                <h6>Modified By</h6>
                <span><?php echo $customer->data()->modifiedBy ?></span>
            </div>

            <div class="contact-sidebar-information-h6">
                <h6>Modified On</h6>
                <span><?php echo $customer->data()->modifiedOn ?></span>
            </div>

            <div class="contact-sidebar-information-h6">

            </div>

            <div class="contact-sidebar-information-name">
                <i class="fas fa-address-book"></i>
                <span>Contact</span>
            </div>


            <?php
            foreach ($customer->getContacts($id) as $contact) {

                echo "
				
				<div class='contact-sidebar-information-h6'>
					<a href= 'info.php?case=contact&id=" . $contact->id . "'>" . $contact->prefix . " " . $contact->firstName . " " . $contact->lastName . "</a>		
				</div>
				
				";


            }


            ?>


        </div>
        <div class="customer-header-information contact-tab">
            <button class="contact-tablinks" onclick="openCity(event, 'contact-information', 'block')"
                    id="<?php if (!isset($_GET['tab'])) echo 'defaultOpen' ?>"><i class="fas fa-info"></i>Information
            </button>
            <button class="contact-tablinks" onclick="openCity(event, 'contact-notes', 'grid')"
                    id="<?php if ($_GET['tab'] == 'note') echo 'defaultOpen' ?>"><i class="fas fa-sticky-note"></i>Notes (<?php echo $customer->countNotes($customer->data()->id, 'customer'); ?>)
            </button>
            <button class="contact-tablinks" onclick="openCity(event, 'contact-mails', 'grid')"><i class="fas fa-poll-h"></i>Censeo
            </button>

            <button class="contact-tablinks" onclick="openCity(event, 'contact-event')"
                    id="<?php if ($_GET['tab'] == 'event') echo 'defaultOpen' ?>"><i class="fas fa-calendar"></i>Event (<?php echo $customer->countEvent($customer->data()->id); ?>)
            </button>

        </div>

        <form action="updateCustomer.php" method="post" class="contact-form-information contact-tabcontent"
              id="contact-information">
            <input type="hidden" name="customerId" value="<?php echo $customer->data()->id ?>">

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-5">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $customer->data()->name; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Parent Customer</label>
                    <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)" class="autocomplete-input"
                           type="text" name="parentCustomer" value="<?php echo $customer->data()->parentCustomer; ?>">
                    <div style="width: 100%" class="autocomplete-wrapper"></div>
                </div>
                <div class="contact-form-information-cell info-form-x-3">
                    <label>Category</label>
                    <select id="existing-customer-category" onchange="extendExistingCustomer()" name="category">
                        <?php

                        foreach ($customer->getCategories() as $item) {
                            if ($item->category == $customer->data()->category) {
                                echo "<option value='" . $item->category . "' selected>" . $item->category . "</option>";
                            } else {
                                echo "<option value='" . $item->category . "'>" . $item->category . "</option>";
                            }
                        }

                        ?>
                    </select>
                </div>
            </div>

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-5">
                    <label>Email</label>
                    <input type="text" name="email" value="<?php echo $customer->data()->email; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Mobile Phone</label>
                    <input type="text" name="mobilePhone" value="<?php echo $customer->data()->mobilePhone; ?>">
                </div>
            </div>

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Office Phone</label>
                    <input type="text" name="officePhone" value="<?php echo $customer->data()->officePhone; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-2">
                    <label>Extension</label>
                    <input type="text" name="phoneExt" value="<?php echo $customer->data()->phoneExt; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Fax</label>
                    <input type="text" name="fax" value="<?php echo $customer->data()->fax; ?>">
                </div>
            </div>

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Partner</label>
                    <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)"  style="width:90%;" class="autocomplete-input" type="text" name="partner" value="<?php echo $customer->data()->partner; ?>">
                    <div class="autocomplete-wrapper"></div>
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Partner Rep</label>
                    <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)"  style="width:90%;" class="autocomplete-input" type="text" name="partnerRep" value="<?php echo $customer->data()->partnerRep; ?>">
                    <div class="autocomplete-wrapper"></div>
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Account Payable Info</label>
                    <input type="text" name="accountsPayableInfo"
                           value="<?php echo $customer->data()->accountsPayableInfo; ?>">
                </div>
            </div>

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-6">
                    <label>Street</label>
                    <input type="text" name="street" value="<?php echo $customer->data()->street; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>City</label>
                    <input type="text" name="city" value="<?php echo $customer->data()->city; ?>">
                </div>
            </div>

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-3">
                    <label>State</label>
                    <input type="text" name="state" value="<?php echo $customer->data()->state; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-2">
                    <label>Zip</label>
                    <input type="text" name="zip" value="<?php echo $customer->data()->zip; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-4">
                    <label>Country</label>
                    <input type="text" name="country" value="<?php echo $customer->data()->country; ?>">
                </div>
            </div>

            <div class="contact-form-information-row">
                <div class="contact-form-information-cell info-form-x-12">
                    <label>Tags</label>
                    <input type="text" name="tags" value="<?php echo $customer->data()->tags; ?>">
                </div>
            </div>

            <div class="contact-form-information-big-row">
                <div class="contact-form-information-cell info-form-y-4 info-form-x-7">
                    <label>Description</label>
                    <textarea name="description"><?php echo $customer->data()->description; ?></textarea>
                </div>
                <div class="contact-form-information-cell info-form-x-5">
                    <label>Facebook</label>
                    <input type="text" name="facebook" value="<?php echo $customer->data()->facebook; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-5">
                    <label>Twitter</label>
                    <input type="text" name="twitter" value="<?php echo $customer->data()->twitter; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-5">
                    <label>LinkedIn</label>
                    <input type="text" name="linkedIn" value="<?php echo $customer->data()->linkedIn; ?>">
                </div>
                <div class="contact-form-information-cell info-form-x-5">
                    <label>Website</label>
                    <input type="text" name="website" value="<?php echo $customer->data()->website; ?>">
                </div>
            </div>

            <?php

            if($customer->getAdditionalInfo($customer->data()->id)){
                foreach ($customer->getAdditionalInfo($customer->data()->id) as $moreData){

                    echo'
                
                    <div id="extended-customer-content">
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-12">
                    <label>Goals and Initiatives</label>
                    <input type="text" name="goalsAndInitiatives" value="'.$moreData->goalsAndInitiatives.'">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-3">
                    <label>Number of schools</label>
                    <input type="text" name="numSchools" value="'.$moreData->numSchools.'">
                </div>
                <div class="contact-form-information-cell form-x-3">
                    <label>Number of students</label>
                    <input type="text" name="numStudents" value="'.$moreData->numStudents.'">
                </div>
                <div class="contact-form-information-cell form-x-3">
                    <label>Number of teachers</label>
                    <input type="text" name="numTeachers" value="'.$moreData->numTeachers.'">
                </div>
                <div class="contact-form-information-cell form-x-3">
                    <label>How many teachers to train</label>
                    <input type="text" name="numTrain" value="'.$moreData->numTrain.'">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-12">
                    <label>Current technology in schools</label>
                    <input type="text" name="schoolTech" value="'.$moreData->schoolTech.'">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-6">
                    <label>What devices are students using</label>
                    <input type="text" name="studentsDevices" value="'.$moreData->studentsDevices.'">
                </div>
                <div class="contact-form-information-cell form-x-6">
                    <label>What devices are teachers using</label>
                    <input type="text" name="teachersDevices" value="'.$moreData->teachersDevices.'">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-6">
                    <label>Specific dates requested for PD</label>
                    <input type="text" name="PDDates" value="'.$moreData->PDDates.'">
                </div>
                <div class="contact-form-information-cell form-x-6">
                    <label>Type of PD</label>
                    <input type="text" name="PDType" value="'.$moreData->PDType.'">
                </div>
            </div>
        </div>
                
                ';

                }
            }else{

                echo'
                
                    <div id="extended-customer-content">
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-12">
                    <label>Goals and Initiatives</label>
                    <input type="text" name="goalsAndInitiatives" value="">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-3">
                    <label>Number of schools</label>
                    <input type="text" name="numSchools" value="">
                </div>
                <div class="contact-form-information-cell form-x-3">
                    <label>Number of students</label>
                    <input type="text" name="numStudents" value="">
                </div>
                <div class="contact-form-information-cell form-x-3">
                    <label>Number of teachers</label>
                    <input type="text" name="numTeachers" value="">
                </div>
                <div class="contact-form-information-cell form-x-3">
                    <label>How many teachers to train</label>
                    <input type="text" name="numTrain" value="">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-12">
                    <label>Current technology in schools</label>
                    <input type="text" name="schoolTech" value="">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-6">
                    <label>What devices are students using</label>
                    <input type="text" name="studentsDevices" value="">
                </div>
                <div class="contact-form-information-cell form-x-6">
                    <label>What devices are teachers using</label>
                    <input type="text" name="teachersDevices" value="">
                </div>
            </div>
            <div class="contact-form-information-row">
                <div class="contact-form-information-cell form-x-6">
                    <label>Specific dates requested for PD</label>
                    <input type="text" name="PDDates" value="">
                </div>
                <div class="contact-form-information-cell form-x-6">
                    <label>Type of PD</label>
                    <input type="text" name="PDType" value="">
                </div>
            </div>
        </div>
                
                ';
            }



            ?>

            <button class="contact-form-information-save"></button>
            <button onclick="location.href='';" type="button" class="contact-form-information-cancel"></button>

        </form>

        <div id="contact-notes" class="contact-notes contact-tabcontent">
            <div class="contact-notes-all">


                <?php

                if ($user->hasPermission('user')) {
                    if (!empty($note->getNotes())) {

                        $i = 0;

                        foreach ($note->getNotes() as $note) {

                            if ($note->section == 'customer' && $note->contactsID == $id && $note->visibility == 'public') {

                                $noteUser = new User($note->userID);

                                echo "
                    
                        <form action='updateNote.php' method='post' class='contact-notes-note'>
	 			<div class='contact-notes-note-header'>
	 				<img src='view/img/profile/" . $noteUser->data()->img . "'>
	 				<h4>" . $noteUser->data()->firstName . " " . $noteUser->data()->lastName . "</h4>";

                                if ($note->visibility == 'private') {
                                    echo "<div><i class='fas fa-lock'></i></div>";
                                } else {
                                    echo "<div><i class='fas fa-eye'></i></div>";
                                }


                                echo "</div>	
	 			<div class='contact-notes-note-content'>
<input name='noteTitle' id='editNoteTitle-" . $note->id . "' disabled type='text' value='" . $note->title . "'>
<input type='hidden' name='case' value='" . $case . "'>
        	<input type='hidden' name='id' value='" . $id . "'>
	 				<input type='hidden' name='noteID' value='" . $note->id . "'>
	 				<textarea name='noteContent' id='editNoteContent-" . $note->id . "' disabled rows='" . (count(preg_split('/\n|\r/', $note->content)) - 5) . "'>" . $note->content . "</textarea>
	 				
	 			</div>
	 			<div class='contact-notes-note-date'>
	 			
	 			
	 			<span><a onclick='editNote(" . $note->id . ")' href='#'><i class='fas fa-edit'></i></a></span>
	 			<span><a href='#deleteNote-" . $note->id . "'><i class='fas fa-trash'></i></a></span>
<span><button type='submmit' id='editNoteIcon-" . $note->id . "' class='hide' href='#deleteNote-" . $note->id . "'><i class='fas fa-save'></i></button></span>
	 			
	 					<span>" . $note->createdOn . "</span>
	 				</div>
	 		</form>
                    
                    <!-- REmodal delete note -->
    
    <div class='remodal' data-remodal-id='deleteNote-" . $note->id . "'>
        <form action='deleteNote.php' method='post' class='contact-delete-contact'>
        	<h3>Are you sure you want delete this note?</h3>
        	<input type='hidden' name='case' value='" . $case . "'>
        	<input type='hidden' name='id' value='" . $id . "'>
        	<input type='hidden' name='noteID' value='" . $note->id . "'>
                <button type='submit' class='button'><i class='fas fa-trash'></i>Delete</button>
                <button type='button' data-remodal-action='cancel' class='button'><i class='fas fa-ban'></i>Cancel</button>
        </form>
    </div>

                    
                    ";

                            }
                        }

                    } else {
                        echo "No Notes";
                    }
                } else {
                    if (!empty($note->getNotes())) {

                        foreach ($note->getNotes() as $note) {

                            $i = 0;

                            if ($note->section == 'customer' && $note->contactsID == $id) {

                                $noteUser = new User($note->userID);

                                echo "
                    
                        <form action='updateNote.php' method='post' class='contact-notes-note'>
	 			<div class='contact-notes-note-header'>
	 				<img src='view/img/profile/" . $noteUser->data()->img . "'>
	 				<h4>" . $noteUser->data()->firstName . " " . $noteUser->data()->lastName . "</h4>";

                                if ($note->visibility == 'private') {
                                    echo "<div><i class='fas fa-lock'></i></div>";
                                } else {
                                    echo "<div><i class='fas fa-eye'></i></div>";
                                }


                                echo "</div>	
	 			<div class='contact-notes-note-content'>
<input name='noteTitle' id='editNoteTitle-" . $note->id . "' disabled type='text' value='" . $note->title . "'>
<input type='hidden' name='case' value='" . $case . "'>
        	<input type='hidden' name='id' value='" . $id . "'>
	 				<input type='hidden' name='noteID' value='" . $note->id . "'>
	 				<textarea name='noteContent' id='editNoteContent-" . $note->id . "' disabled rows='" . (count(preg_split('/\n|\r/', $note->content)) - 5) . "'>" . $note->content . "</textarea>
	 				
	 			</div>
	 			<div class='contact-notes-note-date'>
	 			
	 			
	 			<span><a onclick='editNote(" . $note->id . ")' href='#'><i class='fas fa-edit'></i></a></span>
	 			<span><a href='#deleteNote-" . $note->id . "'><i class='fas fa-trash'></i></a></span>
<span><button type='submmit' id='editNoteIcon-" . $note->id . "' class='hide' href='#deleteNote-" . $note->id . "'><i class='fas fa-save'></i></button></span>
	 			
	 					<span>" . $note->createdOn . "</span>
	 				</div>
	 		</form>
                    
                    <!-- REmodal delete note -->
    
    <div class='remodal' data-remodal-id='deleteNote-" . $note->id . "'>
        <form action='deleteNote.php' method='post' class='contact-delete-contact'>
        	<h3>Are you sure you want delete this note?</h3>
        	<input type='hidden' name='case' value='" . $case . "'>
        	<input type='hidden' name='id' value='" . $id . "'>
        	<input type='hidden' name='noteID' value='" . $note->id . "'>
                <button type='submit' class='button'><i class='fas fa-trash'></i>Delete</button>
                <button type='button' data-remodal-action='cancel' class='button'><i class='fas fa-ban'></i>Cancel</button>
        </form>
    </div>

                    
                    ";

                            }

                        }

                    } else {
                        echo "No Notes";
                    }
                }


                ?>


            </div>
            <form class="contact-notes-new" action="addNote.php" method="post">
                <h4 class="contact-notes-add-header">
                    New Note
                </h4>

                <input class="contact-notes-add-title" type="text" name="contactNoteTitle" placeholder="Note Title">
                <div class="contact-notes-add-private">
                    <label for="privateNote">
                        <i class="fas fa-lock"></i>
                    </label>

                    <?php

                    if ($user->hasPermission('user')) {
                        echo "<input id='privateNote' type='checkbox' style='cursor: not-allowed' disabled name='contactNotePrivate' value='private'>";
                    } else {
                        echo "<input id='privateNote' type='checkbox' name='contactNotePrivate' value='private'>";
                    }

                    ?>


                </div>
                <textarea class="contact-notes-add-content" name="contactNoteContent"
                          placeholder="Note content"></textarea>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="hidden" name="case" value="<?php echo $case ?>">
                <button type="submit"><i class="fas fa-plus"></i>Add</button>
            </form>
        </div>

        <div id="contact-mails" class="contact-mails contact-tabcontent">
            <h3>Censeo</h3>

        </div>

        <div id="contact-event" class="contact-event contact-tabcontent">

            <div id="event-table" class="contact-event-table">
                <div class="contact-event-header">
                    <div>ID</div>
                    <div>Workshop Title</div>
                    <div>Date</div>
                    <div>Status</div>
                    <div>Instructors</div>
                    <div>Attendees</div>
                    <div> Link to Asana</div>
                    <div onclick="show('add-event-window', 'eventDefaultOpen')">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                </div>

                <?php $i = 0; ?>

                <?php foreach ($events->getEvents() as $event): ?>

                    <?php if($customer->data()->id == $event->customerID): ?>

                        <?php

                            $date = date("m/d/Y", strtotime($event->date));

                            $status = array(
                                '1002' => 'Pending',
                                '1001' => 'Confirmed',
                                '1000' => 'Delivered',
                                '1003' => 'On Hold',
                                '1004' => 'Cancelled'
                            );

                            $i++;

                        ?>

	                    <div class='contact-event-row'>
                            <div><?php echo $event->id ?></div>
                            <div><?php echo $event->workshopTitle ?></div>
                            <div><?php echo $date ?></div>

                            <?php foreach ($status as $key => $item): ?>
                                <?php if ($event->statusID == $key): ?>
                                    <div><?php echo $item ?></div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <div>

                                <?php foreach ($events->getInstructors($event->id) as $instructor): ?>
                                    <div class='contact-event-attendee'><?php echo $instructor->firstName .' '. $instructor->lastName ?></div>
                                <?php endforeach; ?>

                            </div>

                            <div><?php echo $event->attendeesNumber ?></div>
                            <div>
                                <a target='_blank' href='<?php echo $event->linkToAsanaTask ?>'>Link to asana</a>
                            </div>
                            <div>
                                <div>
                                    <i onclick='openEventWindow(<?php echo $event->id ?>)' class='far fa-edit'></i>
                                    <i onclick='deleteEvent(<?php echo $event->id ?>)' class='far fa-trash-alt'></i>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($i == 0): ?>

	                <div class='contact-event-row'>
	                    <div>-</div>
                        <div>-</div>
                        <div>-</div>
                        <div>-</div>
                        <div>-</div>
                        <div>-</div>
                        <div>-</div>
                        <div></div>
                    </div>

                <?php endif; ?>


    </div>

    <div class="remodal" data-remodal-id="delete">
        <form action='delete.php' method='get' class="contact-delete-contact">
            <h3>Are you sure you want delete this?</h3>
            <input type='hidden' name='case' value='<?php echo $case ?>'>
            <input type='hidden' name='id' value='<?php echo $id ?>'>
            <button type='submit' class="button"><i class="fas fa-trash"></i>Delete</button>
            <button type='button' data-remodal-action="cancel" class="button"><i class="fas fa-ban"></i>Cancel</button>
        </form>
    </div>

    <div class="pup-up-window" id="update-event-window">
        <div class="pup-up-window-wrapper">
            <div class="pup-up-window-header">
                <h3>Update Event</h3>
                <button id="close-event-window" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="post" action="updateEvent.php" class="pop-up-window-content">

            </form>

        </div>
    </div>


    <script>

        function save(link, field, id, customer) {
            var option = link.options[link.selectedIndex].value;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    $('#ntf-sidebar-content').load(document.URL + ' #ntf-sidebar-subcontent');
                    $('#ntf').load(document.URL + ' #ntf');
                }
            };
            xmlhttp.open("GET", "updateEvent.php?field=" + field + "&value=" + option + "&id=" + id + "&customer=" + customer, true);
            xmlhttp.send();

        }

        function saveText(link, field, id, customer) {
            var option = link.value;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    $('#ntf-sidebar-content').load(document.URL + ' #ntf-sidebar-subcontent');
                    $('#ntf').load(document.URL + ' #ntf');
                }
            };
            xmlhttp.open("GET", "updateEvent.php?field=" + field + "&value=" + option + "&id=" + id + "&customer=" + customer, true);
            xmlhttp.send();

        }

        function editNote(noteID) {
            document.getElementById("editNoteTitle-" + noteID).disabled = false;
            document.getElementById("editNoteContent-" + noteID).disabled = false;
            document.getElementById("editNoteIcon-" + noteID).style.display = "block";
        }


        function deleteEvent(id) {
            if (confirm('Are you sure you want to delete this event!')) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        $('#contact-event').load(document.URL + ' #event-table');
                    }
                };
                xmlhttp.open("GET", "deleteEvent.php?id=" + id, true);
                xmlhttp.send();
            }
        }

        function openCity(evt, cityName, type) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("contact-tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("contact-tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" contact-active", "");
            }

            if (type === 'block') {
                document.getElementById(cityName).style.display = "block";
            } else {
                document.getElementById(cityName).style.display = "grid";
            }
            evt.currentTarget.className += " contact-active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();

        function extendExistingCustomer() {
            var cat = document.getElementById("existing-customer-category").value;
            var extendedContent = document.getElementById("extended-customer-content");

            if(cat === 'Public School' || cat === 'Private School' || cat === 'Diocese' || cat === 'District'){

                extendedContent.style.display = 'block';

            }else {
                extendedContent.style.display = 'none';
            }
        }

        $('#customers').addClass('link-selected');

    </script>


    <?php

    if($customer->data()->category == 'Public School' || $customer->data()->category == 'Private School' || $customer->data()->category == 'Diocese' || $customer->data()->category == 'District') {

        echo "
                                <style>
                                
                                    #extended-customer-content{
                                        display: block;
                                    }
                                
                                </style>
                            ";

    }

}
?>


