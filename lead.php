<?php

	$lead = new Lead($id);
	$note = new Note();
	$user = new User();

    if($lead->exists()){

        
    // $prefixes = array('Mr.','Ms.','Mrs.','Fr.','Sr.','Dr.','');
        $reachedUsBy = array('Event','Email Campaign','Partner','Social Media','Association','Print Campaign','Referral');
?>

<div class="contact-information">
	<div class="contact-sidebar-information">
	
		<div class="contact-sidebar-information-name">
			<i class="fas fa-id-badge"></i>
			<span><?php echo $lead->data()->prefix .' '. $lead->data()->firstName .' '. $lead->data()->lastName?></span>
		</div>
		
		<div class="lead-sidebar-information-submenu">
            <a href="#transform-lead"><i class="fas fa-dollar-sign"></i></a>
			<a href="tel:01<?php echo $lead->data()->phone ?>"><i class="fas fa-phone"></i></a>
			<a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo $lead->data()->email ?>" target="_blank"><i class="fas fa-envelope"></i></a>
			<a href="#delete"><i class="fas fa-trash"></i></a>
		</div>
		
		<div class="contact-sidebar-information-h6">
			<h6>Lead ID</h6>
			<span><?php echo $lead->data()->id ?></span>
		</div>
		
		<div class="contact-sidebar-information-h6">
			<h6>Last Contacted</h6>
			<span><?php echo $lead->data()->lastContacted ?></span>
		</div>
		
		<div class="contact-sidebar-information-h6">
			<h6>Created By</h6>
			<span><?php echo $lead->data()->createdBy ?></span>
		</div>
		
		<div class="contact-sidebar-information-h6">
			<h6>Created On</h6>
			<span><?php echo $lead->data()->createdOn ?></span>
		</div>
		
		<div class="contact-sidebar-information-h6">
			<h6>Modified By</h6>
			<span><?php echo $lead->data()->modifiedBy ?></span>
		</div>
		
		<div class="contact-sidebar-information-h6">
			<h6>Modified On</h6>
			<span><?php echo $lead->data()->modifiedOn ?></span>
		</div>
	
	</div>
	<div class="lead-header-information contact-tab">
		<button class="contact-tablinks" onclick="openCity(event, 'contact-information', 'block')" id="<?php if(Session::exists('home')){echo 'defaultOpen';}else{echo 'defaultOpen';} ?>"><i class="fas fa-info"></i>Information</button>
		<button class="contact-tablinks" onclick="openCity(event, 'contact-requests', 'grid')"><i class="fas fa-file-alt"></i>Requests</button>
        <button class="contact-tablinks" onclick="openCity(event, 'contact-notes', 'grid')" id="<?php if(Session::exists('home')){ echo 'defaultOpen';} ?>"><i class="fas fa-sticky-note"></i>Notes (<?php echo  $lead->countNotes($lead->data()->id, 'lead') ?>)</button>
        <button class="contact-tablinks" onclick="openCity(event, 'contact-mails', 'grid')"><i class="fas fa-envelope"></i>Email</button>
	</div>
	
	<form action="updateLead.php" method="post" class="contact-form-information contact-tabcontent" id="contact-information">
		<input type="hidden" name="leadId" value="<?php echo $lead->data()->id ?>">

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-3">
                <label>First Name</label>
                <input type="text" name="firstName" value="<?php echo $lead->data()->firstName; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-4">
                <label>Last Name</label>
                <input type="text" name="lastName" value="<?php echo $lead->data()->lastName; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $lead->data()->jobTitle; ?>">
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-3">
                <label>Category</label>
                <select id="existing-lead-category" onchange="extendExistingLead()" name="category">
                    <option>Select Category</option>
                    <?php

                        foreach ($lead->getCategories() as $category){

                            if($lead->data()->category == $category->category){
                                echo "<option selected value='".$category->category."'>".$category->category."</option>";
                            }else{
                                echo "<option value='".$category->category."'>".$category->category."</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div id="arch-diocese" class="contact-form-information-cell info-form-x-3" <?php if($lead->data()->category !== 'Diocese' && $lead->data()->category !== 'Private School') echo 'style="display: none"' ?>>
                <label>Arch/Diocese</label>
                <input type="text" name="archDiocese" value="<?php echo $lead->data()->archDiocese ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-6">
                <label>Company/School Name</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)" class="autocomplete-input"  type="text" name="customer" value="<?php echo $lead->data()->company; ?>">
                <div style="width: 100%" class="autocomplete-wrapper"></div>
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-8">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $lead->data()->email; ?>">
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-5">
                <label>Office Phone</label>
                <input type="text" name="officePhone" value="<?php echo $lead->data()->officePhone; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-2">
                <label>Extension</label>
                <input type="text" name="ext" value="<?php echo $lead->data()->phoneExt; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>Mobile Phone</label>
                <input type="text" name="mobilePhone" value="<?php echo $lead->data()->mobilePhone; ?>">
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-5">
                <label>Partner</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)"  style="width:90%;" class="autocomplete-input" type="text" name="partner" value="<?php echo $lead->data()->partner; ?>">
                <div class="autocomplete-wrapper"></div>
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>Partner Rep</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)"  style="width:90%;" class="autocomplete-input" type="text" name="partnerRep" value="<?php echo $lead->data()->partnerRep; ?>">
                <div class="autocomplete-wrapper"></div>
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-6">
                <label>Street</label>
                <input type="text" name="street" value="<?php echo $lead->data()->street; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-4">
                <label>City</label>
                <input type="text" name="city" value="<?php echo $lead->data()->city; ?>">
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-3">
                <label>State</label>
                <input type="text" name="state" value="<?php echo $lead->data()->state; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-2">
                <label>Zip</label>
                <input type="text" name="zip" value="<?php echo $lead->data()->zip; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-4">
                <label>Country</label>
                <input type="text" name="country" value="<?php echo $lead->data()->country; ?>">
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-12">
                <label>Tags</label>
                <input type="text" name="tags" value="<?php echo $lead->data()->tags; ?>">
            </div>
        </div>

        <div class="contact-form-information-big-row">
            <div class="contact-form-information-cell info-form-y-4 info-form-x-7">
                <label>Description</label>
                <textarea name="description"><?php echo $lead->data()->description; ?></textarea>
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>Facebook</label>
                <input type="text" name="facebook" value="<?php echo $lead->data()->facebook; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>Twitter</label>
                <input type="text" name="twitter" value="<?php echo $lead->data()->twitter; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>LinkedIn</label>
                <input type="text" name="linkedIn" value="<?php echo $lead->data()->linkedIn; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-5">
                <label>Website</label>
                <input type="text" name="website" value="<?php echo $lead->data()->website; ?>">
            </div>
        </div>

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-3">
                <label>Follow up date</label>
                <input type="date" name="followUpDate" value="<?php echo $lead->data()->followUpDate; ?>">
            </div>
            <div id="reachedUsBy" class="contact-form-information-cell form-x-3">
                <label>Reached us by</label>
                <select name="reachedUsBy">
                    <?php

                        $i = 0;

                        foreach ($reachedUsBy as $item){
                            if($item == $lead->data()->reachedUsBy){
                                echo '<option value="'.$item.'" selected>'.$item.'</option>';
                                $i++;
                            }else{
                                echo '<option value="'.$item.'">'.$item.'</option>';
                            }
                        }

                    if($i == 0){
                        echo '<option selected></option>';
                    }

                    ?>
                </select>
            </div>
            <div id="eventName" <?php echo $lead->data()->reachedUsBy === 'Event' ? 'style="display: block"' : ''  ?> class="contact-form-information-cell info-form-x-3">
                <label>Event Name</label>
                <input type="input" name="eventName" value="<?php echo $lead->data()->eventName; ?>">
            </div>
            <div class="contact-form-information-cell form-x-3">
                <label>Assigned to</label>
                <select name="assignedTo">

                    <?php

                    $users = new User();
                    $i = 0;


                        foreach ($user->getUsersPermissions() as $sales){
                            if($sales->permission == 'sales'){
                                if($lead->data()->assignedTo == $sales->id){
                                    echo "<option selected value='".$sales->id."'>".$sales->firstName . " " . $sales->lastName ."</option>";
                                    $i++;
                                }else{
                                    echo "<option value='".$sales->id."'>".$sales->firstName . " " . $sales->lastName ."</option>";
                                }

                            }
                        }

                    if($i == 0){
                        echo '<option selected></option>';
                    }

                    ?>

                </select>
            </div>
        </div>

        <?php

        if($lead->getAdditionalInfo($lead->data()->id)){
            foreach ($lead->getAdditionalInfo($lead->data()->id) as $moreData){

                echo'
                
                    <div id="extended-lead-content">
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
                
                    <div id="extended-lead-content">
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

    <div id="contact-requests" class="lead-requests contact-tabcontent">

        <div>
            <div class="request-table-header">
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
            <div class='request-table-row'>
                <div>-</div>
                <div>-</div>
                <div>-</div>
                <div>-</div>
                <div>-</div>
                <div>-</div>
                <div>-</div>
                <div></div>
            </div>
        </div>

    </div>
	
	<div id="contact-notes" class="contact-notes contact-tabcontent">
	<div class="contact-notes-all">


        <?php

        if($user->hasPermission('user')){
            if(!empty($note->getNotes())) {

                $i = 0;

                foreach ($note->getNotes() as $note) {

                    if ($note->section == 'lead' && $note->contactsID == $id && $note->visibility == 'public') {

                        $noteUser = new User($note->userID);

                        echo "
                    
                        <div class='contact-notes-note'>
	 			<div class='contact-notes-note-header'>
	 				<img src='view/img/profile/" . $noteUser->data()->img . "'>
	 				<h4>" . $noteUser->data()->firstName . " " . $noteUser->data()->lastName . "</h4>";
	 				
	 				if ($note->type == 'call') {
		                            echo "<div><i class='fas fa-phone'></i></div>";
		                        } else {
		                            echo "<div></div>";
		                        }
	 				
	 				if ($note->visibility == 'private') {
		                            echo "<div><i class='fas fa-lock'></i></div>";
		                        } else {
		                            echo "<div><i class='fas fa-eye'></i></div>";
		                        }
		                        
		                        
		                        
	 			echo "</div>	
	 			<div class='contact-notes-note-content'>
	 				<h4>" . $note->title . "</h4>
	 				<p>
	 					" . $note->content . "
	 				</p>
	 				
	 			</div>
	 			<div class='contact-notes-note-date'>
	 			
	 			<span><a href='#'><i class='fas fa-edit'></i></a></span>
	 			<span><a href='#deleteNote-". $note->id ."'><i class='fas fa-trash'></i></a></span>
	 			<span></span>
	 					<span>" . $note->createdOn . "</span>
	 				</div>
	 		</div>
	 		
	 		<!-- REmodal delete note -->
    
    <div class='remodal' data-remodal-id='deleteNote-". $note->id ."'>
        <form action='deleteNote.php' method='post' class='contact-delete-contact'>
        	<h3>Are you sure you want delete this note?</h3>
        	<input type='hidden' name='case' value='". $case ."'>
        	<input type='hidden' name='id' value='". $id ."'>
        	<input type='hidden' name='noteID' value='". $note->id ."'>
                <button type='submit' class='button'><i class='fas fa-trash'></i>Delete</button>
                <button type='button' data-remodal-action='cancel' class='button'><i class='fas fa-ban'></i>Cancel</button>
        </form>
    </div>
                    
                    ";

                    }
                }

            }else{
                echo "No Notes";
            }
        }else{
            if(!empty($note->getNotes())) {

                foreach ($note->getNotes() as $note) {

                    $i = 0;

                    if ($note->section == 'lead' && $note->contactsID == $id) {

                        $noteUser = new User($note->userID);

                        echo "
                    
                        <div class='contact-notes-note'>
	 			<div class='contact-notes-note-header'>
	 				<img src='view/img/profile/" . $noteUser->data()->img . "'>
	 				<h4>" . $noteUser->data()->firstName . " " . $noteUser->data()->lastName . "</h4>";
	 				
	 				if ($note->type == 'call') {
		                            echo "<div><i class='fas fa-phone'></i></div>";
		                        } else {
		                            echo "<div></div>";
		                        }
	 				
	 				if ($note->visibility == 'private') {
		                            echo "<div><i class='fas fa-lock'></i></div>";
		                        } else {
		                            echo "<div><i class='fas fa-eye'></i></div>";
		                        }
	 				
	 			
	 			echo "</div>	
	 			<div class='contact-notes-note-content'>
	 				<h4>" . $note->title . "</h4>
	 				<p>
	 					" . $note->content . "
	 				</p>
	 				
	 			</div>
	 			<div class='contact-notes-note-date'>
	 			
	 			
	 			<span><a href='#'><i class='fas fa-edit'></i></a></span>
	 			<span><a href='#deleteNote-". $note->id ."'><i class='fas fa-trash'></i></a></span>
	 			<span></span>
	 					<span>" . $note->createdOn . "</span>
	 				</div>
	 		</div>
                    
                    <!-- REmodal delete note -->
    
    <div class='remodal' data-remodal-id='deleteNote-". $note->id ."'>
        <form action='deleteNote.php' method='post' class='contact-delete-contact'>
        	<h3>Are you sure you want delete this note?</h3>
        	<input type='hidden' name='case' value='". $case ."'>
        	<input type='hidden' name='id' value='". $id ."'>
        	<input type='hidden' name='noteID' value='". $note->id ."'>
                <button type='submit' class='button'><i class='fas fa-trash'></i>Delete</button>
                <button type='button' data-remodal-action='cancel' class='button'><i class='fas fa-ban'></i>Cancel</button>
        </form>
    </div>
                    
                    ";

                    }

                }

            }else{
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

                    if($user->hasPermission('user')){
                        echo "<input id='privateNote' type='checkbox' style='cursor: not-allowed' disabled name='contactNotePrivate' value='private'>";
                    }else{
                        echo "<input id='privateNote' type='checkbox' name='contactNotePrivate' value='private'>";
                    }

                ?>


	 		</div>
	 		<div class="contact-notes-add-call">
	 			<label for="callNote">
	 				<i class="fas fa-phone"></i>
	 			</label>

                <?php

                    if($user->hasPermission('user')){
                        echo "<input id='callNote' type='checkbox' style='cursor: not-allowed' disabled name='contactNoteCall' value='call'>";
                    }else{
                        echo "<input id='callNote' type='checkbox' name='contactNoteCall' value='call'>";
                    }

                ?>


	 		</div>
	 		<textarea class="contact-notes-add-content" name="contactNoteContent" placeholder="Note content"></textarea>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="case" value="<?php echo $case ?>">
	 		<button type="submit"><i class="fas fa-plus"></i>Add</button>
	 	</form>
	</div>
	
	<div id="contact-mails" class="contact-mails contact-tabcontent">
	  <h3>Mails</h3>
	</div>
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

<script>
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

    if (type === 'block'){
        document.getElementById(cityName).style.display = "block";
    }else{
        document.getElementById(cityName).style.display = "grid";
    }
    evt.currentTarget.className += " contact-active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

    
function extendExistingLead() {
    var cat = document.getElementById("existing-lead-category").value;
    var extendedContent = document.getElementById("extended-lead-content");
    let archDiocese = document.getElementById('arch-diocese');

    if(cat === 'Public School' || cat === 'Private School' || cat === 'Diocese' || cat === 'District'){

        if(cat === 'Diocese' || cat === 'Private School'){
            archDiocese.style.display = 'block';
        }else{
            archDiocese.style.display = 'none';
        }

        extendedContent.style.display = 'block';

    }else {
        extendedContent.style.display = 'none';
        archDiocese.style.display = 'none';
    }
}

$('#leads').addClass('link-selected');

$('#reachedUsBy select').on('change', function () {

    let eventName = $('#eventName');
    let eventNameInput = $('#addLeadEventName input');

    if(this.value === 'Event'){
        eventName.show();
    }else{
        eventName.hide();
        eventNameInput.html('');
    }
});

</script>

<?php

        if($lead->data()->category == 'Public School' || $lead->data()->category == 'Private School' || $lead->data()->category == 'Diocese' || $lead->data()->category == 'District') {

            echo "
                                <style>
                                
                                    #extended-lead-content{
                                        display: block;
                                    }
                                
                                </style>
                            ";

        }

	}
?>

