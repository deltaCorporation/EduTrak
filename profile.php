<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$lead = new Lead();
$note = new Note();

$gender = array('Male','Female');



if($user->isLoggedIn()){


    if ($id = Input::get('id')){

        $employee = new User($id);

        if($employee->find($id)){

            if($user->hasPermission('superAdmin') || $user->hasPermission('admin')){


                ?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>EduTrak</title>

                    <link href="view/css/reset.css" rel="stylesheet">
                    <link href="view/css/style.css" rel="stylesheet">

                    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

                    <link href="view/css/remodal.css" rel="stylesheet">
                    <link href="view/css/remodal-default-theme.css" rel="stylesheet">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script src="view/js/remodal.js"></script>



                </head>
                <body>

                <?php include __DIR__.'/include/header.php'; ?>

                <div class="dropdown">
                    <div id="myDropdown" class="dropdown-content">
                        <a href="#" data-remodal-target="profile" class="profile-ico">Profile</a>
                        <a href="#" class="settings-ico">Settings<span class="notification-sign-yellow">!</span></a>
                        <a href="logout.php" class="logout-ico">Log out</a>
                    </div>
                </div>

                <aside id="index-sidebar">
                    <div class="sidebar-header">
                        <div id="logo">EduTrak</div>
                        <button id="close-nav" onclick="w3_close()">&times;</button>
                    </div>

                    <nav class="sidebar-nav">
                        <button class="sidebar-dropdown-btn">menu
                            <span class="sidebar-dropdown-icon">&#9660</span>
                        </button>
                        <div class="sidebar-dropdown-container">
                            <a href="#">submenu</a>
                            <a href="#">submenu</a>
                        </div>
                        <a href="#">menu</a>
                        <a href="#">menu</a>
                        <button class="sidebar-dropdown-btn">menu
                            <span class="sidebar-dropdown-icon">&#9660</span>
                        </button>
                        <div class="sidebar-dropdown-container">
                            <a href="#">submenu</a>
                            <a href="#">submenu</a>
                            <a href="#">submenu</a>
                        </div>
                        <a href="#">menu</a>
                    </nav>

                </aside>

                <?php  include_once __DIR__ . '/include/ntf.php';   ?>

                <aside id="msg-sidebar">
                    <div class="msg-sidebar-header">
                        <div class="msg-close">&times;</div>
                        <h2>Massages</h2>
                    </div>
                    <div class="msg-sidebar-content">

                    </div>
                </aside>

                <?php

                include_once __DIR__ . '/include/addSidebar.php';

                ?>



                <div class="contact-information">
                    <div class="contact-sidebar-information">

                        <div class="employee-sidebar-information-name">
                            <div class="profile-image"  style="background: url('<?php echo 'view/img/profile/'.escape($employee->data()->img) ?>') no-repeat center; background-size: 5vh;"></div>
                            <span><?php echo $employee->data()->firstName .' '. $employee->data()->lastName  ?></span>
                        </div>

                        <div class="profile-sidebar-information-submenu">
                            <a href="tel:01<?php echo $employee->data()->phone ?>"><i class="fas fa-phone"></i></a>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo $employee->data()->email ?>" target="_blank"><i class="fas fa-envelope"></i></a>
                            <a href="#delete"><i class="fas fa-trash"></i></a>
                        </div>
                        <div class="profile-sidebar-information-submenu">
                            <a href="https://www.facebook.com/<?php echo $employee->data()->facebook ?>"><i class="fab fa-facebook-square"></i></a>
                            <a href="https://twitter.com/<?php echo $employee->data()->twitter ?>"><i class="fab fa-twitter-square"></i></a>
                            <a href="https://www.linkedin.com/<?php  echo $employee->data()->linkedin ?>"><i class="fab fa-linkedin"></i></a>
                        </div>



                    </div>
                    <div class="contact-header-information contact-tab">
                        <button class="contact-tablinks" onclick="openCity(event, 'contact-information', 'block')" id="<?php if(Session::exists('home')){}else{echo 'defaultOpen';} ?>"><i class="fas fa-info"></i>Information</button>
                        <button class="contact-tablinks" onclick="openCity(event, 'contact-notes', 'grid')" id="<?php if(Session::exists('home')){ echo 'defaultOpen';} ?>"><i class="fas fa-sticky-note"></i>Notes (-)</button>
                        <button class="contact-tablinks" onclick="openCity(event, 'contact-travelInfo', 'grid')" id="<?php if(Session::exists('home')){ echo 'defaultOpen';} ?>"><i class="fas fa-plane"></i>Travel info</button>
                    </div>

                    <form action="updateEmployee.php" method="post" class="contact-form-information contact-tabcontent" id="contact-information">
                        <input type="hidden" name="id" value="<?php echo $employee->data()->id ?>">

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-5">
                                <label>First Name</label>
                                <input type="text" name="firstName" value="<?php echo $employee->data()->firstName ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-5">
                                <label>Last Name</label>
                                <input type="text" name="lastName" value="<?php echo $employee->data()->lastName ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-2">
                                <label>Gender</label>
                                <select name="gender">
                                    <?php

                                    $i = 0;

                                    foreach ($gender as $item){
                                        if($item == $employee->data()->gender){
                                            echo '<option selected>'.$item.'</option>';
                                            $i++;
                                        }else{
                                            echo '<option>'.$item.'</option>';
                                        }
                                    }

                                    if($i == 0){
                                        echo '<option selected></option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-10">
                                <label>Role</label>
                                <input type="text" name="role" value="<?php echo $employee->data()->role ?>">
                            </div>

                        </div>


                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Phone number</label>
                                <input  type="text" name="phoneNumber" value="<?php echo $employee->data()->phone ?>">
                            </div>

                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Email</label>
                                <input  type="email" name="email" value="<?php echo $employee->data()->email ?>">
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Personal phone</label>
                                <input  type="text" name="personalPhone" value="<?php echo $employee->data()->personalPhone ?>">
                            </div>

                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Personal email</label>
                                <input  type="email" name="personalEmail" value="<?php echo $employee->data()->personalEmail ?>">
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Emergency phone</label>
                                <input  type="text" name="emergencyPhone" value="<?php echo $employee->data()->emergencyPhone ?>">
                            </div>

                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Emergency email</label>
                                <input  type="email" name="emergencyEmail" value="<?php echo $employee->data()->emergencyEmail ?>">
                            </div>
                        </div>


                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Street</label>
                                <input type="text" name="street" value="<?php echo $employee->data()->street ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-4">
                                <label>City</label>
                                <input type="text" name="city" value="<?php echo $employee->data()->city ?>">
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-3">
                                <label>State</label>
                                <input type="text" name="state" value="<?php echo $employee->data()->state ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-2">
                                <label>Zip</label>
                                <input type="text" name="zip" value="<?php echo $employee->data()->zip ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-4">
                                <label>Country</label>
                                <input type="text" name="country" value="<?php echo $employee->data()->country ?>">
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Facebook</label>
                                <input type="text" name="facebook" value="<?php echo $employee->data()->facebook ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Twitter</label>
                                <input type="text" name="twitter" value="<?php echo $employee->data()->twitter ?>">
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>LinkedIn</label>
                                <input type="text" name="LinkedIn" value="<?php echo $employee->data()->linkedin ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Website</label>
                                <input type="text" name="Website" value="<?php echo $employee->data()->website ?>">
                            </div>
                        </div>

                        <div class="contact-form-information-row">
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>Start date</label>
                                <input type="text" name="startDate" value="<?php echo $employee->data()->startDate ?>">
                            </div>
                            <div class="contact-form-information-cell info-form-x-6">
                                <label>End date</label>
                                <input type="text" name="endDate"  value="<?php echo $employee->data()->endDate ?>">
                            </div>

                        </div>



                        <button class="contact-form-information-save"></button>
                        <button onclick="location.href='';" type="button" class="contact-form-information-cancel"></button>

                    </form>




                    <div id="contact-notes" class="contact-notes contact-tabcontent">
                        <div class="contact-notes-all">


                            <?php

                            if($user->hasPermission('superAdmin')){
                                if(!empty($note->getNotes())) {

                                    $i = 0;

                                    foreach ($note->getNotes() as $note) {

                                        if ($note->section == 'employee' && $note->contactsID == $id) {

                                            $noteUser = new User($note->userID);

                                            echo "
                    
                        <div class='contact-notes-note'>
	 			<div class='contact-notes-note-header'>
	 				<img src='view/img/profile/" . $noteUser->data()->img . "'>
	 				<h4>" . $noteUser->data()->firstName . " " . $noteUser->data()->lastName . "</h4>";


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
        	<input type='hidden' name='case' value='employee'>
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
                                echo "No Notes";
                            }





                            ?>


                        </div>
                        <form class="contact-notes-new" action="addNote.php" method="post">
                            <h4 class="contact-notes-add-header">
                                New Note
                            </h4>

                            <input class="contact-notes-add-title" type="text" name="contactNoteTitle" placeholder="Note Title" style="grid-column-end: span 3;">

                            <textarea class="contact-notes-add-content" name="contactNoteContent" placeholder="Note content"></textarea>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="hidden" name="case" value="employee">
                            <button type="submit"><i class="fas fa-plus"></i>Add</button>
                        </form>
                    </div>

                    <div id="contact-" class="contact-mails contact-tabcontent">
                        <h3>Mails</h3>
                    </div>

                    <div id="contact-travelInfo" class="contact-mails contact-tabcontent">
                        <div class="table">
                            <div class="row travel-info-table-header">
                                <div class="travel-info-header-cell">Company</div>
                                <div class="travel-info-header-cell">Account Number</div>
                                <div class="travel-info-header-cell">Login</div>
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">Alaska</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">American</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">Delta</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">Southwest</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">United</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">TSA/Known Traveler Number</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">Global Entry</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">Hilton Honors</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">IHG</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                            <div class="row">
                                <div class="travel-info-cell">National</div>
                                <input class="travel-info-cell" value="n/a">
                                <input class="travel-info-cell" value="n/a">
                            </div>
                        </div>

                    </div>


                </div>

                <div class="remodal" data-remodal-id="delete">
                    <form action='delete.php' method='get' class="contact-delete-contact">
                        <h3>Are you sure you want delete this?</h3>
                        <input type='hidden' name='case' value='employee'>
                        <input type='hidden' name='id' value='<?php echo $id ?>'>
                        <button type='submit' class="button"><i class="fas fa-trash"></i>Delete</button>
                        <button type='button' data-remodal-action="cancel" class="button"><i class="fas fa-ban"></i>Cancel</button>
                    </form>
                </div>


                <footer id="footer">

                </footer>





                <!-- Remodals -->

                <?php

                include_once __DIR__ . '/include/newEmployee.php';

                include_once __DIR__ . '/include/newLead.php';

                include_once __DIR__ . '/include/newCustomer.php';

                include_once __DIR__ . '/include/newContact.php';

                include_once __DIR__ . '/include/newEvent.php';

                include_once __DIR__ . '/include/newItem.php';

                include_once __DIR__ . '/include/infoProfile.php';

                include_once __DIR__ . '/include/newHardware.php';

                ?>

                </body>

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
                    document.getElementById("employeeDefaultOpen").click();



                </script>


                </html>



                <?php

                include_once __DIR__ . '/include/scripts.php';

            }else{

                Redirect::to('employees.php');

            }}else{
            Redirect::to('employees.php');
        }

    }else{
        Redirect::to('index.php');
    }

}else{
    Redirect::to('index.php');
}