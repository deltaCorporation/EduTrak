<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$inventory = new Inventory();

$tagOptions = '';
if($grups = $inventory->getFilterItems('workshopGroups')){
    foreach ($grups as $group){
        $tagOptions .= "'". $group->workshopGroups . "', ";
    }
    $tagOptions = substr($tagOptions, 0, -2);
}

if($user->isLoggedIn()){
if($user->hasPermission('superAdmin')){

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
        <link href="view/css/tagify.css" rel="stylesheet">

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

    <section id="content-employees">

        <ul id="side-menu">
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
                    <th class="sort" onclick="loadMore(0, 'firstName', this)">First name</th>
                    <th class="sort" onclick="loadMore(0, 'lastName', this)">Last name</th>
                    <th class="sort" onclick="loadMore(0, 'jobTitle', this)">Јob title</th>
                    <th class="sort" onclick="loadMore(0, 'phone', this)">Phone</th>
                    <th class="sort" onclick="loadMore(0, 'email', this)">Email</th>
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

      include_once __DIR__ . '/include/newWorkshop.php';

      include_once __DIR__ . '/include/newItem.php';

      include_once __DIR__ . '/include/infoProfile.php';


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
                url: 'loadEmployees.php',
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

                            let firstName = value.firstName;
                            let lastName = value.lastName;
                            let jobTitle = value.role === null || value.role === '' ? '-' : value.role;
                            let phone = value.phone === null || value.phone === '' ? '-' : value.phone;
                            let email = value.email === null || value.email === '' ? '-' : value.email;

                            html += '<a href="">' +
                                '<tr onclick="window.location = \'profile.php?id='+ value.id +'\'" class="table-list-row">' +
                                '<td></td>' +
                                '<td>'+ firstName +'</td>' +
                                '<td>'+ lastName +'</td>' +
                                '<td>'+ jobTitle +'</td>' +
                                '<td>'+ phone +'</td>' +
                                '<td>'+ email +'</td>' +
                                '</tr>' +
                                '</a>';

                        });

                        if(page === 0){
                            pageNo = 1;
                        }else{
                            page++;
                        }

                        if(sort || checkedFilters){
                            if(result.length === 15) {
                                console.log($('#load-more'))
                                $('#load-more').append('<a onclick="loadMore(' + pageNo + ',\'' + sort + '\', this)">Load more employees</a>');
                            }
                            if(page === 0){
                                $('#table-list-content').html(html);
                            }else{
                                $('#table-list-content').append(html);
                            }
                        }else{
                            if(result.length === 15){
                                $('#load-more').append('<a onclick="loadMore('+ pageNo +', null, this)">Load more employees</a>');
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

        $('#employees').addClass('link-selected');

  </script>

    <?php
    
    }else{


    Redirect::to('index.php');

}



include_once __DIR__ . '/include/scripts.php';

}else{


    Redirect::to('index.php');

}