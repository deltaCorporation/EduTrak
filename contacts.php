<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$contact = new Contact();

if($user->isLoggedIn()){
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
            <div id="logo">Eduscape CRM</div>
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

    <div id="filter-menu">
        <div id="filter-menu-header">
            <h2>Filters</h2>
            <a onclick="closeFilters()">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>

    <section id="content-contacts">

        <ul id="side-menu">
            <li>
                <a id="contacts-report-link" href="contactsReport.php">
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
                    <th class="sort" onclick="loadMore(0, 'firstName', this)">Full Name</th>
                    <th class="sort" onclick="loadMore(0, 'jobTitle', this)">Job Title</th>
                    <th class="sort" onclick="loadMore(0, 'category', this)">Category</th>
                    <th class="sort" onclick="loadMore(0, 'customer', this)">Customer</th>
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
                url: 'loadContacts.php',
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

                            let name = value.firstName + ' ' + value.lastName;
                            let jobTitle = value.jobTitle === null || value.jobTitle === '' ? '-' : value.jobTitle;
                            let category = value.category === null || value.category === '' ? '-' : value.category;
                            let customer = value.customer === null || value.customer === '' ? '-' : value.customer;
                            let officePhone = value.officePhone === null || value.officePhone === '' ? '-' : value.officePhone;
                            let email = value.email === null || value.email === '' ? '-' : value.email;
                            let lastContacted = value.lastContacted === null ? 'Not Contacted' : value.lastContacted;

                            html += '<a href="">' +
                                '<tr onclick="window.location = \'info.php?case=contact&id='+ value.id +'\'" class="table-list-row">' +
                                '<td>'+ name +'</td>' +
                                '<td>'+ jobTitle +'</td>' +
                                '<td>'+ category +'</td>' +
                                '<td>'+ customer +'</td>' +
                                '<td>'+ officePhone +'</td>' +
                                '<td>'+ email +'</td>' +
                                '<td>'+ lastContacted +'</td>' +
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
                                $('#load-more').append('<a onclick="loadMore(' + pageNo + ',\'' + sort + '\', this)">Load more contacts</a>');
                            }
                            if(page === 0){
                                $('#table-list-content').html(html);
                            }else{
                                $('#table-list-content').append(html);
                            }
                        }else{
                            if(result.length === 15){
                                $('#load-more').append('<a onclick="loadMore('+ pageNo +', null, this)">Load more contacts</a>');
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

        $('#contacts').addClass("link-selected");

    </script>
    
    

    <?php
     include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}