<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()){
    if(Input::exists('get') && $requestID = Input::get('id')){
        $request = new Request($requestID);

        if(Input::get('case')){

            if($request->exists()) {

                $requests = new Request();

                if ($request->data()->leadID) {
                    $client = new Lead($request->data()->leadID);
                } else {
                    $client = new Customer($request->data()->customerID);
                }

                $userList = [
                    '48' => 'Alex Urrea',
                    '44' => 'Lanie Gordon',
                    '46' => 'Naa Okaine',
                    '190627035028' => 'Katrina Keene',
                    '190712061806' => 'Garrett Eastlake'
                ];

                ?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>EduTrak</title>

                    <link href="view/css/reset.css" rel="stylesheet">
                    <link href="view/css/style.css" rel="stylesheet">

                    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css"
                          integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E"
                          crossorigin="anonymous">

                    <link href="view/css/remodal.css" rel="stylesheet">
                    <link href="view/css/remodal-default-theme.css" rel="stylesheet">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script src="view/js/remodal.js"></script>


                </head>
                <body>

                <?php include __DIR__ . '/include/header.php'; ?>

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

                <div class="request-information">

                    <div class="request-sidebar-information">

                        <div class="request-sidebar-information-submenu">
                            <a href="<?php echo 'info.php?case=' . Input::get('case') . '&id=' . $client->data()->id ?>">
                                <i class="far fa-arrow-alt-circle-left"></i>
                                <span class="tooltip-main">Back</span>
                            </a>
                            <a class="not-available">
                                <i class="far fa-calendar-alt"></i>
                                <span class="tooltip-main">Convert to Event</span>
                            </a>
                            <a class="delete-icon">
                                <i class="far fa-trash-alt"></i>
                                <span class="tooltip-main">Delete</span>
                            </a>
                        </div>

                        <div class="request-sidebar-information-name">
                            <div>Request number</div>
                            <div><?php echo $request->data()->ID ?></div>
                            <div>Company Name</div>
                            <div>
                                <a href="info.php?case=<?php echo Input::get('case') ?>&id=<?php echo $request->data()->leadID ? $request->data()->leadID : $request->data()->customerID ?>">
                                    <?php echo Input::get('case') === 'lead' ? $client->data()->company : $client->data()->name; ?>
                                </a>
                            </div>
                        </div>

                        <div class="request-sidebar-information-name">
                            <div>Status</div>
                            <div>
                                <select onchange="updateStatus(this, '<?php echo $request->data()->ID ?>')"
                                        class="request-page-status-select request-status <?php echo $request->data()->colorClass ?>">
                                    <?php foreach ($requests->getStatuses() as $status): ?>
                                        <option <?php echo $request->data()->statusID === $status->ID ? 'selected' : '' ?>
                                                value="<?php echo $status->ID ?>"><?php echo $status->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>Created on</div>
                            <div><?php echo date('m/d/Y', strtotime($request->data()->insertDate)) ?></div>
                            <div>Created by</div>
                            <div><?php echo $request->data()->createdBy ?></div>
                        </div>

                        <div class="request-sidebar-information-name">
                            <div>Proposal Sent</div>
                            <div>No</div>
                            <div>Quote Sent</div>
                            <div>No</div>
                        </div>
                    </div>
                    <div class="request-header-information main-request-tab">
                        <button class="main-request-tablinks"
                                onclick="openRequestTab(event, 'request-information', 'block')" id="defaultOpen"><i
                                    class="fas fa-chalkboard-teacher"></i>Workshops
                        </button>
                        <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-proposal', 'block')">
                            <i class="fas fa-file-invoice-dollar"></i>Proposal
                        </button>
                        <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-quote', 'block')"><i
                                    class="fas fa-receipt"></i>Quote
                        </button>
                    </div>
                    <form class="request-form-information main-request-tabcontent" id="request-information">

                        <?php foreach ($requests->getRequestWorkshopsByID($request->data()->ID) as $workshop): ?>

                            <button type="button" class="request-accordion"><?php echo $workshop->workshopTitle ?></button>
                            <div class="request-panel">
                                <div class="request-panel-block">
                                    <label>Description</label>
                                    <textarea
                                            name="data[<?php echo $workshop->ID ?>][description]"><?php echo $workshop->workshopDescription ?></textarea>
                                </div>
                                <div class="request-panel-block">
                                    <label>Learner Outcomes</label>
                                    <textarea
                                            name="data[<?php echo $workshop->ID ?>][learnerOutcomes]"><?php echo $workshop->workshopLearnerOutcomes ?></textarea>
                                </div>
                                <div class="request-panel-block">
                                    <label>Prerequisites</label>
                                    <textarea
                                            name="data[<?php echo $workshop->ID ?>][prerequisites]"><?php echo $workshop->workshopPrerequisites ?></textarea>
                                </div>
                                <div class="request-panel-block">
                                    <label>MSRP</label>
                                    <input name="data[<?php echo $workshop->ID ?>][price]" class="request-input-price"
                                           value="<?php echo number_format((float)$workshop->workshopPrice, 2, '.', ',') ?>">
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </form>
                    <div class="main-request-tabcontent" id="request-proposal">
                        <div class="request-proposal-content">
                            <div>
                                <label>Proposal Title</label>
                                <input id="proposalTitle" value="<?php echo $request->data()->proposalTitle ?>">
                            </div>
                            <div>
                                <label>Introduction</label>
                                <textarea
                                        id="proposalIntroduction"><?php echo $request->data()->proposalIntroduction ?></textarea>
                            </div>
                            <div>
                                <label>Required Investment</label>
                                <textarea
                                        id="proposalRequiredInvestment"><?php echo $request->data()->proposalRequiredInvestment ?></textarea>
                            </div>
                            <div>
                                <label>Presented By</label>
                                <select id="proposalPresentedBy" ">
                                <option disabled selected>Select User</option>
                                <?php foreach ($userList as $id => $userName): ?>
                                    <option <?php echo (int)$request->data()->presentedBy === $id ? 'selected' : '' ?>
                                            value="<?php echo $id ?>"><?php echo $userName ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <button id="save-proposal"><i class="fa-spin fas fa-spinner"></i>Save</button>
                            </div>
                        </div>
                        <div class="request-sidebar-information-submenu-additional">
                            <a target="_blank"
                               href="generateProposal.php?case=<?php echo Input::get('case') ?>&id=<?php echo $request->data()->ID ?>&type=preview">
                                <i class="far fa-eye"></i>
                                <span class="tooltip-pq">Preview</span>
                            </a>
                            <a href="generateProposal.php?case=<?php echo Input::get('case') ?>&id=<?php echo $request->data()->ID ?>&type=download">
                                <i class="far fa-arrow-alt-circle-down"></i>
                                <span class="tooltip-pq">Download</span>
                            </a>
                            <a class="not-available">
                                <i class="far fa-paper-plane"></i>
                                <span class="tooltip-pq">Send</span>
                            </a>
                        </div>
                    </div>

                    <div class="main-request-tabcontent" id="request-quote">
                        <div class="request-quote-content">
                            <div>
                                <label>Quote Title</label>
                                <input id="quoteTitle" value="<?php echo $request->data()->quoteTitle ?>">
                            </div>
                            <div>
                                <button id="save-quote"><i class="fa-spin fas fa-spinner"></i>Save</button>
                            </div>
                        </div>
                        <div class="request-sidebar-information-submenu-additional">
                            <a target="_blank"
                               href="generateQuote.php?case=<?php echo Input::get('case') ?>&id=<?php echo $request->data()->ID ?>&type=preview">
                                <i class="far fa-eye"></i>
                                <span class="tooltip-pq">Preview</span>
                            </a>
                            <a href="generateQuote.php?case=<?php echo Input::get('case') ?>&id=<?php echo $request->data()->ID ?>&type=download">
                                <i class="far fa-arrow-alt-circle-down"></i>
                                <span class="tooltip-pq">Download</span>
                            </a>
                            <a class="not-available">
                                <i class="far fa-paper-plane"></i>
                                <span class="tooltip-pq">Send</span>
                            </a>
                        </div>
                    </div>

                </div>
                <footer id="footer"></footer>

                <div class="flash-msg"></div>


                <div class="modal-overlay">
                    <div class="modal">
                        <div class="modal-header">
                            <h3>Delete Request</h3>
                            <i class="close fas fa-times"></i>
                        </div>
                        <div class="modal-content">
                            <div class="modal-buttons">
                                <button type="button" class="btn-yes" id="delete-request"><i class="fa-spin fas fa-spinner"></i>Yes</button>
                                <button type="button" class="btn-no">No</button>
                            </div>
                        </div>
                    </div>
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
                <script>

                    /* Delete */

                    $('.delete-icon').click(function () {
                       $('.modal-overlay').css('display', 'grid');
                       $('.modal').show();
                    });

                    $('.modal-overlay').click(function (event) {
                        if(event.target.className === 'modal-overlay'){
                            $('.modal').hide();
                            $(this).hide();
                        }
                    });

                    $('.close, .btn-no').click(function () {
                        $('.modal-overlay').hide();
                        $('.modal').hide();
                    });

                    $('#delete-request').click(function () {

                        let clientID = <?php echo Input::get('case') === 'lead' ? $request->data()->leadID : $request->data()->customerID ?>;
                        let clientCase = '<?php echo Input::get('case') ?>';

                        $('#delete-request').attr('disabled', true);

                        $.ajax({
                            url: "function/request/deleteRequest.php",
                            type: "POST",
                            data: {
                                requestID: <?php echo $requestID ?>,
                                case: clientCase,
                                id: clientID,
                            }, // serializes the form's elements.
                            beforeSend: function (xhr) {
                                $('#delete-request .fa-spinner').css("display", "inline-block");
                            },
                            success: function (data) {

                                let result = JSON.parse(data);

                                if (result.status === true) {
                                    $('#delete-request .fa-spinner').css("display", "none");
                                    window.location.href = 'info.php?case='+clientCase+'&id='+clientID;
                                } else {
                                    $('.modal-overlay').hide();
                                    $('.modal').hide();
                                    $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                                    $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Request Error Please Try Again</span>');
                                    $(".flash-msg").delay(2500).fadeToggle();
                                }

                            },
                        });
                    });

                    /* Save Workshop Information */

                    var timeoutId;
                    $('form input, form textarea').on('input propertychange change', function () {
                        console.log('Textarea Change');

                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function () {
                            // Runs 1 second (1000 ms) after the last change
                            saveToDB();
                        }, 1000);
                    });

                    function saveToDB() {
                        console.log('Saving to the db');
                        let form = $('#request-information');
                        $.ajax({
                            url: "function/request/saveRequestWorkshop.php",
                            type: "POST",
                            data: form.serialize(), // serializes the form's elements.
                            beforeSend: function (xhr) {
                                $('.flash-msg').css('border-left', '4px solid #51c399');
                                $('.flash-msg').html('<i class="fas fa-spinner fa-spin"></i><span class="saving">Saving</span>');
                                $('.flash-msg').fadeToggle();
                            },
                            success: function (data) {

                                let result = JSON.parse(data);

                                if (result.status === true) {
                                    $('.flash-msg').css('border-left', '4px solid #51c399');
                                    $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Saved</span>');
                                    $(".flash-msg").delay(2500).fadeToggle();
                                } else {
                                    $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                                    $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Not saved please refresh your browser</span>');
                                    $(".flash-msg").delay(2500).fadeToggle();
                                }

                            },
                        });
                    }

                    /* Hover Tooltips */

                    $('.request-sidebar-information-submenu-additional a').hover(function () {
                        $(this).children(":first").next().show();
                    }, function () {
                        $(this).children(":first").next().hide();
                    });

                    $('.request-sidebar-information-submenu a').hover(function () {
                        $(this).children(":first").next().show();
                    }, function () {
                        $(this).children(":first").next().hide();
                    });

                    $('.tooltip-main').each(function () {

                        let eWidth = $(this).outerWidth();
                        let pWidth = $(this).parent().outerWidth();

                        let left = eWidth > pWidth ? '-' + (eWidth - pWidth) / 2 : (pWidth - eWidth) / 2;

                        $(this).css('left', left + 'px');
                    });

                    /* Save Proposal */

                    $('#save-proposal').on('click', function () {
                        $('#save-proposal .fa-spinner').css("display", "inline-block");
                        $('#save-proposal').attr('disabled', true);

                        $.ajax({
                            method: "POST",
                            url: "function/request/saveProposal.php",
                            data: {
                                proposalTitle: $('#proposalTitle').val(),
                                proposalIntroduction: $('#proposalIntroduction').val(),
                                proposalRequiredInvestment: $('#proposalRequiredInvestment').val(),
                                proposalPresentedBy: $('#proposalPresentedBy').val(),
                                requestID: <?php echo $request->data()->ID ?>
                            }
                        }).done(function (result) {
                            $('#save-proposal .fa-spinner').css("display", "none");
                            $('#save-proposal').attr('disabled', false);

                            $('.flash-msg').html('Proposal Saved');
                            $('.flash-msg').fadeToggle();
                            $(".flash-msg").delay(2000).fadeToggle();

                        });

                    });

                    /* Save Proposal */

                    $('#save-quote').on('click', function () {
                        $('#save-quote .fa-spinner').css("display", "inline-block");
                        $('#save-quote').attr('disabled', true);

                        $.ajax({
                            method: "POST",
                            url: "function/request/saveQuote.php",
                            data: {
                                quoteTitle: $('#quoteTitle').val(),
                                requestID: <?php echo $request->data()->ID ?>
                            }
                        }).done(function (result) {
                            $('#save-quote .fa-spinner').css("display", "none");
                            $('#save-quote').attr('disabled', false);

                            $('.flash-msg').html('Quote Saved');
                            $('.flash-msg').fadeToggle();
                            $(".flash-msg").delay(2000).fadeToggle();

                        });

                    });

                    /* Status Change */

                    function updateStatus(select, requestID) {

                        let statusID = select.value;
                        $.ajax({
                            method: "GET",
                            url: "function/request/updateStatus.php",
                            data: {
                                statusID: statusID,
                                requestID: requestID
                            },
                            beforeSend: function (xhr) {
                                $('.flash-msg').css('border-left', '4px solid #51c399');
                                $('.flash-msg').html('<i class="fas fa-spinner fa-spin"></i><span class="saving">Saving</span>');
                                $('.flash-msg').fadeToggle();
                            },
                            success: function (result) {

                                if (result) {
                                    let data = JSON.parse(result);

                                    select.className = '';
                                    select.classList.add(data.colorClass);
                                    select.classList.add('request-status');
                                    select.classList.add('request-page-status-select');

                                    $('.flash-msg').css('border-left', '4px solid #51c399');
                                    $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Saved</span>');
                                    $(".flash-msg").delay(2500).fadeToggle();
                                }
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

                        if (type === 'block') {
                            document.getElementById(tabName).style.display = "block";
                        } else {
                            document.getElementById(tabName).style.display = "grid";
                        }
                        evt.currentTarget.className += " request-active";

                        $('.tooltip-pq').each(function () {

                            let eWidth = $(this).outerWidth();
                            let pWidth = $(this).parent().outerWidth();

                            let left = eWidth > pWidth ? '-' + (eWidth - pWidth) / 2 : (pWidth - eWidth) / 2;

                            $(this).css('left', left + 'px');
                        });
                    }

                    // Get the element with id="defaultOpen" and click on it
                    document.getElementById("defaultOpen").click();

                    /* Accordion */

                    var acc = document.getElementsByClassName("request-accordion");
                    var i;

                    for (i = 0; i < acc.length; i++) {
                        acc[i].addEventListener("click", function () {
                            this.classList.toggle("request-accordion-active");
                            var panel = this.nextElementSibling;
                            if (panel.style.maxHeight) {
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
        }else{
            Redirect::to('index.php');
        }
    }else{
        Redirect::to('index.php');
    }
}