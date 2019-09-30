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
            <form>
                <div class="login-field">
                    <input type="text" name="email" id="email" placeholder="Your email">
                    <div></div>
                </div>
                <div class="login-submit">
                    <button id="submit-form" type="button">Reset</button>
                </div>
            </form>
        </div>

    </section>

    </body>
    <script>

        $(document).on('click', '#submit-form', function () {


            let email = $('#email').val();

            if(email !== ''){
                if(validateEmail(email)){
                    $('.login-field div').empty();

                }else{
                    $('.login-field div').html('Wrong email format.');
                }
            }else{
                $('.login-field div').html('This field is required.');
            }
        });

        function validateEmail(email) {
            var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/;
            return re.test(String(email).toLowerCase());
        }

    </script>
    </html>