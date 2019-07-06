<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$lead = new Lead();

//$lead->getFilters();


$maintenance = false;

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

    <div id="filter-menu">
        <div id="filter-menu-header">
            <h2>Filters</h2>
            <a onclick="closeFilters()">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <?php foreach ($lead->getFilters() as $key => $filter): ?>

            <h3><?php echo $filter['title'] ?></h3>

            <ul>

                <?php foreach ($filter['content'] as $content): ?>

                    <?php if($content->$key !== '') : ?>

                        <li>
                            <input id="<?php echo str_replace(' ', '', $content->$key) ?>-filter" class="filter" type="checkbox" value='{"<?php echo $key ?>":"<?php echo $content->$key ?>"}'>
                            <label for="<?php echo str_replace(' ', '', $content->$key) ?>-filter"><?php echo $content->$key ?></label>
                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>

        <?php endforeach; ?>
    </div>

    <section id="content-leads">

        <ul id="side-menu">
            <li>
                <a id="lead-report-link" href="leadsReport.php">
                    <i class="fas fa-file-csv"></i>
                </a>
            </li>
            <li onclick="openFilters()">
                <a id="filters-link">
                    <i class="fas fa-sliders-h"></i>
                </a>
            </li>
        </ul>

<?php

if($maintenance == true && $user->data()->id != 20){
echo '<div style="margin: 20vh; text-align: center;">Sorry this page is under maintenance right now, please come back later!</div>';
}else{

?>

    <div class="table-list">
        <ul class="table-list-header">
            <li class="sort" onclick="loadMore(0, 'firstName', this)">Full Name</li>
            <li class="sort" onclick="loadMore(0, 'company', this)">Company</li>
            <li class="sort" onclick="loadMore(0, 'reachedUsBy', this)">Reached Us By</li>
            <li class="sort" onclick="loadMore(0, 'partnerRep', this)">Partner Rep</li>
            <li class="sort" onclick="loadMore(0, 'assignedTo', this)">Assigned to</li>
            <li class="sort" onclick="loadMore(0, 'officePhone', this)">Office Phone</li>
            <li class="sort" onclick="loadMore(0, 'email', this)">Email</li>
            <li class="sort" onclick="loadMore(0, 'lastContacted', this)">Last Contacted</li>
        </ul>
        <div id="table-list-content">

        </div>
    </div>

<?php } ?>

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

          $('#load-more').remove();

          $.ajax({
              url: 'loadLeads.php',
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
                          let company = value.company === null ? '-' : value.company;
                          let reachedUsBy = value.reachedUsBy === null ? '-' : value.reachedUsBy;
                          let partnerRep = value.partnerRep === null ? '-' : value.partnerRep;
                          let assignedToUser = value.assignedToUser === null ? '-' : value.assignedToUser;
                          let officePhone = value.officePhone === null ? '-' : value.officePhone;
                          let email = value.email;
                          let lastContacted = value.lastContacted;

                          html += '<a href="info.php?case=lead&id='+ value.id +'">' +
                                      '<ul class="table-list-row">' +
                                          '<li>'+ name +'</li>' +
                                          '<li>'+ company +'</li>' +
                                          '<li>'+ reachedUsBy +'</li>' +
                                          '<li>'+ partnerRep +'</li>' +
                                          '<li>'+ assignedToUser +'</li>' +
                                          '<li>'+ officePhone +'</li>' +
                                          '<li>'+ email +'</li>' +
                                          '<li>'+ lastContacted +'</li>' +
                                      '</ul>' +
                                  '</a>';

                      });

                      if(page === 0){
                          pageNo = 1;
                      }else{
                          pageNo++;
                      }

                      if(sort || checkedFilters){
                          if(result.length === 15) {
                              html += '<div id="load-more"><a onclick="loadMore(' + pageNo + ',\'' + sort + '\', this)">Load more leads</a></div>';
                          }
                          if(page === 0){
                              $('#table-list-content').html(html);
                          }else{
                              $('#table-list-content').append(html);
                          }
                      }else{
                          if(result.length === 15){
                              html += '<div id="load-more"><a onclick="loadMore('+ pageNo +', null, this)">Load more leads</a></div>';
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

      $('#leads').addClass("link-selected");
  
  </script>

    <?php

include_once __DIR__ . '/include/scripts.php';

}else{

    Redirect::to('index.php');

}