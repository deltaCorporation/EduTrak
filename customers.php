<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$customer = new Customer();
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

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">

        <link href="view/css/remodal.css" rel="stylesheet">
        <link href="view/css/remodal-default-theme.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="view/js/jQuery.tagify.min.js"></script>
        <script src="view/js/tagify.js"></script>
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

    <div id="filter-menu">
        <div id="filter-menu-header">
            <h2>Filters</h2>
            <a onclick="closeFilters()">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>

    <section id="content-customers">

        <ul id="side-menu">
            <li>
                <a id="customers-report-link" href="customersReport.php">
                    <i class="fas fa-file-csv"></i>
                </a>
            </li>
            <li onclick="openFilters()">
                <a id="filters-link">
                    <i class="fas fa-sliders-h"></i>
                </a>
            </li>
        </ul>

        <div id="table-wrapper">
            <table class="table-list">
                <thead class="table-list-header">
                <tr>
                    <th></th>
                    <th class="sort" onclick="loadMore(0, 'name', this)">Name</th>
                    <th class="sort" onclick="loadMore(0, 'category', this)">Category</th>
                    <th class="sort" onclick="loadMore(0, 'partnerRep', this)">Partner Rep</th>
                    <th class="sort" onclick="loadMore(0, 'partner', this)">Partner</th>
                    <th class="sort" onclick="loadMore(0, 'parentCustomer', this)">Parent Customer</th>
                    <th class="sort" onclick="loadMore(0, 'officePhone', this)">Office Phone</th>
                    <th class="sort" onclick="loadMore(0, 'email', this)">Email</th>
                    <th class="sort" onclick="loadMore(0, 'lastContacted', this)">Last Contacted</th>
                </tr>
                </thead>
                <tbody id="table-list-content">

                </tbody>
            </table>
            <div id="load-more"></div>
        </div>

    </section>

    <div id="quick-note">
        <div id="quick-note-header">
            <h2>Add Quick Note</h2>
            <a onclick="closeQuickNote()">
                <i class="fas fa-times"></i>
            </a>
        </div>
        <!--        <div class="loader-small">-->
        <!--            <i class="fas fa-spin fa-spinner"></i>-->
        <!--        </div>-->
        <div id="quick-note-content">

        </div>
    </div>

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

       $('.tags').tagify({
           whitelist: [<?php echo $tagOptions ?>],
           enforceWhitelist: true,
           autoComplete: true
       });

       /* Open Filters Menu */

       function openFilters(){
           $('#filter-menu').animate({left: '0'}, 0, 'swing');
       }

       function closeFilters(){
           $('#filter-menu').animate({left: '-250px'}, 0, 'swing');

       }

       /* Load Leads List */

       let pageNo = 0;
       let order = 'ASC';
       let column = '';

       loadMore(0, null, null);

       let filters = $('.filter');
       $.each(filters, function (index, filter) {
           filter.addEventListener('change', function () {
               loadMore(0, null, null);
           })
       });


       function loadMore(page, sort, link){

           let filters = $('.filter');
           let checkedFilters = [];

           $.each(filters, function (index, filter) {
               if(filter.checked){
                   checkedFilters.push(JSON.parse(filter.value));
               }
           });

           if(sort && page === 0){
               if(sort !== column){
                   column = sort;
                   order = 'ASC';

                   let sorts = $('.sort');

                   $.each(sorts, function (index, item) {
                       item.classList.remove('sort-up');
                       item.classList.remove('sort-down');
                   });

                   link.classList.add('sort-up');
               }else{
                   if(order === 'ASC'){
                       order = 'DESC';

                       link.classList.remove('sort-up');
                       link.classList.add('sort-down');
                   }else{
                       order = 'ASC';

                       link.classList.remove('sort-down');
                       link.classList.add('sort-up');
                   }
               }
           }

           $('#load-more').html('');

           $.ajax({
               url: 'loadCustomers.php',
               type: 'GET',
               data: {
                   page: page,
                   sort: sort,
                   order: order,
                   filters: checkedFilters
               },
               success: function (result) {
                   if(result.length > 0){

                       let html = '';

                       $.each(result, function (index, value) {

                           let name = value.name;
                           let category = value.category === null || value.category === '' ? '-' : value.category;
                           let partnerRep = value.partnerRep === null || value.partnerRep === '' ? '-' : value.partnerRep;
                           let partner = value.partner === null || value.partner === '' ? '-' : value.partner;
                           let parentCustomer = value.parentCustomer === null || value.parentCustomer === '' ? '-' : value.parentCustomer;
                           let officePhone = value.officePhone === null || value.officePhone === '' ? '-' : value.officePhone;
                           let email = value.email === null || value.email === '' ? '-' : value.email;
                           let lastContacted = value.lastContacted;

                           html += '<a href="">' +
                               '<tr class="table-list-row">' +
                                   '<td onclick="quickNote('+value.id+')"><i class="far fa-sticky-note"></i></td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ name +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ category +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ partnerRep +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ partner +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ parentCustomer +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ officePhone +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ email +'</td>' +
                                   '<td onclick="window.location = \'info.php?case=customer&id='+ value.id +'\'">'+ lastContacted +'</td>' +
                               '</tr>' +
                               '</a>';

                       });

                       if(page === 0){
                           pageNo = 1;
                       }else{
                           pageNo++;
                       }

                       if(sort || checkedFilters){
                           if(result.length === 15) {
                               console.log($('#load-more'))
                               $('#load-more').append('<a onclick="loadMore(' + pageNo + ',\'' + sort + '\', this)">Load more customers</a>');
                           }
                           if(page === 0){
                               $('#table-list-content').html(html);
                           }else{
                               $('#table-list-content').append(html);
                           }
                       }else{
                           if(result.length === 15){
                               $('#load-more').append('<a onclick="loadMore('+ pageNo +', null, this)">Load more customers</a>');
                           }

                           html += '<div id="load-more"></div>';
                           $('#table-list-content').append(html);
                       }

                   }else{
                       let html = '<div id="load-more"><a>No results</a></div>';
                       $('#table-list-content').html(html);
                   }
               }

           });
       }

       function quickNote(id){
           $('#quick-note').animate({right: '0'}, 0, 'swing');

           let content = $('#quick-note-content');

           content.html('');

           content.html('<input id="quick-note-title" type="text" name="contactNoteTitle" placeholder="Note Title">\n' +
               '            <textarea id="quick-note-text" name="contactNoteContent" placeholder="Note content"></textarea>\n' +
               '            <input id="quick-note-id" type="hidden" value="'+id+'">' +
               '            <div id="quick-note-content-footer">\n' +
               '                <div>\n' +
               '                    <label for="privateNote">\n' +
               '                        <i class="fas fa-lock"></i>\n' +
               '                    </label>\n' +
               '                    <input id="privateNote" type="checkbox" name="contactNotePrivate" value="private">\n' +
               '                    <label for="callNote">\n' +
               '                        <i class="fas fa-phone"></i>\n' +
               '                    </label>\n' +
               '                    <input id="callNote" type="checkbox" name="contactNoteCall" value="call">\n' +
               '                </div>\n' +
               '                <div>\n' +
               '                    <button onclick="addQuickNote()" id="add-quick-note" type="button"><i class="fas fa-spin display-none fa-spinner"></i>Add</button>\n' +
               '                </div>\n' +
               '            </div>');
       }

       function closeQuickNote(){
           $('#quick-note').animate({right: '-350px'}, 0, 'swing');
           $('#quick-note-content').html('');

       }

       function addQuickNote(){

           let title = $('#quick-note-title').val();
           let text = $('#quick-note-text').val();
           let id = $('#quick-note-id').val();
           let private = document.getElementById("privateNote").checked;
           let call = document.getElementById("callNote").checked;

           let validation = true;

           if(title === ''){
               validation = false;
               $('#quick-note-title').addClass('input-error');
           }else{
               $('#quick-note-title').removeClass('input-error');
           }

           if(text === ''){
               validation = false;
               $('#quick-note-text').addClass('input-error');
           }else{
               $('#quick-note-text').removeClass('input-error');
           }

           if(validation === true){
               $.ajax({
                   url: "function/note/addNote.php",
                   type: "POST",
                   data: {
                       id: id,
                       section: 'customer',
                       title: title,
                       text: text,
                       private: private,
                       call: call
                   },
                   beforeSend: function () {
                       $('#add-quick-note .fa-spinner').removeClass('display-none');
                       $('#add-quick-note').prop("disabled",true);
                   },
                   success: function (data) {
                       $('#add-quick-note .fa-spinner').addClass('display-none');
                       $('#add-quick-note').prop("disabled",false);
                       closeQuickNote();

                       let result = JSON.parse(data);

                       if (result.status === true) {
                           $('.flash-msg').fadeToggle();
                           $('.flash-msg').css('border-left', '4px solid #51c399');
                           $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Note Added</span>');
                           $(".flash-msg").delay(2500).fadeToggle();
                       }else{
                           $('.flash-msg').fadeToggle();
                           $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                           $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Not saved please refresh your browser</span>');
                           $(".flash-msg").delay(2500).fadeToggle();
                       }
                   },
               });
           }
       }

       $('#customers').addClass("link-selected");

   </script>
   
    <?php
    
     include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}