<?php

require_once __DIR__ . '/../core/ini.php';

$customer = new Customer();
$contact = new Contact();
$lead = new Lead();
$instructors = new User();
$inventory = new Inventory();
?>

<script>

    $(document).on('click', '.kanban-new-request', function () {

        let statusID = this.dataset.requestStatus;

        $('.overlay').show();
        $("div[data-kanban='new-request-popup'").show();
        $("input[data-new-request='status']").val(statusID);
        $("input[data-new-request='title']").val('');
    });

    $(document).on('click', '.overlay, .request-popup-close', function () {
        $("div[data-kanban='new-request-popup'").hide();
        $(".overlay").hide();
    });

    $(document).on('click', '#add-request', function () {

        let companyID = $("#company-select").val().split('-')[0];
        let companyCase = $("#company-select").val().split('-')[1];
        let statusID = $("input[data-new-request='status']").val();
        let requestTitle = $("input[data-new-request='title']").val();

        $.ajax({
            method: "POST",
            url: "function/request/createRequest.php",
            data: {
                statusID: statusID,
                id: companyID,
                case: companyCase,
                title: requestTitle,
                kanban: 1
            },
            beforeSend: function () {
                $("div[data-kanban='new-request-popup'] .fa-spinner").css("display", "inline-block");
                $("#add-request").prop('disabled', true);
            },
            success: function (data) {

                if(JSON.parse(data)){
                    $("#add-request").prop('disabled', false);
                    location.reload();
                }else{
                    $("div[data-kanban='new-request-popup'").hide();
                    $(".overlay").hide();
                    $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                    $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Not saved please refresh your browser</span>');
                    $(".flash-msg").delay(2500).fadeToggle();
                }

            },
        });

    });

        /* Change Dashboard */

    function changeDashboard(type, target){

        let board = $("section[data-type='"+type+"']");
        let boards = $(".board");

        $.each($('#index-board-header button'), function () {
            $(this).removeClass('board-active');
        });

        $.each(boards, function () {
            $(this).hide();
        });

        board.css('display', 'grid');
        target.classList.add('board-active');
    }

    function allowDrop(ev) {
        if(ev.target.dataset.kanban === 'column'){
            ev.preventDefault();
        }
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        console.log(data, ev.target.dataset.id);

        $.ajax({
            method: "POST",
            url: "function/request/updateStatus.php",
            data: {
                statusID: ev.target.dataset.id,
                requestID: data
            },
            beforeSend: function () {
                $('.flash-msg').css('border-left', '4px solid #51c399');
                $('.flash-msg').html('<i class="fas fa-spinner fa-spin"></i><span class="saving">Saving</span>');
                $('.flash-msg').fadeToggle();
            },
            success: function (data) {

                if(JSON.parse(data)){
                    $('.flash-msg').css('border-left', '4px solid #51c399');
                    $('.flash-msg').html('<i class="far fa-check-circle"></i><span class="saving">Saved</span>');
                    $(".flash-msg").delay(2500).fadeToggle();
                }else{
                    $('.flash-msg').css('border-left', '4px solid #CF4D4D');
                    $('.flash-msg').html('<i class="far fa-times-circle"></i><span class="saving">Not saved please refresh your browser</span>');
                    $(".flash-msg").delay(2500).fadeToggle();
                }

            },
        });

        ev.target.appendChild(document.getElementById(data));
    }

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
        let archDiocese = document.getElementById('new-lead-arch-diocese');

        if(cat === 'Public School' || cat === 'Private School' || cat === 'Diocese' || cat === 'District'){

            test.style.display = 'block';
            replace.style.display = 'none';

            if(cat === 'Diocese' || cat === 'Private School'){
                archDiocese.style.display = 'block';
            }else{
                archDiocese.style.display = 'none';
            }

        }else {
            test.style.display = 'none';
            replace.style.display = 'block';

            archDiocese.style.display = 'none';
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

    function saveTravelInfo(link) {
        $.ajax({
            url: 'updateTravelInfo.php',
            type: 'POST',
            data: {
                id: link.parentElement.id,
                field: link.name,
                value: link.value
            },
            success: function () {
                console.log('success');
            }

        });
    }


</script>