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
                $inventory = new Inventory();

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

                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

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
                            <a id="back" href="">
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
                            <div>Request Title</div>
                            <div>
                                <input id="request-title" class="request-title" type="text" value="<?php echo $request->data()->title ?>" >
                            </div>
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
                            <div>Assigned To</div>
                            <div>
                                <select onchange="assignTo(this, '<?php echo $request->data()->ID ?>')" class="request-page-assign-to-select">
                                    <?php foreach ($user->getSalesUsers() as $salesUser): ?>

                                        <option <?php echo $request->data()->assignedTo === $salesUser->ID ? 'selected' : '' ?> value="<?php echo $salesUser->ID ?>" ><?php echo $salesUser->firstName . ' ' . $salesUser->lastName ?></option>

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
                        <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-information', 'block')" id="defaultOpen">
                            <i class="fas fa-chalkboard-teacher"></i>Workshops<?php echo $requests->getRequestWorkshopsByID($request->data()->ID) ? '' : '<i class="warning-icon fas fa-exclamation-circle"></i>' ?>
                        </button>
                        <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-notes', 'grid'), loadRequestNotes(<?php echo $requestID ?>)">
                            <i class="fas fa-sticky-note"></i>Notes
                        </button>
                        <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-proposal', 'block')">
                            <i class="fas fa-file-invoice-dollar"></i>Proposal
                        </button>
                        <button class="main-request-tablinks" onclick="openRequestTab(event, 'request-quote', 'block')"><i
                                    class="fas fa-receipt"></i>Quote
                        </button>
                    </div>
                    <!-- WORKSHOPS TAB CONTENT START -->
                    <form class="request-form-information main-request-tabcontent" id="request-information">
                        <div id="workshops">
                            <div class="request-table-nav">
                                <button type="button" onclick="openWorkshopModal()">+ Add Workshop</button>
                                <div class="clear"></div>
                            </div>

                            <input type="hidden" name="requestID" value="<?php echo $requestID ?>">
                            <?php if($requests->getRequestWorkshopsByID($request->data()->ID)): ?>
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
                            <?php else: ?>

                                <div class="no-workshops">
                                    <i class="warning fas fa-exclamation-circle"></i>
                                    <span>No Workshops</span>
                                </div>

                            <?php endif; ?>
                        </div>
                    </form>
                    <!-- WORKSHOP TAB CONTENT END -->
                    <!-- NOTES TAB CONTENT START -->
                    <div class="main-request-tabcontent" id="request-notes">
                        <div class="request-notes-wrapper">
                            <div class="request-note-content"></div>
                            <div class="content-loader">
                                <i class="fa-spin fas fa-spinner"></i>
                            </div>
                        </div>
                        <div class="request-notes-new">
                            <h6>New Note</h6>
                            <div>
                                <textarea id="note-content" name="content"></textarea>
                            </div>
                            <button id="request-new-note"><i class="fa-spin fas fa-spinner"></i>Add</button>
                        </div>
                    </div>
                    <!-- NOTES TAB CONTENT END -->
                    <!-- PROPOSAL TAB CONTENT START -->
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
                    <!-- PROPOSAL TAB CONTENT END -->
                    <!-- QUOTE TAB CONTENT START -->
                    <div class="main-request-tabcontent" id="request-quote">
                        <div class="request-quote-content">
                            <div>
                                <label>Requisitioner</label>
                                <select id="requisitioner">
                                    <option selected disabled>Please Select Requisitioner</option>
                                    <?php foreach ($userList as $id => $userName): ?>
                                        <option <?php echo (int)$request->data()->requisitioner === $id ? 'selected' : '' ?>
                                                value="<?php echo $id ?>"><?php echo $userName ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                    <!-- QUOTE TAB CONTENT END -->
                </div>
                <footer id="footer"></footer>

                <div class="flash-msg"></div>


                <div id="delete-request-modal" class="modal-overlay">
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

                <div id="delete-note-modal" class="modal-overlay">
                    <div class="modal">
                        <div class="modal-header">
                            <h3>Delete Note</h3>
                            <i class="close fas fa-times"></i>
                        </div>
                        <div class="modal-content">
                            <input type="hidden" data-note="id" value="">
                            <div class="modal-buttons">
                                <button type="button" class="btn-yes" id="delete-note"><i class="fa-spin fas fa-spinner"></i>Yes</button>
                                <button type="button" class="btn-no">No</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overlay"></div>

                <!-- WORKSHOP MODAL START -->
                <div id="workshops-modal">
                    <div class="workshops-popup-header">
                        <h2>Add Workshop</h2>
                        <div>
                            <button class="workshops-popup-close"></button>
                        </div>
                    </div>
                    <form class="workshops-popup-content" method="post">
                        <label>Select Workshop</label>
                        <select id="workshop-select" class="js-example-basic-single">
                            <?php foreach ($inventory->getWorkshops() as $workshop): ?>
                                <option value="<?php echo $workshop->ID  ?>"><?php echo $workshop->titleOfOffering ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="workshops-popup-footer">
                            <button id="add-workshop" type="button"><i class="fa-spin fas fa-spinner"></i>Add</button>
                        </div>
                    </form>
                </div>
                <!-- WORKSHOP MODAL END -->

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

                    $('div[contenteditable]').keydown(function(e) {
                        // trap the return key being pressed
                        if (e.keyCode === 13) {
                            // insert 2 br tags (if only one br tag is inserted the cursor won't go to the next line)
                            document.execCommand('insertHTML', false, '<br><br>');
                            // prevent the default behaviour of return key pressed
                            return false;
                        }
                    });

                    /* Edit Note */

                    function editNote(e){

                        let input = $(e).closest('.request-note').children('.request-note-text').children('.request-note-content-text');
                        let footer = $(e).closest('.request-note').children('.request-note-text').children('.request-note-footer');
                        let box = $(e).closest('.request-note').children('.request-note-text');

                        $(input).prop('contenteditable', true);
                        $(box).addClass('edit-note-border');
                        $(footer).show();
                    }

                    function cancelNoteEdit(e){
                        let input = $(e).closest('.request-note').children('.request-note-text').children('.request-note-content-text');
                        let footer = $(e).closest('.request-note').children('.request-note-text').children('.request-note-footer');
                        let box = $(e).closest('.request-note').children('.request-note-text');

                        $(input).prop('contenteditable', false);
                        $(box).removeClass('edit-note-border');
                        $(footer).hide();
                    }

                    function saveNote(e){

                        let noteID = $(e).closest('.request-note').children('.request-note-text').children('.request-note-content-text').data('note-id');
                        let text = $(e).closest('.request-note').children('.request-note-text').children('.request-note-content-text').html();

                        $.ajax({
                            url: "function/request/editNote.php",
                            type: "POST",
                            data: {
                                noteID: noteID,
                                text: text,
                                requestID: <?php echo $requestID ?>
                            },
                            beforeSend: function (xhr) {
                                $('#save-edit-note .fa-spinner').css("display", "inline-block");
                            },
                            success: function (data) {

                                let result = JSON.parse(data);

                                if (result.status === true) {
                                    $('#save-edit-note .fa-spinner').css("display", "none");

                                    let input = $(e).closest('.request-note').children('.request-note-text').children('.request-note-content-text');
                                    let footer = $(e).closest('.request-note').children('.request-note-text').children('.request-note-footer');
                                    let box = $(e).closest('.request-note').children('.request-note-text');

                                    $(input).prop('contenteditable', false);
                                    $(box).removeClass('edit-note-border');
                                    $(footer).hide();

                                    $('.flash-msg').css('border-left', '4px solid #51c399');
                                    $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Note Saved</span>');
                                    $(".flash-msg").fadeIn();
                                    $(".flash-msg").delay(2500).fadeOut();
                                } else {
                                    $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                                    $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Not saved please refresh your browser</span>');
                                    $(".flash-msg").fadeIn();
                                    $(".flash-msg").delay(2500).fadeOut();
                                }

                            },
                        });

                    }

                    /* Note Menu */

                    $(document).on('click', '.note-menu-link', function (e) {
                        if($(this).find('i').is(e.target) || $(this).is(e.target)){
                            if($(this).next().is(':hidden')){
                                $(".note-menu-wrapper").hide();
                                $(this).next().css('display', 'block');
                            }else{
                                $(this).next().css('display', 'none');
                            }
                        }
                    });

                    $(document).on('click', function (e) {
                        var container = $(".note-menu-wrapper");
                        if($(e.target).hasClass('note-menu-link') || $(e.target).parent().hasClass('note-menu-link')){
                        }else{
                            container.hide();
                        }
                    });

                        /* Load Request Notes */

                    function loadRequestNotes(requestID){
                        $.ajax({
                            url: "function/request/getNotes.php",
                            type: "GET",
                            data: {
                                requestID: requestID
                            },
                            beforeSend: function (xhr) {
                                $('.content-loader').show();
                            },
                            success: function (data) {

                                let result = JSON.parse(data);
                                $('.content-loader').hide();

                                html = '';
                                const monthNames = ["January", "February", "March", "April", "May", "June",
                                    "July", "August", "September", "October", "November", "December"
                                ];

                                if (result.length > 0) {
                                    result.forEach(function (note, index) {

                                        let d = new Date(note.date);

                                        html += '<div class="request-note">' +
                                                    '<div class="request-note-header">' +
                                                        '<span>'+note.user+'</span>' +
                                                        '<span>'+ monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear() + ' ' + formatAMPM(d) +'</span>' +
                                                        '<div class="note-menu-link"><i class="fas fa-bars"></i></div>' +
                                                        '<ul class="note-menu-wrapper">' +
                                                            '<li data-note-id="'+ note.id +'" onclick="editNote(this)"><i class="far fa-edit"></i> Edit</li>' +
                                                            '<li data-note-id="'+ note.id +'" class="delete" onclick="openDeleteNoteModal(this)"><i class="far fa-trash-alt"></i> Delete</li>' +
                                                        '</ul>' +
                                                    '</div>' +
                                                    '<div class="request-note-text">' +
                                                        '<div data-note-id="'+ note.id +'" class="request-note-content-text">'+note.text+'</div>' +
                                                        '<div class="request-note-footer">' +
                                                            '<button onclick="saveNote(this)" id="save-edit-note" type="button"><i class="fas fa-spinner fa-spin"></i> Save</button>' +
                                                            '<button onclick="cancelNoteEdit(this)" type="button">Cancel</button>' +
                                                            '<div class="clear"></div>' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>';
                                    });

                                    $('.request-note-content').html(html);
                                } else {
                                    html = '<div class="no-results">No notes</div>';
                                    $('.request-note-content').html(html);
                                }

                            },
                        });
                    }

                    function formatAMPM(date) {
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var ampm = hours >= 12 ? 'pm' : 'am';
                        hours = hours % 12;
                        hours = hours ? hours : 12; // the hour '0' should be '12'
                        minutes = minutes < 10 ? '0'+minutes : minutes;
                        var strTime = hours + ':' + minutes + ' ' + ampm;
                        return strTime;
                    }

                    /* New Note */

                    $(document).on('click', '#request-new-note', function () {

                        if($("#note-content").val() === ''){
                            $("#note-content").css('border', '1px solid red');
                        }else {

                            $("#note-content").css('border', '1px solid lightgrey');

                            $.ajax({
                                url: "function/request/addNote.php",
                                type: "POST",
                                data: {
                                    requestID: <?php echo $requestID ?>,
                                    text: $("#note-content").val()
                                },
                                beforeSend: function () {
                                    $('#request-new-note .fa-spinner').css("display", "inline-block");
                                    $('#request-new-note').prop('disabled', true);
                                },
                                success: function (data) {

                                    let result = JSON.parse(data);

                                    $('#request-new-note .fa-spinner').hide();
                                    $('#request-new-note').prop('disabled', false);

                                    if (result.status === true) {
                                        loadRequestNotes(<?php echo $requestID ?>);

                                        $('.flash-msg').css('border-left', '4px solid #51c399');
                                        $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Note added</span>');
                                        $(".flash-msg").fadeIn();
                                        $(".flash-msg").delay(2500).fadeOut();
                                    } else {
                                        $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                                        $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Not saved please refresh your browser</span>');
                                        $(".flash-msg").fadeIn();
                                        $(".flash-msg").delay(2500).fadeOut();
                                    }

                                },
                            });
                        }
                    });

                    $('#back').prop('href', document.referrer === location.href ? '<?php echo 'info.php?case=' . Input::get('case') . '&id=' . $client->data()->id ?>' : document.referrer);

                    $('#add-workshop').on('click', function () {

                        $.ajax({
                            url: "function/request/addWorkshop.php",
                            type: "POST",
                            data: {
                                workshopID: $('#workshop-select').val(),
                                requestID: <?php echo $requestID ?>
                            },
                            beforeSend: function (xhr) {
                                $('#add-workshop .fa-spinner').css("display", "inline-block");
                                $('#add-workshop').prop('disabled', true);
                            },
                            success: function (data) {

                                let result = JSON.parse(data);
                                $('#add-workshop').prop('disabled', false);

                                if (result.status === true) {
                                    location.reload();
                                    $('#add-workshop .fa-spinner').css("display", "none");
                                    $('.overlay').hide();
                                    $('#workshops-modal').hide();
                                    // $('.flash-msg').css('border-left', '4px solid #51c399');
                                    // $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Workshop Added</span>');
                                    // $(".flash-msg").fadeIn();
                                    // $(".flash-msg").delay(2500).fadeOut();
                                } else {
                                    $('.overlay').hide();
                                    $('#workshops-modal').hide();
                                    $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                                    $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Error Please Try Again</span>');
                                    $(".flash-msg").fadeIn();
                                    $(".flash-msg").delay(2500).fadeOut();
                                }

                            },
                        });
                    });

                    $(document).ready(function() {
                        $('.js-example-basic-single').select2();
                    });

                    /* Open workshop Modal */
                    function openWorkshopModal() {
                        $('.overlay').show();
                        $('#workshops-modal').show();
                    }

                    $('.workshops-popup-close').on('click', function () {
                        $('#workshops-modal').hide();
                        $('.overlay').hide();
                    });

                    $('.overlay').on('click', function () {
                        $('#workshops-modal').hide();
                        $('.overlay').hide();
                    });

                    /* Delete Note */

                    function openDeleteNoteModal(e){
                        $('#delete-note-modal').css('display', 'grid');
                        $('#delete-note-modal .modal').show();

                        $("input[data-note='id']").val(e.dataset.noteId);
                    }

                    $('#delete-note').click(function () {

                        $('#delete-request').attr('disabled', true);

                        $.ajax({
                            url: "function/request/deleteNote.php",
                            type: "POST",
                            data: {
                                noteID: $("input[data-note='id']").val(),
                                requestID: <?php echo $requestID ?>
                            },
                            beforeSend: function (xhr) {
                                $('#delete-request .fa-spinner').css("display", "inline-block");
                            },
                            success: function (data) {

                                let result = JSON.parse(data);

                                if (result.status === true) {
                                    $('#delete-note-modal').hide();
                                    $('#delete-note-modal .modal').hide();

                                    loadRequestNotes(<?php echo $requestID ?>);

                                    $('.flash-msg').css('border-left', '4px solid #51c399');
                                    $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Note Deleted</span>');
                                    $(".flash-msg").fadeIn();
                                    $(".flash-msg").delay(2500).fadeOut();
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

                    /* Delete */

                    $('.delete-icon').click(function () {
                       $('#delete-request-modal').css('display', 'grid');
                       $('delete-request-modal .modal').show();
                    });

                    $('#delete-request-modal').click(function (event) {
                        if(event.target.className === 'modal-overlay'){
                            $('#delete-request-modal .modal').hide();
                            $(this).hide();
                        }
                    });

                    $('.close, .btn-no').click(function () {
                        $('#delete-request-modal').hide();
                        $('#delete-request-modal .modal').hide();

                        $('#delete-note-modal').hide();
                        $('#delete-note-modal .modal').hide();
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
                            },
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

                    /* Save Titile */

                    var timeoutId;
                    $('#request-title').on('input propertychange change', function () {
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function () {
                            // Runs 1 second (1000 ms) after the last change
                            saveTitle();
                        }, 1000);
                    });

                    function saveTitle(){
                        console.log('Saving to the db');
                        $.ajax({
                            url: "function/request/saveTitle.php",
                            type: "POST",
                            data: {
                                title: $('#request-title').val(),
                                requestID: <?php echo $requestID ?>
                            },
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

                    /* Save Workshop Information */

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

                    /* Save Quote */

                    $('#save-quote').on('click', function () {
                        $('#save-quote .fa-spinner').css("display", "inline-block");
                        $('#save-quote').attr('disabled', true);

                        $.ajax({
                            method: "POST",
                            url: "function/request/saveQuote.php",
                            data: {
                                requisitioner: $('#requisitioner').val(),
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
                            method: "POST",
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

                    /* Status Change */

                    function assignTo(select, requestID) {

                        let assignedTo = select.value;
                        $.ajax({
                            method: "POST",
                            url: "function/request/changeAssignTo.php",
                            data: {
                                assignedTo: assignedTo,
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
}else{
    Redirect::to('index.php');
}