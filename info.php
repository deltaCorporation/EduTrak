<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();


if($user->isLoggedIn()){
	if(($case = Input::get('case')) && ($id = Input::get('id'))){
	
	if ($case == 'lead') {
	$case1 = 'link-selected';
	}
	elseif($case == 'contact') { $case2 = 'link-selected';
	}
	elseif ( $case == 'customer') { $case3 = 'link-selected' ;
	}
	

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CRM</title>

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
             <?php
            
            if ($user->hasPermission('superAdmin')){
            echo '
              <a href="employees.php" class="tooltip">
<i class="fas fa-users"></i>
                <span class="tooltiptext">Employees</span>
            </a>

            
            ';
          
            
            } ?>
            <a href="leads.php" class="<?php echo $case1; ?> tooltip">
<i class="far fa-dot-circle"></i>
                <span class="tooltiptext">Leads</span>
            </a>
            <a href="contacts.php" class=" <?php echo $case2 ?> tooltip">
<i class="far fa-address-book"></i>
                <span class="tooltiptext">Contacts</span>
            </a>
            <a href="customers.php" class=" <?php echo $case3 ?>  tooltip">
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

    <?php include_once __DIR__ . '/include/ntf.php'; ?>

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

    <section id="content">

	<?php
		switch ($case){

        case 'lead':
            require_once 'lead.php';
include_once __DIR__ . '/include/transformLead.php';
            break;

        case 'contact':
            require_once 'contact.php';
            break;

        case 'customer':
            require_once 'customer.php';
            break;

    }



$user = new User();

	?>

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

    

    <?php
    include_once __DIR__ . '/include/scripts.php';  
    }else{
    Redirect::to('index.php');
}

}else{

    require_once __DIR__ . '/login.php';

    ?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EduTrak | Login page</title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/login-style.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

    <section class="left-sec">
        <div class="image-cover">

            <img id="logo" src="view/img/Edu%20Man%20white.png">

            <h1 class="title">Welcome to <br> EduTrak</h1>

            <p class="text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas non porttitor sem, a tempor dui.
                Aenean sagittis faucibus nisl, eu tempus felis elementum quis. Pellentesque dapibus eu tellus nec viverra.
                Sed sit amet nisl ut massa malesuada consequat. Maecenas hendrerit orci risus, et lacinia eros sagittis nec.

            </p>

        </div>
    </section>

    <section class="right-sec">

        <div class="tab">
            <a class="tablinks" onclick="openCity(event, 'login')" id="defaultOpen">Login</a>
        </div>

        <form action="" method="post">
            <div id="login" class="tabcontent">
                <div class="login-left">
                    <h2>We will need...</h2>
                    <div class="login-form">
                        <div class="login-forms">
                            <div class="login-field">
                                <input type="text" name="email" id="email" autocomplete="off" value="<?php echo Input::get('email')?>" placeholder="Your email address">
                                <div><?php if(isset($loginErrors['email'])) echo $loginErrors['email']; ?></div>
                            </div>
                            <div class="login-field">
                                <input type="password" name="password" id="password" placeholder="Your password">
                                <div><?php if(isset($loginErrors['password'])) echo $loginErrors['password']; ?></div>
                            </div>
                            <label class="remember-me" for="remember">
                                <input type="checkbox" name="remember" id="remember"> Remember me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="login-middle">
                    <div class="vertical-line"></div>
                    <div class="login-middle-text">Or</div>
                    <div class="vertical-line"></div>
                </div>

                <div class="login-right">
                    <h2>Also You can...</h2>
                    <div class="login-google">
                        <button type="button">
                            Contact us for more information
                        </button>
                    </div>
                </div>
                <div class="login-submit">
                    <input type="hidden" name="token" value="<?php echo Token::generateLogin(); ?>">
                    <input type="submit" value="Login">
                </div>
            </div>
        </form>

    </section>

    </body>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "grid";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

    </html>

    <?php   
    
}

	
?>