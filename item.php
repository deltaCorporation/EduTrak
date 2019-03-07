<?php



/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()){
	if($id = Input::get('id')){

        $inventory = new Inventory($id);
	
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EduTrak</title>

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/style.css" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

        <link href="view/css/remodal.css" rel="stylesheet">
        <link href="view/css/remodal-default-theme.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="view/js/remodal.js"></script>

	<script>

        //Filter Table

        //Uncheck checkboxes

        function uncheck(groupID) {
            var filterGroup, filterItemLi, filterItem, i, z = 0, y = 0;

            filterGroup = document.getElementById(groupID);

            for(i = 1; i < filterGroup.children.length; i++){

                filterItemLi = filterGroup.children[i];

                filterItem = filterItemLi.children[0];

                if(filterItem.checked == true){
                    filterItem.checked = false;
                    y++;
                }else{
                    filterItem.checked = true;
                    z++;
                }

            }

            if(y > 0){
                var input, filter, table, row, cell, j, k;

                table = document.getElementById('table');
                row = table.getElementsByClassName('table-row');


                // Loop through all list items, and hide those who don't match the search query
                for (i = 1; i < row.length; i++) {
                    cell = row[i].getElementsByClassName("table-cell");

                    k = 0;

                    for(j = 0; j < cell.length; j++){

                        row[i].style.display = "none";

                    }


                }
            }

            if(z > 0){
                var input, filter, table, row, cell, j, k;

                table = document.getElementById('table');
                row = table.getElementsByClassName('table-row');


                // Loop through all list items, and hide those who don't match the search query
                for (i = 1; i < row.length; i++) {
                    cell = row[i].getElementsByClassName("table-cell");

                    k = 0;

                    for(j = 0; j < cell.length; j++){

                        row[i].style.display = "";

                    }


                }
            }



        }

        //Filter rows in table

        function filter(input, j){

            var table, row, cell, i, k;






            table = document.getElementById('table');
            row = table.getElementsByClassName('table-row');


            if(input.checked == true){

                input = input.value.toUpperCase();

                for (i = 1; i < row.length; i++) {
                    cell = row[i].getElementsByClassName("table-cell");

                    k = 0;

                    

                        if(cell[j].innerHTML.toUpperCase().indexOf(input) > -1){
                            row[i].style.display = "";
                        }
                    
                }
            }else {

                input = input.value.toUpperCase();

                for (i = 1; i < row.length; i++) {

                    cell = row[i].getElementsByClassName("table-cell");

                    k = 0;

                    

                        if(cell[j].innerHTML.toUpperCase().indexOf(input) > -1){
                            row[i].style.display = "none";
                        }
                    
                }
            }






        }



        //Sort Table

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("table");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.children;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("div")[n];
                    y = rows[i + 1].getElementsByTagName("div")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount ++;
                } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        // Search Table

        function search() {
            // Declare variables

            var input, filter, table, row, cell, i, j, k;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();

            table = document.getElementById('table');
            row = table.getElementsByClassName('table-row');


            // Loop through all list items, and hide those who don't match the search query
            for (i = 1; i < row.length; i++) {
                cell = row[i].getElementsByClassName("table-cell");

                k = 0;

                for(j = 0; j < cell.length; j++){

                    if(cell[j].innerHTML.toUpperCase().indexOf(filter) > -1){
                        k++;
                    }

                }

                if (k > 0) {
                    row[i].style.display = "";
                } else {
                    row[i].style.display = "none";
                }


            }

        }

    </script>

    </head>
    <body>

    <header id="header">
        <button id="open-nav" onclick="w3_open()">&#9776;</button>
        <li>
            <a href="index.php" class="tooltip">
<i class="fas fa-home"></i>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <a href="calendar.php" class="tooltip">
<i class="far fa-calendar-alt"></i>
                <span class="tooltiptext">Calendar</span>
            </a>
            <?php
            
            if ($user->hasPermission('superAdmin')){
            echo '
              <a href="employees.php" class="tooltip">
<i class="fas fa-users"></i>
                <span class="tooltiptext">Employees</span>
            </a>

            
            ';
          
            
            } ?>            <a href="leads.php" class="tooltip">
<i class="far fa-dot-circle"></i>
                <span class="tooltiptext">Leads</span>
            </a>
            <a href="contacts.php" class="tooltip">
<i class="far fa-address-book"></i>
                <span class="tooltiptext">Contacts</span>
            </a>
            <a href="customers.php" class="tooltip">
<i class="fas fa-dollar-sign"></i>
                <span class="tooltiptext">Customers</span>
            </a>
<a href="inventory.php" class="link-selected tooltip">
<i class="fas fa-boxes"></i>
                <span class="tooltiptext">Inventory</span>
            </a>
        </li>
        <form class="search" action="#" method="get">
            <input id="txt1" class="search-input" type="text" name="search" placeholder="Search" onkeyup="showHint(this.value)">

            <div id="txtHint" class="search-box">
        
        </div>
        
        <script>
		function showHint(str) {
		  var xhttp;
		  if (str.length == 0) { 
		    document.getElementById("txtHint").innerHTML = "";
		    return;
		  }
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		      document.getElementById("txtHint").innerHTML = this.responseText;
		    }
		  };
		  xhttp.open("GET", "search.php?q="+str, true);
		  xhttp.send();   
		}
		</script>
		        </form>
      <div class="tooltip msg-open">
<i class="fas fa-envelope"></i>
            <span class="tooltiptext">Inbox</span>
        </div>
        <div class="tooltip ntf-open" id="ntf">
<i class="fas fa-bell">
<?php 
			
				$ntf = new Notification();
				
				$i = 0;
				
				foreach($ntf->getNotifications() as $ntf){
					if($ntf->userID == $user->data()->id && $ntf->seen == 0){
						$i++;
					}
				}
				
				if($i != 0){
					echo '<span class="ntf-count">'.$i.'</span>';
				}
			
			 ?>
			




</i>
            <span class="tooltiptext">Notifications</span>
        </div>
        <div class="tooltip add-open">
<i class="fas fa-plus-circle"></i>
            <span class="tooltiptext">Add</span>
        </div>
        <div class="profile">
            <div class="profile-name drop-menu" onclick="myFunction()"><?php echo escape($user->data()->firstName).' '.escape($user->data()->lastName)?></div>
            <div class="profile-image drop-menu" onclick="myFunction()" style="background: url('<?php echo 'view/img/profile/'.escape($user->data()->img) ?>') no-repeat center; background-size: 5vh;"></div>
        </div>
    </header>

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

    <?php  include_once __DIR__ . '/include/ntf.php';  ?>

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

    <form action="updateInventory.php" method="post" id="wrapper-item" >
    <aside>

        <div class="item-sidebar-information-submenu">
            <a href="#"><i class="fab fa-google-drive"></i></a>
            <a href="#delete"><i class="fas fa-trash"></i></a>
            <a href="#"></a>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell">
                <label class="inventory-item-label  ">Eduscape SKU</label>
                <input class="inventory-item-input" type="text" name="eduscapeSKU" value="<?php echo $inventory->data()->eduscapeSKU ?>">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell ">
                <label class="inventory-item-label">Workshop Group</label>
                <input class="inventory-item-input " type="text" name="workshopGroup" value="<?php echo $inventory->data()->workshopGroups ?>">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell ">
                <label class="inventory-item-label">Track</label>
                <input class="inventory-item-input " type="text" name="track" value="<?php echo $inventory->data()->track ?>">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell ">
                <label class="inventory-item-label">Format</label>
                <input class="inventory-item-input " type="text" name="format" value="<?php echo $inventory->data()->format ?>">
            </div>
        </div>

         <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell ">
                <label class="inventory-item-label">Time (hours)</label>
                <input class="inventory-item-input " type="number" name="timeH" value="<?php echo $inventory->data()->time ?>">
            </div>
         </div>

         <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell ">
                <label class="inventory-item-label">Status</label>
                <input class="inventory-item-input " type="text" name="status" value="<?php echo $inventory->data()->status ?>">
            </div>
         </div>

         <div class="add-window-form-section-row" >
            <div class="add-window-form-section-cell ">
                <label class="inventory-item-label">Last Update</label>
                <input class="inventory-item-input " type="text" name="lastUpdate" value="<?php echo $inventory->data()->lastUpdate ?>">
            </div>
         </div>

        <button class="update-item-button" type="submit">Save</button>



    </aside>


    <section id="right-section">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell  form-x-16">
                <label class="inventory-item-label" >Title of Offering</label>
                <input  class="add-window-form-section-cell" name="titleOfOffering" value="<?php echo $inventory->data()->titleOfOffering ?>">
            </div>
        </div>
        <div class="add-window-form-section-row textarea-inventory">
            <div class="add-window-form-section-cell  form-x-8 form-y-4">
                <label class="inventory-item-label" >Description</label>
                <textarea class="inventory-item-textarea" name="description"><?php echo $inventory->data()->description ?></textarea>
            </div>

            <div class="add-window-form-section-cell  form-x-8 form-y-4">
                <label class="inventory-item-label" >Learner Outcomes</label>
                <textarea class="inventory-item-textarea" name="learnerOutcomes"><?php echo $inventory->data()->learnerOutcomes ?></textarea>
            </div>


        </div>

        <div class="add-window-form-section-row textarea-inventory">
            <div class="add-window-form-section-cell form-x-8 form-y-4">
                <label class="inventory-item-label" >Prerequisites</label>
                <textarea class="inventory-item-textarea" name="prerequisites"><?php echo $inventory->data()->prerequisites ?></textarea>
            </div>

            <div class="add-window-form-section-cell form-x-8 form-y-4">
                <label class="inventory-item-label" >Toolbox</label>
                <textarea class="inventory-item-textarea" name="toolbox"><?php echo $inventory->data()->toolbox ?></textarea>
            </div>

        </div>


        <div class="add-window-form-section-row textarea-inventory">
            <div class="add-window-form-section-cell form-x-8 form-y-4">
                <label class="inventory-item-label" >Notes</label>
                <textarea class="inventory-item-textarea" name="notes"><?php echo $inventory->data()->notes ?></textarea>
            </div>

            <div class="add-window-form-section-cell form-x-8 form-y-4">
                <label class="inventory-item-label" >Audience</label>
                <textarea class="inventory-item-textarea" name="audience"><?php echo $inventory->data()->audience ?></textarea>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell  form-x-8">
                <label class="inventory-item-label" >MSRP</label>
                <input class="inventory-item-right-input" type="text" name="MSRP" value="<?php echo $inventory->data()->msrp ?>">
            </div>

            <div class="add-window-form-section-cell  form-x-8">
                <label class="inventory-item-label" >MAP</label>
                <input class="inventory-item-right-input" type="text" name="MAP" value="<?php echo $inventory->data()->map ?>">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell   form-x-6">
                <label class="inventory-item-label" >CLIENT COST</label>
                <input class="inventory-item-right-input" type="number" name="clientCost" value="<?php echo $inventory->data()->clientCost ?>">
            </div>

            <div class="add-window-form-section-cell   form-x-5">
                <label class="inventory-item-label" >Author</label>
                <input class="inventory-item-right-input" type="text" name="author" value="<?php echo $inventory->data()->author ?>">
            </div>

            <div class="add-window-form-section-cell  form-x-5">
                <label class="inventory-item-label" >Materials</label>
                <input class="inventory-item-right-input" type="text" name="materials" value="<?php echo $inventory->data()->materials ?>">
            </div>
        </div>
    </section>


        <input type="hidden" name="id" value="<?php echo $id ?>">
</form>
      

    <footer id="footer">

    </footer>


    <div class="flash-msg <?php if(Session::exists('home')){ echo 'show-msg';} ?>">
        <?php

        if(Session::exists('home')) {

            echo Session::flash('home');
        }
        ?>

    </div>

    <div class="remodal" data-remodal-id="delete">
        <form action='delete.php' method='get' class="contact-delete-contact">
            <h3>Are you sure you want delete this?</h3>
            <input type='hidden' name='case' value='item'>
            <input type='hidden' name='id' value='<?php echo $id ?>'>
            <button type='submit' class="button"><i class="fas fa-trash"></i>Delete</button>
            <button type='button' data-remodal-action="cancel" class="button"><i class="fas fa-ban"></i>Cancel</button>
        </form>
    </div>



    <!-- Remodals -->

   <?php

    	include_once __DIR__ . '/include/newEmployee.php';

	include_once __DIR__ . '/include/newLead.php';
	
	include_once __DIR__ . '/include/newCustomer.php';
	
	include_once __DIR__ . '/include/newContact.php';

include_once __DIR__ . '/include/newEvent.php';

   include_once __DIR__ . '/include/newItem.php';
	
	include_once __DIR__ . '/include/infoProfile.php';
   
   	
   
    ?>

    </body>
    
    
    </html>

    <?php

include_once __DIR__ . '/include/scripts.php';
}else{
	Redirect::to(404);
}

}else{

    Redirect::to('index.php');

}