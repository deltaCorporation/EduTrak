<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()){
    if(Input::exists('get') && $requestID = Input::get('id')){

        $request = new Request($requestID);
        $requests = new Request();

        if($request->data()->leadID){
            $client = new Lead($request->data()->leadID);
        }else{
            $client = new Customer($request->data()->clustomerID);
        }

        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>EduTrak</title>

            <link href="view/css/reset.css" rel="stylesheet">
            <link href="view/css/style.css" rel="stylesheet">

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">

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

            <div class="request-information">

                <div class="request-sidebar-information">

                    <div class="request-sidebar-information-name">
                        <div>Request number</div>
                        <div><?php echo $request->data()->ID ?></div>
                        <div>Company Name</div>
                        <div>
                            <?php echo $client->data()->company ? $client->data()->company : $client->data()->name; ?>
                        </div>
                    </div>

                    <div class="request-sidebar-information-submenu">
                        <a href="<?php echo 'info.php?case='.Input::get('case').'&id='.$client->data()->id ?>"><i class="far fa-arrow-alt-circle-left"></i></a>
<!--                        <a><i class="far fa-paper-plane"></i></a>-->
                        <a class="delete-icon" href="#delete"><i class="far fa-trash-alt"></i></a>
                    </div>

                    <div class="request-sidebar-information-name">
                        <div>Status</div>
                        <div>
                            <select onchange="updateStatus(this, '<?php echo $request->data()->ID ?>')" class="request-page-status-select request-status <?php echo $request->data()->colorClass ?>">
                                <?php foreach ($requests->getStatuses() as $status): ?>
                                    <option <?php echo $request->data()->statusID === $status->ID ? 'selected' : '' ?> value="<?php echo $status->ID ?>"><?php echo $status->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>Created on</div>
                        <div><?php echo date('m/d/Y', strtotime($request->data()->insertDate)) ?></div>
                        <div>Created by</div>
                        <div><?php echo $request->data()->createdBy ?></div>
                    </div>
                </div>
                <div class="request-header-information main-request-tab">
                    <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-information', 'block')" id="defaultOpen"><i class="fas fa-chalkboard-teacher"></i>Workshops</button>
                    <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-proposal', 'block')"><i class="fas fa-file-invoice-dollar"></i>Proposal</button>
                    <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-quote', 'block')"><i class="fas fa-receipt"></i>Quote</button>
                </div>
                <div class="request-form-information main-request-tabcontent" id="request-information">

                    <?php foreach ($requests->getRequestWorkshopsByID($request->data()->ID) as $workshop): ?>

                        <button class="request-accordion"><?php echo $workshop->workshopTitle ?></button>
                        <div class="request-panel">
                            <div class="request-panel-block">
                                <label>Description</label>
                                <textarea><?php echo $workshop->workshopDescription ?></textarea>
                            </div>
                            <div class="request-panel-block">
                                <label>Learner Outcomes</label>
                                <textarea><?php echo $workshop->workshopLearnerOutcomes ?></textarea>
                            </div>
                            <div class="request-panel-block">
                                <label>Prerequisites</label>
                                <textarea><?php echo $workshop->workshopPrerequisites ?></textarea>
                            </div>
                            <div class="request-panel-block">
                                <label>MSRP</label>
                                <input class="request-input-price" value="<?php echo number_format((float)$workshop->workshopPrice, 2, '.', ',')  ?>" >
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
                <div class="main-request-tabcontent" id="request-proposal">
                    <div class="request-proposal-content">
                        <div>
                            <label>Proposal Title</label>
                            <input>
                        </div>
                        <div>
                            <label>Introduction</label>
                            <textarea></textarea>
                        </div>
                        <div>
                            <label>Required Investment</label>
                            <textarea></textarea>
                        </div>
                        <div>
                            <label>Presented By</label>
                            <select name="user">
                                <option disabled selected>Select User</option>
                                <option value="48">Alex Urrea</option>
                                <option value="44">Lanie Gordon</option>
                                <option value="190627035028">Katrina Keene</option>
                                <option value="46">Naa Okaine</option>
                                <option value="190712061806">Garrett Eastlake</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="main-request-tabcontent" id="request-quote">
                    <div class="request-quote-content">
                        <div>
                            <label>Quote Title</label>
                            <input>
                        </div>
                    </div>
                </div>

            </div>
            <footer id="footer"></footer>
        </body>

        <script>

            /* Status Change */

            function updateStatus(select, requestID){

                let statusID = select.value;

                $.ajax({
                    method: "GET",
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
                        select.classList.add('request-page-status-select');
                    }
                });
            }

            /* Main Tabs */

            function openRequestTab(evt, tabName, type) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("main-request-tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("main-request-tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" request-active", "");
                }

                if (type === 'block'){
                    document.getElementById(tabName).style.display = "block";
                }else{
                    document.getElementById(tabName).style.display = "grid";
                }
                evt.currentTarget.className += " request-active";
            }

            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();

            /* Accordion */

            var acc = document.getElementsByClassName("request-accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    this.classList.toggle("request-accordion-active");
                    var panel = this.nextElementSibling;
                    if (panel.style.maxHeight){
                        panel.style.maxHeight = null;
                    } else {
                        panel.style.maxHeight = panel.scrollHeight + "px";
                    }
                });
            }

        </script>
        <?php include_once __DIR__ . '/include/scripts.php'; ?>

        </html>

        <?php

    }else{
        Redirect::to('index.php');
    }
}