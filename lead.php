<?php

	$lead = new Lead($id);
	$note = new Note();
	$user = new User();
	$requests = new Request();
	$inventory = new Inventory();
	$log = new ActivityLog();

	$defaultInfo = '';
    $defaultRequest = '';
	$defaultNotes = '';
	$defaultLog = '';

	if(Input::get('tab')){
	    switch (Input::get('tab')){
            case 'info':
                $defaultInfo = 'defaultOpen';
                break;
            case 'request':
                $defaultRequest = 'defaultOpen';
                break;
            case 'notes':
                $defaultNotes = 'defaultOpen';
                break;
            case 'log':
                $defaultLog = 'defaultOpen';
                break;
            default:
                $defaultInfo = 'defaultOpen';
                break;
        }
    }else{
	    $defaultInfo = 'defaultOpen';
    }

	$tagOptions = '';
	if($grups = $inventory->getFilterItems('workshopGroups')){
        foreach ($grups as $group){
            $tagOptions .= "'". $group->workshopGroups . "', ";
        }
        $tagOptions = substr($tagOptions, 0, -2);
    }

    if($lead->exists()){


        
    // $prefixes = array('Mr.','Ms.','Mrs.','Fr.','Sr.','Dr.','');
        $reachedUsBy = array('Event','Email Campaign','Partner','Social Media','Association','Print Campaign','Referral');
?>

<div class="contact-information">
	<div class="contact-sidebar-information">

        <div class="contact-sidebar-information-name">
            <div>
                <?php if($lead->data()->logo): ?>
                    <img src="view/img/logos/<?php echo $lead->data()->logo ?>">
                <?php else: ?>
                    <i class="fas fa-id-badge"></i>
                <?php endif; ?>
            </div>
            <span><?php echo $lead->data()->prefix .' '. $lead->data()->firstName .' '. $lead->data()->lastName?></span>
        </div>
		
		<div class="lead-sidebar-information-submenu">
            <a href="#transform-lead"><i class="fas fa-dollar-sign"></i></a>
			<a href="tel:01<?php echo $lead->data()->officePhone ?>"><i class="fas fa-phone"></i></a>
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
		<button class="contact-tablinks" onclick="openCity(event, 'contact-information', 'block')" id="<?php echo $defaultInfo ?>"><i class="fas fa-info"></i>Information</button>
		<button class="contact-tablinks" onclick="openCity(event, 'lead-requests', 'grid')" id="<?php echo $defaultRequest ?>"><i class="fas fa-file-alt"></i>Requests</button>
        <button class="contact-tablinks" onclick="openCity(event, 'contact-notes', 'grid')" id="<?php echo $defaultNotes ?>"><i class="fas fa-sticky-note"></i>Notes (<?php echo  $lead->countNotes($lead->data()->id, 'lead') ?>)</button>
        <button class="contact-tablinks" onclick="openCity(event, 'contact-activity-log', 'grid')" id="<?php echo $defaultLog ?>"><i class="fas fa-history"></i>Activity Log</button>
	</div>
	
	<form action="updateLead.php" method="post"  enctype="multipart/form-data" class="contact-form-information contact-tabcontent" id="contact-information">
		<input type="hidden" name="leadId" value="<?php echo $lead->data()->id ?>">

        <div class="contact-form-information-row">
            <div class="contact-form-information-cell info-form-x-3">
                <label>First Name</label>
                <input type="text" name="firstName" value="<?php echo $lead->data()->firstName; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-3">
                <label>Last Name</label>
                <input type="text" name="lastName" value="<?php echo $lead->data()->lastName; ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-3">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $lead->data()->jobTitle; ?>">
            </div>
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
        </div>

        <div class="contact-form-information-row">
            <div id="arch-diocese" class="contact-form-information-cell info-form-x-3" <?php if($lead->data()->category !== 'Diocese' && $lead->data()->category !== 'Private School') echo 'style="display: none"' ?>>
                <label>Arch/Diocese</label>
                <input type="text" name="archDiocese" value="<?php echo $lead->data()->archDiocese ?>">
            </div>
            <div class="contact-form-information-cell info-form-x-6">
                <label>Company/School Name</label>
                <input autocomplete="false" onfocus="getCustomers(this)" onkeyup="getCustomers(this)" class="autocomplete-input"  type="text" name="customer" value="<?php echo $lead->data()->company; ?>">
                <div style="width: 100%" class="autocomplete-wrapper"></div>
            </div>
            <div class="contact-form-section-cell-file info-form-x-3">
                <label>Company Logo</label>
                <input type="file" name="logo">
                <input type="hidden" name="logoOLD" value="<?php echo $lead->data()->logo ?>">
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
                <input id="tags" type="text" name="tags" value="<?php echo $lead->data()->tags; ?>">
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

    <div id="lead-requests" class="lead-requests contact-tabcontent">

        <div id="request-table">
            <div class="request-table-nav">
                <button onclick="openRequestModal()">+ Create Request</button>
                <div class="clear"></div>
            </div>
            <div class="request-table-header">
                <div>ID</div>
                <div>Request Title</div>
                <div>Type</div>
                <div>Status</div>
                <div>Date</div>
                <div></div>
            </div>

            <?php foreach ($requests->getLoadRequestsByID($lead->data()->id) as $request): ?>

                <div class="request-table-row">
                    <div><?php echo $request->ID ?></div>
                    <div>
                        <?php echo $request->title ?>
                    </div>
                    <div>
                        <?php echo $request->typeName ?>
                    </div>
                    <div>
                        <select onchange="updateStatus(this, '<?php echo $request->ID ?>')" class="request-status <?php echo $request->colorClass ?>">
                            <?php foreach ($requests->getStatuses($request->typeID) as $status): ?>
                                    <option <?php echo $request->statusID === $status->ID ? 'selected' : '' ?> value="<?php echo $status->ID ?>"><?php echo $status->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div><?php echo date("m/d/Y", strtotime($request->insertDate)) ?></div>
                    <div>
                        <a href="request.php?case=<?php echo Input::get('case') ?>&id=<?php echo $request->ID ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>

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

    <!-- ACTIVITY LOG TAB START -->
	<div id="contact-activity-log" class="contact-activity-log contact-tabcontent">

        <div id="activity-log-wrapper">

            <?php foreach ($log->getActivityLogGrouped($lead->data()->id) as $key => $logs) : ?>

            <div class="activity-log-section">
                <h3><?php echo $key ?></h3>
                <div class="activity-log-content">
                    <?php foreach ($logs as $log): ?>

                        <?php

                            $date = new DateTime($log['time'], new DateTimeZone('UTC'));
                            $date->setTimezone(new DateTimeZone('America/New_York'));

                        ?>

                        <div>
                            <span class="activity-log-time"><?php echo $date->format('g:ia'); ?></span>
                            <?php echo $log['icon'] ?>
                            <span class="activity-log-user"><?php echo $log['userName'] ?></span>
                            <span class="activity-log-text"><?php echo $log['text'] ?></span>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

            <?php endforeach; ?>

        </div>

	</div>
    <!-- ACTIVITY LOG TAB END -->
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

        <!-- REQUEST MODAL START -->
<div id="request-modal">
    <div class="request-popup-header">
        <h2>Create Request</h2>
        <div>
            <button class="request-popup-close"></button>
        </div>
    </div>
    <form class="request-popup-content" action="function/request/createRequest.php?id=<?php echo $lead->data()->id ?>&case=lead" method="post">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-12">
                <label for="request-title">Request Title</label>
                <input required id="request-title" type="text" name="title">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Request Type</label>
                <select name="typeID">
                    <?php foreach ($requests->getTypes() as $type): ?>
                        <option value="<?php echo $type->ID ?>"><?php echo $type->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="request-popup-footer">
                <button type="submit">Create</button>
            </div>
        </div>
    </form>
</div>
        <!-- REQUEST MODAL END -->

<div class="overlay"></div>

<script>

    $('#tags').tagify({
        whitelist: [<?php echo $tagOptions ?>],
        enforceWhitelist: true,
        autoComplete: true
    });

    $('#add-new-request-tab').click();

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $('.overlay').on('click', function () {
        $('#quote-modal').hide();
        $('#proposal-modal').hide();
        $('#request-modal').hide();
        $('.overlay').hide();
    });

    /* Status Change */

    function updateStatus(select, requestID){

        let statusID = select.value;

        $.ajax({
            method: "POST",
            url: "function/request/updateStatus.php",
            data: {
                statusID: statusID,
                requestID: requestID
            }
        }).done(function(result) {
            if(result) {
                let data = JSON.parse(result);

                select.className = '';
                select.classList.add(data.colorClass);
                select.classList.add('request-status');
            }
        });

    }

    /* Request Modal */

    function openRequestModal() {
        $('.overlay').show();
        $('#request-modal').show();
    }

    $('.request-popup-close').on('click', function () {
        $('#request-modal').hide();
        $('.overlay').hide();
    });

    function showWorkshop(link, num) {
        $.ajax({
            method: "GET",
            url: "getWorkshop.php",
            data: {
                workShopID: link.value
            }
        })
            .done(function(result) {

                let content = $('#workshop-'+num+'-content');
                let data = JSON.parse(result);

                console.log(data);

                html =  '<div class="workshop-textareas">' +
                    '<div>' +
                    '<label>Description</label>' +
                    '<textarea name="data['+num+'][description]">'+ data.description +'</textarea>' +
                    '</div>' +
                    '<div>' +
                    '<label>Learner Outcomes</label>' +
                    '<textarea name="data['+num+'][learnerOutcomes]">'+ data.learnerOutcomes +'</textarea>' +
                    '</div>' +
                    '<div>' +
                    '<label>Prerequisites</label>' +
                    '<textarea name="data['+num+'][prerequisites]">'+ data.prerequisites +'</textarea>' +
                    '</div>' +
                    '<div>' +
                    '<label>MSRP</label>' +
                    '<input name="data['+num+'][msrp]" value="'+ data.msrp +'">' +
                    '       </div>' +
                    '<input type="hidden" name="data['+num+'][title]" value="'+ data.titleOfOffering +'" >' +
                    '</div>';

                content.html(html);
            });
    }

    function addRequestTab(link) {

        let count = $('.request-tablinks').length;

        let button = document.createElement('button');
        button.classList.add('request-tablinks');
        button.id = 'workshop-button-' + count;
        button.type = 'button';
        button.textContent = 'Workshop ' + count;

        let footer = $('.quote-popup-footer');

        let content = document.createElement('div');
        content.id = 'workshop-' + count;
        content.classList.add('request-tabcontent');

        footer.before(content);

        button.addEventListener("click", function (event) {
            openRequestTab(event, 'workshop-' + count)
        });

        link.before(button);

        $('#workshop-button-' + count).click();

        $.ajax({
            method: "GET",
            url: "getWorkshopList.php",
            data: {
                status: 'ok'
            }
        })
            .done(function(result) {

                let data = JSON.parse(result);

                let html = '';
                html += '<select onchange="showWorkshop(this, ' + count +')" class="js-example-basic-single">';

                html += '<option selected disabled>Select Workshop</option>';
                $.each(data, function (index, item) {
                    html += '<option value="'+ item.ID +'">'+ item.titleOfOffering +'</option>';
                });

                html += '</select>'

                let workshopCOntent = '<div id="workshop-'+count+'-content"></div>';

                $('#workshop-' + count).append(html);
                $('#workshop-' + count).append(workshopCOntent);
                $('#workshop-' + count + ' select').select2();

            });
    }

    function openRequestTab(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("request-tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("request-tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
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

