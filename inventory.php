<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$inventory = new Inventory();

$tagOptions = '';
if($grups = $inventory->getFilterItems('workshopGroups')){
    foreach ($grups as $group){
        $tagOptions .= "'". $group->workshopGroups . "', ";
    }
    $tagOptions = substr($tagOptions, 0, -2);
}

if($user->isLoggedIn()){
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EduTrak</title>

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/style.css" rel="stylesheet">
        <link href="view/css/tagify.css" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

        <link href="view/css/remodal.css" rel="stylesheet">
        <link href="view/css/remodal-default-theme.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="view/js/jQuery.tagify.min.js"></script>
        <script src="view/js/tagify.js"></script>
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

    <section id="wrapper">
        <aside>
            <h2>Filters</h2>

            <ul id='workshopGroup'>
                <span onclick="uncheck('workshopGroup')" >Workshop Group</span>
                
                <?php
                	foreach($inventory->getFilterItems('workshopGroups') as $item){
                		echo '<li><input onclick="filter(this, 1)" value="'.escape($item->workshopGroups).'" id="'.escape($item->workshopGroups).'" type="checkbox" checked><label for="'.escape($item->workshopGroups).'">'.escape($item->workshopGroups).'</label></li>';
                	}
                ?>
            </ul>
            
            <ul id="format">
                <span onclick="uncheck('format')">Format</span>
                <?php
                	foreach($inventory->getFilterItems('format') as $item){
                		echo '<li><input onclick="filter(this, 3)" value="'.escape($item->format).'" id="'.$item->format.'" type="checkbox" checked><label for="'.$item->format.'">'.$item->format.'</label></li>';
                	}
                ?>
            </ul>
            
            <ul id="time">
                <span  onclick="uncheck('time')">Time</span>
                <?php
                	foreach($inventory->getFilterItems('time') as $item){
                		echo '<li><input onclick="filter(this, 4)" value="'.escape($item->time).'" id="'.$item->time.'" type="checkbox" checked><label for="'.$item->time.'">'.$item->time.'</label></li>';
                	}
                ?>
            </ul>
            
            <ul id="status">
                <span  onclick="uncheck('status')">Status</span>
                <?php
                	foreach($inventory->getFilterItems('status') as $item){
                		echo '<li><input onclick="filter(this, 5)" value="'.escape($item->status).'" id="'.$item->status.'" type="checkbox" checked><label for="'.$item->status.'">'.$item->status.'</label></li>';
                	}
                ?>
            </ul>

        </aside>

        <section id="right-section">
            <nav id="nav">
                <input id="search" type="text" placeholder="Search inventory..." onkeyup="search()">
                <div>
                    <a href="#">
                        <i class="fas fa-file-csv"></i> Export data
                    </a>
                </div>
            </nav>

            <section id="table">
            
            	<a href="#" class="table-row">
                    <div class="table-header" onclick="sortTable(0)">Eduscape SKU</div>
                    <div class="table-header" onclick="sortTable(1)">Workshop Group</div>
                    <div class="table-header" onclick="sortTable(2)">Track</div>
                    <div class="table-header" onclick="sortTable(3)">Format</div>
                    <div class="table-header" onclick="sortTable(4)">Time (hours)</div>
                    <div class="table-header" onclick="sortTable(5)">status</div>
                    <div class="table-header" onclick="sortTable(6)">Title of Offering</div>
                </a>
            
            	<?php 
            	
            		foreach($inventory->getInventory() as $item){
            			
            			echo '
            				<a href="item.php?id='.escape($item->id).'" class="table-row">
			                    <div class="table-cell">'.escape($item->eduscapeSKU).'</div>
			                    <div class="table-cell">'.escape($item->workshopGroups).'</div>
			                    <div class="table-cell">'.escape($item->track).'</div>
			                    <div class="table-cell">'.escape($item->format).'</div>
			                    <div class="table-cell">'.escape($item->time).'</div>
			                    <div class="table-cell">'.escape($item->status).'</div>
			                    <div class="table-cell">'.escape($item->titleOfOffering).'</div>
			                </a>
            			';
            			
            		}
            	
            	?>

            </section>
        </section>

    </section>
      

    <footer id="footer">

    </footer>


    <div class="flash-msg <?php if(Session::exists('home')){ echo 'show-msg';} ?>">
        <?php

        if(Session::exists('home')) {

            echo Session::flash('home');
        }
        ?>

    </div>





    <!-- Remodals -->

   <?php

       include_once __DIR__ . '/include/newEmployee.php';

       include_once __DIR__ . '/include/newLead.php';

       include_once __DIR__ . '/include/newCustomer.php';

       include_once __DIR__ . '/include/newContact.php';

       include_once __DIR__ . '/include/newEvent.php';

       include_once __DIR__ . '/include/newWorkshop.php';

       include_once __DIR__ . '/include/newItem.php';

       include_once __DIR__ . '/include/infoProfile.php';



   
    ?>

    </body>
    
    
    </html>

  
  <script>

      $('.tags').tagify({
          whitelist: [<?php echo $tagOptions ?>],
          enforceWhitelist: true,
          autoComplete: true
      });
  
  /* Table sort */

        function changeIcon(n) {


            if(document.getElementById("sort-icon-"+n).classList.contains('fa-sort-up')){
                document.getElementById("sort-icon-"+n).classList.remove('fa-sort-up');
                document.getElementById("sort-icon-"+n).classList.add('fa-sort-down');
            }else{
                document.getElementById("sort-icon-"+n).classList.remove('fa-sort-down');
                document.getElementById("sort-icon-"+n).classList.add('fa-sort-up');
            }



                for(i=0;i<9;i++){
                    if(i !== n){
                        if(document.getElementById("sort-icon-"+i).classList.contains('fa-sort-up')){
                            document.getElementById("sort-icon-"+i).classList.remove('fa-sort-up');
                        }else if(document.getElementById("sort-icon-"+i).classList.contains('fa-sort-down')){
                            document.getElementById("sort-icon-"+i).classList.remove('fa-sort-down');
                        }

                    }
                }

        }


        $('#inventory').addClass('link-selected');


  
  
  </script>

    <?php

include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}