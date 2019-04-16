<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$inventory = new Inventory();

if($user->isLoggedIn()){
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
        </head>
        <body>

        <?php include __DIR__.'/include/header.php'; ?>

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

            $('#hardware').addClass("link-selected");

        </script>
    </html>

    <?php

    include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}