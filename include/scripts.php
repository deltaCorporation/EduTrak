<?php

require_once __DIR__ . '/../core/ini.php';

$customer = new Customer();
$contact = new Contact();
$lead = new Lead();
$instructors = new User();
$inventory = new Inventory();
?>

<script>

    /* Open Event Window */


            function openEventWindow(id) {

                var eventWindow = document.getElementById('update-event-window');
                eventWindow.style.display = 'block';

                var closeWindow = document.getElementById('close-event-window');
                closeWindow.addEventListener("click", function () {
                    eventWindow.style.display = 'none';
                })

                eventWindow.addEventListener("click", function (e) {
                    if (!eventWindow.firstElementChild.contains(e.target)) {
                        eventWindow.style.display = 'none';
                    }
                })

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        eventWindow.firstElementChild.lastElementChild.innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getEvent.php?q=" + id, true);
                xmlhttp.send();
            }


    /* WINDOWS */

    function extendLead(){

        var cat = document.getElementById("lead-category").value;
        var test = document.getElementById("additional-info-button");
        var replace = document.getElementById("replace-block");

        if(cat === 'Public School' || cat === 'Private School' || cat === 'Diocese' || cat === 'District'){

            test.style.display = 'block';
            replace.style.display = 'none';

        }else {
            test.style.display = 'none';
            replace.style.display = 'block';
        }
    }
    
    function extendCustomer(){

        var cat = document.getElementById("customer-category").value;
        var test = document.getElementById("customer-additional-info-button");
        var replace = document.getElementById("customer-replace-block");

        if(cat === 'Public School' || cat === 'Private School' || cat === 'Diocese' || cat === 'District'){

            test.style.display = 'block';
            replace.style.display = 'none';

        }else {
            test.style.display = 'none';
            replace.style.display = 'block';
        }
    }

    function openWindowTab(evt, tab) {

        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("add-window-form");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("add-window-tab");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
        }

        document.getElementById(tab).style.display = "block";
        evt.currentTarget.className += " active-tab";
    }


    function show(link, defaultTab) {
        var windowID = document.getElementById(link);
        var windowClass = windowID.closest('.add-window');
        windowClass.style.display = 'block';

        document.getElementById(defaultTab).click();
    }

    var closeWindow = document.getElementsByClassName('window-close');
    for(var i = 0; i < closeWindow.length; i++){
        closeWindow[i].addEventListener('click', function () {
            var window = this.closest('.add-window');
            window.style.display = 'none';
        })
    }

    /* WINDOWS END */


        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("sidebar-dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }


        /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.drop-menu')) {

                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        };

        $(document).ready(function(){

            if($(".flash-msg").hasClass("show-msg")){

                $(".flash-msg").fadeToggle();
                $(".flash-msg").delay(2500).fadeToggle();
            }

            $(".search-input").focus(function () {
                $('.search').css('background-color', 'rgba(255,255,255,.8)');
            })

            $(".search-input").focusout(function () {
                $('.search').css('background-color', 'transparent');
            })

            $("#close-nav").click(function(){
                $('#index-sidebar').animate({left: '-20%'}, 0);
                $('#open-nav').css('display', 'block');
                $('#header').css({
                    'margin-left':'0',
                    'grid-template-columns': '7vh auto auto 6vh 6vh 6vh auto'
                });
                $('#index-board').css('margin-left', '0');
                $('#footer').css('margin-left', '0');
            });

            $("#open-nav").click(function(){
                $('#index-sidebar').animate({left: '0'}, 0);
                $('#open-nav').css('display', 'none');
                $('#header').css({
                    'margin-left':'20%',
                    'grid-template-columns': 'auto auto 6vh 6vh 6vh auto'
                });
                $('#index-board').css('margin-left', '20%');
                $('#footer').css('margin-left', '20%');

            });


            $(".msg-open").click(function () {
                $('#msg-sidebar').animate({right: '0'}, 0);
                $('#ntf-sidebar').animate({right: '-25%'}, 0);
                $('#add-sidebar').animate({right: '-25%'}, 0);
            });

            $(".ntf-open").click(function () {
                $('#ntf-sidebar').animate({right: '0'}, 0);
                $('#msg-sidebar').animate({right: '-25%'}, 0);
                $('#add-sidebar').animate({right: '-25%'}, 0);
            });

            $(".add-open").click(function () {
                $('#add-sidebar').animate({right: '0'}, 0);
                $('#msg-sidebar').animate({right: '-25%'}, 0);
                $('#ntf-sidebar').animate({right: '-25%'}, 0);
            });

            $(".add-close").click(function () {
                $('#add-sidebar').animate({right: '-25%'}, 0);
            })

            $(".msg-close").click(function () {
                $('#msg-sidebar').animate({right: '-25%'}, 0);
            })

            $(".ntf-close").click(function () {
                $('#ntf-sidebar').animate({right: '-25%'}, 0);
            })
        });


        /* Profile tabs */

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();



        /* Auto Complete */

    function getWorkshops(input) {

        var autocompleteWrapper = input.nextElementSibling;

        if(input.value.length === ''){
            autocompleteWrapper.style.display = 'none';
            input.style.borderBottomLeftRadius = '.25rem';
            input.style.borderBottomRightRadius = '.25rem';
        }else {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    autocompleteWrapper.style.display = 'block';
                    autocompleteWrapper.innerHTML = this.responseText;
                    input.style.borderBottomLeftRadius = 0;
                    input.style.borderBottomRightRadius = 0;
                }
            };
            xmlhttp.open("GET", "getWorkshops.php?q=" + input.value, true);
            xmlhttp.send();

        }

    }

    function selectWorkshop(link) {
        var input = link.parentElement.previousElementSibling;
        var autocompleteWrapper = link.parentElement;

        input.value = link.innerHTML;
        autocompleteWrapper.style.display = 'none';
        input.style.borderBottomLeftRadius = '.25rem';
        input.style.borderBottomRightRadius = '.25rem';
    }
    
  

        function getCustomers(input) {

            var autocompleteWrapper = input.nextElementSibling;

            if(input.value.length === ''){
                autocompleteWrapper.style.display = 'none';
                input.style.borderBottomLeftRadius = '.25rem';
                input.style.borderBottomRightRadius = '.25rem';
            }else {

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        autocompleteWrapper.style.display = 'block';
                        autocompleteWrapper.innerHTML = this.responseText;
                        input.style.borderBottomLeftRadius = 0;
                        input.style.borderBottomRightRadius = 0;
                    }
                };
                xmlhttp.open("GET", "getCustomers.php?q=" + input.value, true);
                xmlhttp.send();

            }

        }

        function selectCustomer(link) {
            var input = link.parentElement.previousElementSibling;
            var autocompleteWrapper = link.parentElement;

            input.value = link.innerHTML;
            autocompleteWrapper.style.display = 'none';
            input.style.borderBottomLeftRadius = '.25rem';
            input.style.borderBottomRightRadius = '.25rem';
        }


    function getPartner(input) {

        var autocompleteWrapper = input.nextElementSibling;

        if(input.value.length === ''){
            autocompleteWrapper.style.display = 'none';
            input.style.borderBottomLeftRadius = '.25rem';
            input.style.borderBottomRightRadius = '.25rem';
        }else {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    autocompleteWrapper.style.display = 'block';
                    autocompleteWrapper.innerHTML = this.responseText;
                    input.style.borderBottomLeftRadius = 0;
                    input.style.borderBottomRightRadius = 0;
                }
            };
            xmlhttp.open("GET", "getPartners.php?q=" + input.value, true);
            xmlhttp.send();

        }

    }

    function selectPartner(link) {
        var input = link.parentElement.previousElementSibling;
        var autocompleteWrapper = link.parentElement;

        input.value = link.innerHTML;
        autocompleteWrapper.style.display = 'none';
        input.style.borderBottomLeftRadius = '.25rem';
        input.style.borderBottomRightRadius = '.25rem';
    }

        function getUsers(input) {

            var autocompleteWrapper = input.nextElementSibling;

            if(input.value.length === ''){
                autocompleteWrapper.style.display = 'none';
                input.style.borderBottomLeftRadius = '.25rem';
                input.style.borderBottomRightRadius = '.25rem';
            }else {

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        autocompleteWrapper.style.display = 'block';
                        autocompleteWrapper.innerHTML = this.responseText;
                        input.style.borderBottomLeftRadius = 0;
                        input.style.borderBottomRightRadius = 0;
                    }
                };
                xmlhttp.open("GET", "getUsers.php?q=" + input.value, true);
                xmlhttp.send();

            }

        }

    function selectUsers(link) {
        var input = link.parentElement.previousElementSibling;
        var autocompleteWrapper = link.parentElement;

        input.value = link.innerHTML;
        autocompleteWrapper.style.display = 'none';
        input.style.borderBottomLeftRadius = '.25rem';
        input.style.borderBottomRightRadius = '.25rem';
    }

        function closeAutoselect(elmnt) {
            var input = document.getElementsByClassName("autocomplete-input");
            var x = document.getElementsByClassName("autocomplete-item");

            for (var i = 0; i < x.length; i++) {
                for (var j = 0; j < input.length; j++){
                    if (elmnt !== x[i] && elmnt !== input[j]) {
                        var autoselectWrapper = input[j].nextElementSibling;
                        autoselectWrapper.style.display = 'none';
                        input[j].style.borderBottomLeftRadius = '.25rem';
                        input[j].style.borderBottomRightRadius = '.25rem';
                    }
                }

            }
        }

    document.addEventListener("click", function (e) {
        closeAutoselect(e.target);
    });

        /* Add Instructor */

    function addInstructor(id) {

        var row = document.getElementById(id);

        var newCell = document.createElement('div');
        newCell.classList.add('add-window-form-section-cell');
        newCell.classList.add('form-x-4');

        var newLabel = document.createElement('label');

        var newSelect = document.createElement('select');
        newSelect.name = 'instructors[]';

        <?php

        foreach ($user->getUsersPermissions() as $instructor){
            if($instructor->permission == 'instructor'){
                echo "
                
                    var newInstructor = document.createElement('option');
                    newInstructor.value = ".$instructor->id.";
                    
                    var newText = document.createTextNode('".$instructor->firstName." ".$instructor->lastName."');
                    
                    newInstructor.appendChild(newText);
                    newSelect.appendChild(newInstructor);
                
                ";
            }
        }

        ?>

        newCell.appendChild(newLabel);
        newCell.appendChild(newSelect);
        row.appendChild(newCell);

    }
    
    function removeInstructor(id) {
        var row = document.getElementById(id);
        var lastInstructor = row.lastElementChild;

        if(row.childElementCount > 1){
            row.removeChild(lastInstructor);
        }
    }


</script>