<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()){
if($user->hasPermission('superAdmin')){

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
            <a href="employees.php" class="link-selected tooltip">
<i class="fas fa-users"></i>
                <span class="tooltiptext">Employees</span>
            </a>
            <a href="leads.php" class=" tooltip">
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
<a href="inventory.php" class="tooltip">
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
            <div class="profile-image drop-menu" onclick="myFunction()" style="background: url('<?php echo 'view/img/profile/'.escape($user->data()->img) ?>') no-repeat center; background-size: 4vh;"></div>
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
            
        </div>
    </aside>

    <section id="content">
        <table id="myTable">
            <tr class='employee-table-header'>
            	<th></th>
                <th onclick="sortTable(1), changeIcon(0)">First name <i id="sort-icon-0" class=" fas fa-sort"></i></th>
                <th onclick="sortTable(2), changeIcon(1)">Last name  <i id="sort-icon-1"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(3), changeIcon(2)">Јob title <i id="sort-icon-2"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(4), changeIcon(3)">Phone <i id="sort-icon-3"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(5), changeIcon(4)">Email <i id="sort-icon-4"  class=" fas fa-sort"></i></th>
          
            </tr>


            <?php
            
            $users = new User();

            if(!empty($users->getUsers())) {

                foreach ($users->getUsers() as $user) {

                    


                    echo "
                    
                        <tr class='employee-table-row'>
                    <td><a href='profile.php?id={$user->id}'><div class='employees-profile-image' style='background: url(\"view/img/profile/{$user->img}\") no-repeat center; background-size: 5vh;'></div></a></td>    
                    <td>{$user->firstName} </td>
                    <td>{$user->lastName}</td>
                    <td>{$user->role}</td>
                    <td>{$user->phone}</td>
                    <td>{$user->email}</td>
                    
                    
                </tr>
                    
                    ";


                }
            }else{
                echo "
                
                    <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
                
                ";
            }

$user = new User();

            ?>

        </table>
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

  include_once __DIR__ . '/include/newItem.php';
	
	include_once __DIR__ . '/include/infoProfile.php';
   
    ?>

    </body>
    </html>

    <script>
  
  /* Table sort */

        function changeIcon(n) {


            if(document.getElementById("sort-icon-"+n).classList.contains('fa-sort-up')){
                document.getElementById("sort-icon-"+n).classList.remove('fa-sort-up');
                document.getElementById("sort-icon-"+n).classList.add('fa-sort-down');
            }else{
                document.getElementById("sort-icon-"+n).classList.remove('fa-sort-down');
                document.getElementById("sort-icon-"+n).classList.add('fa-sort-up');
            }



                for(i=0;i<7;i++){
                    if(i !== n){
                        if(document.getElementById("sort-icon-"+i).classList.contains('fa-sort-up')){
                            document.getElementById("sort-icon-"+i).classList.remove('fa-sort-up');
                        }else if(document.getElementById("sort-icon-"+i).classList.contains('fa-sort-down')){
                            document.getElementById("sort-icon-"+i).classList.remove('fa-sort-down');
                        }

                    }
                }

        }





        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.getElementsByTagName("TR");
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
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
  
  </script>

    <?php
    
    }else{


    Redirect::to('index.php');

}



include_once __DIR__ . '/include/scripts.php';

}else{


    Redirect::to('index.php');

}