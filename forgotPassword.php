<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="google-site-verification" content="Q7P8qM_XSFxL5aBL7WN4AsxdqsI7CPrZcnGNY52Kr0Y" />
        <title>EduTrak | Login page</title>

        <link rel="shortcut icon" type="image/x-icon" href="https://eduscape.com/wp-content/uploads/2017/04/edu-favicon.jpg">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link href="view/css/reset.css" rel="stylesheet">
        <link href="view/css/login-style.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

    <section class="left-sec">
        <div class="image-cover"></div>
    </section>

    <section class="right-sec">
        <div id="login">
            <h1 style="font-size: 30px" class="title">Reset your password</h1>
            <p></p>
            <div id="form-wrapper">
                <form>
                    <div class="login-field">
                        <input type="text" name="email" id="email" placeholder="Your email">
                        <div></div>
                    </div>
                    <div class="login-submit">
                        <button id="submit-form" type="submit"><i class="fa-spin fas fa-spinner"></i>Reset</button>
                    </div>
                </form>
            </div>
            <form class="code-form">
                <input maxlength="1" class="code-input" type="text">
                <input maxlength="1" class="code-input" type="text">
                <input maxlength="1" class="code-input" type="text">
                <input maxlength="1" class="code-input" type="text">
                <input maxlength="1" class="code-input" type="text">
                <input maxlength="1" class="code-input" type="text">
                <div>
                    <i class="fa-spin fas fa-spinner"></i>
                    <div></div>
                </div>
            </form>
        </div>

    </section>

    </body>
    <script>

        let baseEmail = '';

        /* Code Inputs */

        let codeInputs = $('.code-input');
        let firstCodeInput = $('.code-form :first-child');

        firstCodeInput.focus();

        $(codeInputs).on('keypress', function (e) {
            let key   = e.keyCode ? e.keyCode : e.which;

            if(key >= 48 && key <= 57){
                $(this).next().focus();
            }else{
                return false;
            }
        });

        $(codeInputs).on('keyup', function (e) {
            let key   = e.keyCode ? e.keyCode : e.which;
            if(key === 8 || key === 46){
                $(this).prev().focus();
            }

            let ready = true;
            let code = '';

            $(codeInputs).each(function () {
                if($(this).val() === ''){
                    ready = false;
                }else{
                    code += $(this).val();
                }
            });

            if(ready){


                $.ajax({
                    method: "POST",
                    url: "function/email/checkCode.php",
                    data: {
                        email: baseEmail,
                        code: parseInt(code)
                    },
                    beforeSend: function () {
                        $(codeInputs).prop('disabled', true);
                        $('.code-form div i').css('display', 'inline-block');
                        $('.code-form div div').empty();

                    },
                    success: function (result) {

                        let data = JSON.parse(result);

                        if(data){
                            switch (data.status) {

                                case 200:

                                    break;

                                case 404:
                                case 403:
                                    msg.html('Email not found.');
                                    break;

                                case 500:
                                    $(codeInputs).prop('disabled', false);
                                    $('.code-form div i').css('display', 'none');
                                    $('.code-form div div').html('<span>Wrong code</span>');
                                    $('.code-form input:last-of-type').focus();
                                    break;

                                default:
                                    msg.html('Error please try again.');
                                    break;

                            }
                        }
                    },
                });
            }
        });

        /* Submit Form */

        $(document).on('submit', 'form', function (e) {
            e.preventDefault();

            let email = $('#email').val();
            baseEmail = email;
            let msg = $('.login-field div');

            if(email !== ''){
                if(validateEmail(email)){
                    $.ajax({
                        method: "POST",
                        url: "function/email/resetPassword.php",
                        data: {
                            email: email,
                        },
                        beforeSend: function () {
                            $('.login-field div').empty();
                            $('#submit-form').prop('disabled', true);
                            $('#submit-form i').css('display','inline-block');
                        },
                        success: function (result) {
                            $('#submit-form').prop('disabled', false);
                            $('#submit-form i').css('display','none');

                            let data = JSON.parse(result);

                            if(data){

                                switch (data.status) {

                                    case 200:
                                        $('#login h1').empty();
                                        $('#login p').html('<a href="index.php" class="back-to-login">Back to login page</a>');
                                        $('#form-wrapper').empty();
                                        $('.code-form').css('display', 'grid');
                                        $('.code-form input:first-of-type').focus();
                                        break;

                                    case 404:
                                    case 403:
                                        msg.html('Email not found.');
                                        break;

                                    default:
                                        msg.html('Error please try again.');
                                        break;

                                }
                            }
                        },
                    });

                }else{
                    msg.html('Wrong email format.');
                }
            }else{
                msg.html('This field is required.');
            }
        });

        function validateEmail(email) {
            var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/;
            return re.test(String(email).toLowerCase());
        }

    </script>
    </html>