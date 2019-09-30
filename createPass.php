<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();

if($user->isLoggedIn()) {
    if(!$user->isSetup()){

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
                <h1 style="font-size: 30px" class="title">Create your password</h1>
                <form action="updatePass.php" method="post">
                    <div class="login-field">
                        <input type="password" name="password" id="email" placeholder="Your password">
                        <div></div>
            </div>
                    <div class="login-field">
                        <input type="password" name="repeatPass" placeholder="Repeat your password">
                        <div></div>
                    </div>
                    <div class="login-submit">
                        <input type="submit" value="Create">
                    </div>
                </form>
            </div>

        </section>

        </body>
        </html>

        <?php

    }else{
        Redirect::to('index.php');
    }
}else{
    Redirect::to('index.php');
}