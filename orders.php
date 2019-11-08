<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$inventory = new Inventory();
$request = new Request();

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

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

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


        <section id="content-orders">
            <ul id="side-menu">
                <li>
                    <a id="orders-report-link" href="ordersReport.php">
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
                        <th class="sort" onclick="loadMore(0, 'firstName', this)">Order ID</th>
                        <th class="sort" onclick="loadMore(0, 'jobTitle', this)">Order Shipped</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Demo/Purchased</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Photon Robot</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Dongle</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Mat</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Lesson Plan A</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Lesson Plan B</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Lesson Plan C</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Flashcards</th>
                        <th class="sort" onclick="loadMore(0, 'company', this)">Stickers</th>
                        <th class="sort" onclick="loadMore(0, 'reachedUsBy', this)">First name</th>
                        <th class="sort" onclick="loadMore(0, 'eventName', this)">Last name</th>
                        <th class="sort" onclick="loadMore(0, 'assignedTo', this)">Company/School</th>
                    </tr>
                    </thead>
                    <tbody id="table-list-content">

                    </tbody>
                </table>
                <div id="load-more"></div>
            </div>
        </section>

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
        <script>

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
                    url: 'loadOrders.php',
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

                                let dateItemsShipped = value.dateItemsShipped === null ? '-' : value.dateItemsShipped;
                                let status = value.status === null || value.status === '' ? '-' : value.status;
                                let firstName = value.firstName === null || value.firstName === '' ? '-' : value.firstName;
                                let lastName = value.lastName === null || value.lastName === '' ? '-' : value.lastName;

                                html += '<a href="">' +
                                            '<tr class="table-list-row">' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.orderID +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ dateItemsShipped +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ status +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.photonRobot +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.dongle +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.mat +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.lessonPlanA +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.lessonPlanB +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.lessonPlanC +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.flashcards +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.stickers +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ firstName +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ lastName +'</td>' +
                                                '<td onclick="window.location = \'info.php?case=lead&id='+ value.orderID +'\'" >'+ value.company +'</td>' +
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
                                    $('#load-more').append('<a onclick="loadMore(' + pageNo + ',\'' + sort + '\', this)">Load more leads</a>');
                                }
                                if(page === 0){
                                    $('#table-list-content').html(html);
                                }else{
                                    $('#table-list-content').append(html);
                                }
                            }else{
                                if(result.length === 15){
                                    $('#load-more').append('<a onclick="loadMore('+ pageNo +', null, this)">Load more leads</a>');
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

            $('.tags').tagify({
                whitelist: [<?php echo $tagOptions ?>],
                enforceWhitelist: true,
                autoComplete: true
            });

            $('#orders').addClass("link-selected");

        </script>
    </html>

    <?php

    include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}