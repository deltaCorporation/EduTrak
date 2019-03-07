<header id="header">
        <button id="open-nav" onclick="w3_open()">&#9776;</button>
        <li>
           <a href="index.php" class=" tooltip">
<i class="fas fa-home"></i>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <a href="calendar.php" class="tooltip">
<i class="far fa-calendar-alt"></i>
                <span class="tooltiptext">Calendar</span>
            </a>
            <?php
            
            if ($user->data()->groupID == 3){
            echo '
              <a href="employees.php" class="tooltip">
<i class="fas fa-users"></i>
                <span class="tooltiptext">Employees</span>
            </a>

            
            ';
          
            
            } ?>            <a href="leads.php" class=" tooltip">
<i class="far fa-dot-circle"></i>
                <span class="tooltiptext">Leads</span>
            </a>
            <a href="contacts.php" class="link-selected tooltip">
<i class="far fa-address-book"></i>
                <span class="tooltiptext">Contacts</span>
            </a>
            <a href="customers.php" class="tooltip">
<i class="fas fa-dollar-sign"></i>
                <span class="tooltiptext">Customers</span>
            </a>
        </li>
       <form class="search" action="#" method="get">
            <input id="txt1" class="search-input" type="text" name="search" placeholder="Search" onkeyup="showHint(this.value)">
            
            <input class="search-submit" type="submit" value="">
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
            <div class="profile-image drop-menu" onclick="myFunction()" style="background: url('<?php echo 'view/img/profile/'.escape($user->data()->img) ?>') no-repeat center; background-size: 5vh;"></div>
            <div class="profile-name drop-menu" onclick="myFunction()"><?php echo escape($user->data()->firstName).' '.escape($user->data()->lastName)?></div>
        </div>
    </header>

    <div class="dropdown">
        <div id="myDropdown" class="dropdown-content">
            <a href="#" data-remodal-target="profile" class="profile-ico">Profile</a>
            <a href="#" class="settings-ico">Settings<span class="notification-sign-yellow">!</span></a>
            <a href="logout.php" class="logout-ico">Log out</a>
        </div>
    </div>