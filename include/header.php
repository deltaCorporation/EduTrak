<header id="header">
    <button id="open-nav" onclick="w3_open()">&#9776;</button>
    <li>
        <a id="home" href="index.php" class="tooltip">
            <i class="fa fa-home"></i>
            <span class="tooltiptext">Dashboard</span>
        </a>
        <a id="calendar" href="calendar.php" class="tooltip">
            <i class="far fa-calendar-alt"></i>
            <span class="tooltiptext">Calendar</span>
        </a>
        <?php

        if ($user->hasPermission('superAdmin')){
            echo '
              <a id="employees" href="employees.php" class="tooltip">
<i class="fas fa-users"></i>
                <span class="tooltiptext">Employees</span>
            </a>

            
            ';


        } ?>            <a id="leads" href="leads.php" class="tooltip">
            <i class="far fa-dot-circle"></i>
            <span class="tooltiptext">Leads</span>
        </a>
        <a id="contacts" href="contacts.php" class="tooltip">
            <i class="far fa-address-book"></i>
            <span class="tooltiptext">Contacts</span>
        </a>
        <a id="customers" href="customers.php" class="tooltip">
            <i class="fas fa-dollar-sign"></i>
            <span class="tooltiptext">Customers</span>
        </a>
        <a id="inventory" href="inventory.php" class="tooltip">
            <i class="fas fa-chalkboard-teacher"></i>
            <span class="tooltiptext">Workshops</span>
        </a>
        <a id="orders" href="orders.php" class="tooltip">
            <i class="fas fa-folder-open"></i>
            <span class="tooltiptext">Orders</span>
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