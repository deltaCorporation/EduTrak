<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$customer = new Customer();

if($user->isLoggedIn()){
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

   <?php    include_once __DIR__ . '/include/ntf.php';   ?>

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
            <tr class="customer-table-header">
            	<th></th>
                <th onclick="sortTable(1), changeIcon(0)">Name  <i id="sort-icon-0" class=" fas fa-sort"></i></th>
                <th onclick="sortTable(2), changeIcon(1)">Category <i id="sort-icon-1"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(3), changeIcon(2)">Partner Rep <i id="sort-icon-2"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(4), changeIcon(3)">Partner <i id="sort-icon-3"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(5), changeIcon(4)">Parent Customer <i id="sort-icon-4"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(6), changeIcon(5)">Office Phone <i id="sort-icon-5"  class=" fas fa-sort"></i></th>
                <th onclick="sortTable(7), changeIcon(6)">Last Contacted <i id="sort-icon-7"  class=" fas fa-sort"></i></th>
            </tr>


            <?php

            if(!empty($customer->getCustomers())) {

                foreach ($customer->getCustomers() as $customer) {

                    if ($customer->lastContacted == null)
                        $lastContacted = '-';
                    else
                        $lastContacted = $customer->lastContacted;


                    echo "
                    
                        <tr class='customer-table-row'>
                    <td><a href='info.php?case=customer&id={$customer->id}'><i class='fas fa-external-link-alt' style='color: rgba(0,0,0,.8)'></i></a></td>
                    <td>{$customer->name}</td>
                    <td>{$customer->category}</td>
                    <td>{$customer->partnerRep}</td>
                    <td>{$customer->partner}</td>
                    <td>{$customer->parentCustomer}</td>
                    <td>{$customer->officePhone}</td>
                    <td>{$lastContacted}</td>
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
            </tr>
                
                ";
            }

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

        include_once __DIR__ . '/include/newHardware.php';
   
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

        $('#customers').addClass('link-selected');

   </script>
   
    <?php
    
     include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}